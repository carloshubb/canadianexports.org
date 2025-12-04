<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CustomerProfileResource;
use App\Imports\BusinessProfilesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BusinessCategoryDetail;
use App\Models\Customer;
use App\Models\VisitorInfo;
use Illuminate\Support\Facades\Mail;
use App\Mail\VisitorInfoMail;
use App\Models\CustomerBusinessCategory;
use App\Models\CustomerGalleryImage;
use App\Models\CustomerMedia;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Rules\ValidUrl;
use App\Traits\FileUploadTrait;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\CustomerResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class BusinessProfileController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $customerProfiles = CustomerProfile::whereHas('customer', function ($q) {
            $q->where('type', 'customer');
        });
        $customerProfiles = $this->whereClause($customerProfiles);
        $customerProfiles = $this->loadRelations($customerProfiles);
        $customerProfiles = $this->sortingAndLimit($customerProfiles);

        return $this->apiSuccessResponse(CustomerProfileResource::collection($customerProfiles), 'Data Get Successfully!');
    }

    public function show($customerProfile)
    {
        $customerProfile = CustomerProfile::whereId($customerProfile);
        $customerProfile = $this->loadRelations($customerProfile);
        $customerProfile = $customerProfile->firstOrFail();
        return $this->apiSuccessResponse(new CustomerProfileResource($customerProfile), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $request['gallery_images'] = json_decode($request->gallery_images);
        $niceNames = ['business_categories_id' => 'business category', 'customer_id' => 'customer', 'registration_package_id' => 'registration package'];
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\Customer,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
            'payment_frequency' => ['required', 'in:monthly,quarterly,semi_annually,annually'],
            'registration_package_id' => ['required', 'exists:App\Models\RegistrationPackage,id'],
            'business_categories_id' => ['required', 'array', 'max:3'],
            'business_categories_id.*' => ['required', 'exists:App\Models\BusinessCategory,id'],
            'mailing_address' => ['required', 'string'],
            'company_email' => ['required', 'email'],
            'company_name' => ['required', 'string'],
            'description' => ['required', 'string', 'maxwords:300'],
            'keywords' => ['required', 'string'],
            'company_phone' => ['required', 'string', 'max:14'],
            'short_description' => ['required', 'string', 'maxwords:30'],
            'website' => ['required', new ValidUrl()],
            // 'cta_link' => ['required', new ValidUrl()],
            // 'cta_btn' => ['required', 'string'],
            'media_title' => ['nullable', 'string', 'maxwords:10'],
            'media_description' => ['nullable', 'string', 'maxwords:50'],
            'video' => ['nullable', new ValidUrl()],
            'logo' => ['nullable', 'string'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable'],
            'facebook' => ['nullable', new ValidUrl()],
            'linked_in' => ['nullable', new ValidUrl()],
            'twitter' => ['nullable', new ValidUrl()],
            'youtube' => ['nullable', new ValidUrl()],
        ];
        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );

        $package = getRegistrationPackage($request->registration_package_id);

        if ($request->payment_frequency == 'monthly') {
            $packagePrice = $package->monthly_price;
            $eventsAllowed = $package->events_allowed;
            $package_validity = date('Y-m-d', strtotime('+1 months'));
            $packageValidity = '1 month';
        } else if ($request->payment_frequency == 'quarterly') {
            $eventsAllowed = $package->events_allowed;
            $packagePrice = $package->quarterly_price * 3;
            $package_validity = date('Y-m-d', strtotime('+3 months'));
            $packageValidity = '3 months';
        } else if ($request->payment_frequency == 'semi_annually') {
            $eventsAllowed = $package->events_allowed;
            $packagePrice = $package->semi_annually_price * 6;
            $package_validity = date('Y-m-d', strtotime('+6 months'));
            $packageValidity = '6 months';
        } else if ($request->payment_frequency == 'annually') {
            $eventsAllowed = $package->events_allowed;
            $packagePrice = $package->annually_price * 12;
            $package_validity = date('Y-m-d', strtotime('+12 months'));
            $packageValidity = '12 months';
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_auto_renew' => isset($request->is_auto_renew) && $request->is_auto_renew == 'true' ? 1 : 0,
            'is_active' => 1,
            'verify_customer_email' => 1,
            'password' => Hash::make($request->password),
            'type' => 'customer',
            'registration_package_id' => $request->registration_package_id,
            'payment_frequency' => $request->payment_frequency,
            'package_price' => $packagePrice,
            'package_subscribed_date' => date('Y-m-d'),
            'package_expiry_date' => $package_validity,
            'is_package_amount_paid' => 1,
            'events_allowed' => $eventsAllowed,
            'events_remaining' => $eventsAllowed,
            'images_allowed' => isset($package) ? $package->images_allowed : 0,
        ]);

        $customerId = $customer->id;


        $customerProfile = CustomerProfile::create([
            'company_name' => $request->company_name,
            'slug' => $this->generateUniqueSlug($request->company_name),
            'company_email' => $request->company_email,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'phone' => $request->company_phone,
            // 'cta_link' => $request->cta_link,
            // 'cta_btn' => $request->cta_btn,
            'website' => $request->website,
            'keywords' => $request->keywords,
            'address' => $request->mailing_address,
            'customer_id' => $customerId
        ]);
        $businessCategoriesName = [];
        $defaulLang = getDefaultLanguage();
        foreach ($request->business_categories_id as $business_category_id) {
            $businessCategoriesName[] = BusinessCategoryDetail::whereBusinessCategoryId($business_category_id)->where('language_id', $defaulLang->id)->value('name');
            CustomerBusinessCategory::create([
                'business_category_id' => $business_category_id,
                'customer_id' => $customerId,
                'customer_profile_id' => $customerProfile->id,
            ]);
        }

        if (isset($request->logo)) {
            $media = json_decode($request->logo, 1);
            $files = $this->moveFile($media, 'media/customers', 'profile_logo');
        }


        $customerMedia = CustomerMedia::create([
            "title" => $request->media_title,
            "description" => $request->media_description,
            "logo" => isset($files, $files[0]) ? $files[0]->id : null,
            "video" => $request->video,
            "video_frame" => getVideoHtmlAttribute($request->video),
            "customer_id" => $customerId,
            'customer_profile_id' => $customerProfile->id,
        ]);

        if (isset($request->gallery_images)) {
            $galleryImages = $this->moveFile($request->gallery_images, 'media/customers', 'profile_gallery_images');
        }

        if (isset($galleryImages)) {
            foreach ($galleryImages as $key => $image) {
                CustomerGalleryImage::create([
                    'customer_media_id' => $customerMedia->id,
                    'media_id' => $image->id,
                ]);
            }
        }

        CustomerSocialMedia::create([
            "facebook" => $request->facebook,
            "twitter" => $request->twitter,
            "youtube" => $request->youtube,
            "linked_in" => $request->linked_in,
            "customer_id" => $customerId,
            'customer_profile_id' => $customerProfile->id,
        ]);
        return $this->successResponse([], 'Your exporter profile has been created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $request['gallery_images'] = json_decode($request->gallery_images);
        $niceNames = ['business_categories_id' => 'business category', 'customer_id' => 'customer', 'registration_package_id' => 'registration package'];
        $validationRule = [
            'id' => ['required', 'exists:customer_profile,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\Customer,email,' . $request->customer_id],
            'password' => ['nullable', 'confirmed', Password::min(8)->mixedCase()],
            'business_categories_id' => ['required', 'array', 'max:3'],
            'business_categories_id.*' => ['required', 'exists:App\Models\BusinessCategory,id'],
            'mailing_address' => ['required', 'string'],
            'company_email' => ['required', 'email'],
            'company_name' => ['required', 'string'],
            'description' => ['required', 'string', 'maxwords:3000'],
            'keywords' => ['required', 'string'],
            'company_phone' => ['required', 'string'],
            'short_description' => ['required', 'string', 'maxwords:30'],
            'website' => ['required', new ValidUrl()],
            // 'cta_btn' => ['required', 'string'],
            // 'cta_link' => ['required', new ValidUrl()],
            'media_title' => ['nullable', 'string', 'maxwords:10'],
            'media_description' => ['nullable', 'string', 'maxwords:50'],
            'video' => ['nullable', new ValidUrl()],
            'logo' => ['nullable', 'string'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable'],
            'facebook' => ['nullable', new ValidUrl()],
            'linked_in' => ['nullable', new ValidUrl()],
            'twitter' => ['nullable', new ValidUrl()],
            'youtube' => ['nullable', new ValidUrl()],
        ];

        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );

        $package = getRegistrationPackage($request->registration_package_id);
        $customer = Customer::whereId($request->customer_id)->first();

        if ($customer->registration_package_id != $request->registration_package_id || $customer->payment_frequency != $request->payment_frequency) {

            if ($request->payment_frequency == 'monthly') {
                $packagePrice = $package->monthly_price;
                $eventsAllowed = $package->events_allowed;
                $package_validity = date('Y-m-d', strtotime('+1 months'));
                $packageValidity = '1 month';
            } else if ($request->payment_frequency == 'quarterly') {
                $eventsAllowed = $package->events_allowed * 3;
                $packagePrice = $package->quarterly_price;
                $package_validity = date('Y-m-d', strtotime('+3 months'));
                $packageValidity = '3 months';
            } else if ($request->payment_frequency == 'semi_annually') {
                $eventsAllowed = $package->events_allowed * 6;
                $packagePrice = $package->semi_annually_price;
                $package_validity = date('Y-m-d', strtotime('+6 months'));
                $packageValidity = '6 months';
            } else if ($request->payment_frequency == 'annually') {
                $eventsAllowed = $package->events_allowed * 12;
                $packagePrice = $package->annually_price;
                $package_validity = date('Y-m-d', strtotime('+12 months'));
                $packageValidity = '12 months';
            }

            $customerData = [
                'name' => $request->name,
                'email' => $request->email,
                'is_auto_renew' => isset($request->is_auto_renew) && $request->is_auto_renew == 'true' ? 1 : 0,
                'is_active' => 1,
                'verify_customer_email' => 1,
                'password' => Hash::make($request->password),
                'type' => 'customer',
                'registration_package_id' => $request->registration_package_id,
                'payment_frequency' => $request->payment_frequency,
                'package_price' => $packagePrice,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_validity,
                'is_package_amount_paid' => 1,
                'events_allowed' => $eventsAllowed,
                'events_remaining' => $eventsAllowed,
                'images_allowed' => isset($package) ? $package->images_allowed : 0,
            ];

            if ($customer) {
                Customer::whereId($request->customer_id)->update($customerData);
            } else {
                $customer = Customer::create($customerData);
            }
        } else {
            $customerData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($customer) {
                Customer::whereId($request->customer_id)->update($customerData);
            } else {
                $customer = Customer::create($customerData);
            }
        }
        if (!empty($request->password)) {
            $customer->update([
                'password' => Hash::make($request->password)
            ]);
        }



        $customerId = $customer->id;


        $profile = CustomerProfile::whereId($request->id)->first();


        $customerProfile = CustomerProfile::whereId($request->id)->update([
            'company_name' => $request->company_name,
            'slug' => isset($profile->slug) ? $profile->slug : $this->generateUniqueSlug($request->company_name),
            'company_email' => $request->company_email,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'phone' => $request->company_phone,
            // 'cta_btn' => $request->cta_btn,
            // 'cta_link' => $request->cta_link,
            'website' => $request->website,
            'keywords' => $request->keywords,
            'address' => $request->mailing_address,
            'customer_id' => $customerId ?? $profile->customer_id
        ]);
        $businessCategoriesName = [];
        $defaulLang = getDefaultLanguage();
        CustomerBusinessCategory::whereCustomerProfileId($request->id)->delete();
        foreach ($request->business_categories_id as $business_category_id) {
            $businessCategoriesName[] = BusinessCategoryDetail::whereBusinessCategoryId($business_category_id)->where('language_id', $defaulLang->id)->value('name');
            CustomerBusinessCategory::create([
                'business_category_id' => $business_category_id,
                'customer_id' => $customerId ?? $profile->customer_id,
                'customer_profile_id' => $request->id,
            ]);
        }


        $customerMedia = CustomerMedia::whereCustomerProfileId($request->id)->with(['customerGalleryImages.media', 'customerLogo'])->first();

        if (isset($request->logo)) {
            $media = json_decode($request->logo, 1);
            if ((isset($media, $media[0], $customerMedia->customerLogo) && $customerMedia->customerLogo->path != $media[0]) || (isset($media, $media[0]) && !isset($customerMedia->customerLogo))) {
                $files = $this->moveFile($media, 'media/customers', 'profile_logo');
            } else {
                $files[0]['id'] = $customerMedia->logo;
            }
        } else {
            $files[0]['id'] = $customerMedia->logo;
        }


        CustomerMedia::whereCustomerProfileId($request->id)->update([
            "title" => $request->media_title,
            "description" => $request->media_description,
            "logo" => isset($files, $files[0]) ? $files[0]['id'] : null,
            "video" => $request->video,
            "video_frame" => getVideoHtmlAttribute($request->video),
            "customer_id" => $customerId ?? $profile->customer_id,
            'customer_profile_id' => $request->id,
        ]);


        $oldMediaIds = [];
        if (isset($request->gallery_images)) {
            $oldMediaPath = [];
            if (isset($customerMedia->customerGalleryImages)) {
                foreach ($customerMedia->customerGalleryImages as $key => $customerGalleryImages) {
                    if (isset($customerGalleryImages->media)) {
                        $oldMediaPath[] = $customerGalleryImages->media->path;
                        if (in_array($customerGalleryImages->media->path, $request->gallery_images)) {
                            $oldMediaIds[] = $customerGalleryImages->media->id;
                        }
                    }
                }
            }
            $newMedia = array_merge(array_diff($request->gallery_images, $oldMediaPath), array_diff($oldMediaPath, $request->gallery_images));
            $galleryImages = [];
            if ($newMedia) {
                $galleryImages = $this->moveFile($newMedia, 'media/customers', 'profile_gallery_images');
            }
        }
        CustomerGalleryImage::whereNotIn('media_id', $oldMediaIds)->whereCustomerMediaId($customerMedia->id)->delete();
        if (isset($galleryImages)) {
            foreach ($galleryImages as $key => $image) {
                CustomerGalleryImage::create([
                    'customer_media_id' => $customerMedia->id,
                    'media_id' => $image->id,
                ]);
            }
        }

        CustomerSocialMedia::whereCustomerProfileId($request->id)->update([
            "facebook" => $request->facebook,
            "twitter" => $request->twitter,
            "youtube" => $request->youtube,
            "linked_in" => $request->linked_in,
            "customer_id" => $customerId ?? $profile->customer_id,
            'customer_profile_id' => $request->id,
        ]);
        return $this->successResponse([], 'Your exporter profile has been updated successfully!');
    }

    public function destroy(Request $request, $customerProfileId)
    {
        $customerProfile = CustomerProfile::whereId($customerProfileId)->firstOrFail();
        if ($customerProfile->customerBusinessCategory()->delete() && $customerProfile->customerMedia()->delete() && $customerProfile->customerSocialMedia()->delete() && $customerProfile->delete()) {
            return $this->apiSuccessResponse(new CustomerProfileResource($customerProfile), 'Your exporter profile has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($customerProfiles)
    {
        if (isset($_GET['withCustomer']) && $_GET['withCustomer'] == '1') {
            $customerProfiles = $customerProfiles->with('customer');
        }
        if (isset($_GET['withCustomerBusinessCategory']) && $_GET['withCustomerBusinessCategory'] == '1') {
            $customerProfiles = $customerProfiles->with('customerBusinessCategory');
        }
        if (isset($_GET['withCustomerMedia']) && $_GET['withCustomerMedia'] == '1') {
            $customerProfiles = $customerProfiles->with('customerMedia');
            $customerProfiles = $customerProfiles->with('customerMedia.customerLogo');
            $customerProfiles = $customerProfiles->with(['customerMedia.customerGalleryImages', 'customerMedia.customerGalleryImages.media']);
        }
        if (isset($_GET['withCustomerSocialMedia']) && $_GET['withCustomerSocialMedia'] == '1') {
            $customerProfiles = $customerProfiles->with('customerSocialMedia');
        }
        return $customerProfiles;
    }

    protected function sortingAndLimit($customerProfiles)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'company_name', 'company_email', 'phone', 'address'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $customerProfiles = $customerProfiles->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $customerProfiles->whereNotNull('company_name')->select('id', 'company_name')->get();
        }

        return $customerProfiles->paginate($limit);
    }

    protected function whereClause($customerProfiles)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $customerProfiles = $customerProfiles->where('company_name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('company_email', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $customerProfiles;
    }

    function importBusinessProfiles(Request $request)
    {
        $validationRule = ['import_file' => 'required'];
        $this->validate(
            $request,
            $validationRule
        );

        Excel::import(new BusinessProfilesImport, public_path($request->import_file));

        return $this->successResponse([], 'Business profiles has been imported successfully!');
    }

    protected function generateUniqueSlug($initialSlug): string
    {
        $slug = Str::slug($initialSlug);
        $count = 1;

        while (CustomerProfile::where('slug', $slug)->exists()) {
            $slug = Str::slug($initialSlug . '-' . $count);
            $count++;
        }

        return $slug;
    }
    function welcomeEmail(Request $request)
    {
        $validationRule = [
            'id' => ['required', 'exists:App\Models\Customer,id'],
        ];
        $this->validate(
            $request,
            $validationRule
        );

        $customer = Customer::whereId($request->id)->firstOrFail();

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $customer->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $defaultLang = getDefaultLanguage(1);


        $data = ['token' => $token, 'lang' => $defaultLang, 'email' => $customer->email, 'name' => $customer->name, 'reset_password' => 1];

        Mail::to($customer->email)->send(new CustomerResetPasswordMail($data));

        return $this->successResponse([], 'Password reset email has been sent successfully.');
    }

}
