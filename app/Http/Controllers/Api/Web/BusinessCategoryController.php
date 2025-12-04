<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AdvertisterEmailToCustomerMail;
use App\Mail\ContactCompanyMail;
use App\Mail\SendCopyToUserMail;
use App\Models\AdvertiserContactForm;
use App\Models\BusinessCategoryDetail;
use App\Models\BusinessProfileStats;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\Page;
use App\Models\RegistrationPackage;
use App\Models\VisitorInfo;
use App\Services\EmailSettingService;
use App\Services\HelperService;
use App\Traits\StatusResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BusinessCategoryController extends Controller
{
    use StatusResponser;

    public function index($abbreviation = null, $slug)
    {
        updateLangByAbber($abbreviation);
        $category_id = BusinessCategoryDetail::select('business_category_id', 'name')->whereSlug($slug)->value('business_category_id');
        $businessCategoryDetail = BusinessCategoryDetail::select('business_category_id', 'name')->whereBusinessCategoryId($category_id)->firstOrFail();


        $customers = CustomerProfile::select('id', 'customer_id', 'company_name', 'slug', 'short_description', 'description', 'website');

        $customers = $customers->with(['customerMedia:id,customer_id,customer_profile_id,logo', 'customerMedia.customerLogo']);

        $customers = $customers->whereHas('customerBusinessCategory', function ($q) use ($businessCategoryDetail) {
            $q->where('business_category_id', $businessCategoryDetail->business_category_id);
        });



        $customers = $customers->whereHas('customer', function ($q) {
            $q->where('is_active', 1)->where('is_package_amount_paid', 1)->where('package_expiry_date', '>=', date('Y-m-d'));
        });
        $customers = $customers->whereHas('customer.registrationPackage', function ($q) {
            $q->whereNotNull('package_type');
        });

        $customers = $customers->addSelect([
            'package_type' => Customer::whereColumn('customers.id', 'customer_profile.customer_id')
                ->select(['package_type' => RegistrationPackage::whereColumn('customers.registration_package_id', 'registration_packages.id')->select('package_type')])
        ]);
        // $customers = $customers->addSelect([
        //     'sorting_order' => Customer::whereColumn('customers.id', 'customer_profile.customer_id')
        //         ->select(['sorting_order' => RegistrationPackage::whereColumn('customers.registration_package_id', 'registration_packages.id')->select('sorting_order')])
        // ]);
        $customers = $customers->orderByRaw("FIELD(package_type, 'featured', 'premium', 'free') ASC");
        $customers = $customers->orderBy('company_name', 'asc');

        $customers = $customers->paginate(25);
        return view('web.business-category.index', compact('customers', 'businessCategoryDetail'));
    }

    // public function show($abbreviation = null, $customerProfileSlug)
    // {
    //     updateLangByAbber($abbreviation);
    //     $customer = CustomerProfile::with(['customerMedia.customerLogo', 'customerMedia.customerGalleryImages.media', 'customer.customerSocialMedia'])->whereSlug($customerProfileSlug)->whereHas('customer', function ($q) {
    //         $q->where('is_active', 1)->where('is_package_amount_paid', 1)->where('package_expiry_date', '>=', date('Y-m-d'));
    //     })->firstOrFail();
    //     return view('web.business-category.show', compact('customer'));
    // }
    public function show($abbreviation = null, $customerProfileSlug)
    {
        updateLangByAbber($abbreviation);

        $customer = CustomerProfile::with([
            'customerMedia.customerLogo',
            'customerMedia.customerGalleryImages.media',
            'customer.customerSocialMedia',
            'customer' // Include the customer relationship
        ])
            ->whereSlug($customerProfileSlug)
            ->whereHas('customer', function ($q) {
                $q->where('is_active', 1)
                    ->where('is_package_amount_paid', 1)
                    ->where('package_expiry_date', '>=', date('Y-m-d'));
            })
            ->firstOrFail();

        return view('web.business-category.show', compact('customer'));
    }

    public function sendMessage(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $advertiserSetting = getI2bModalSetting($defaultLang, ['business_profile_setting']);
            $niceNames = [
                'name' => isset($advertiserSetting['contact_tab_name_error']) ? $advertiserSetting['contact_tab_name_error'] : '',
                'company_name' => isset($advertiserSetting['contact_tab_company_name_error']) ? $advertiserSetting['contact_tab_company_name_error'] : '',
                'email' => isset($advertiserSetting['contact_tab_email_error']) ? $advertiserSetting['contact_tab_email_error'] : '',
                'message' => isset($advertiserSetting['contact_tab_message_error']) ? $advertiserSetting['contact_tab_message_error'] : '',
            ];
        }

        if (isset($request->customer_profile_id)) {
            $this->submitStats($request->customer_profile_id);
        }

        $data = $this->validate($request, [
            "name" => "required|string|max:255",
            "email" => "required|email",
            "customer_profile_id" => "required|exists:customer_profile,id",
            "company_name" => "required|string|max:255",
            "message" => "required|string",
            // "page_id" => "required|exists:pages,id",
        ], [], $niceNames);

        $emailService = new EmailSettingService();
        $result = $emailService->advertiserForm('advertiser');
        // if ($result['status'] == 'Error') {
        //     return $result;
        // }

        $customerProfile = CustomerProfile::whereId($request->customer_profile_id)->first();
        // Email to exporter and admin
        $general_setting = getSignleGeneralSettingByKey(['admin_email']);
        if (isset($general_setting['admin_email'])) {
            $adminEmailsArr = explode(',', $general_setting['admin_email']);
        }
        // if (isset($request->send_me_copy) && $request->send_me_copy == true) {
        //     $adminEmailsArr[] = $request->email;
        // }
        if (isset($request->send_me_copy) && $request->send_me_copy == true) {
            $customer = Auth::guard('customers')->check() ? Auth::guard('customers')->user() : null;

            if ($customer) {
                Mail::to($customer->email)->send(new SendCopyToUserMail($customerProfile, $data));
            }
        }

        if (isset($adminEmailsArr)) {
            Mail::to($customerProfile->company_email)->cc($adminEmailsArr)->send(new ContactCompanyMail($data, $customerProfile->company_name));
        } else {
            Mail::to($customerProfile->company_email)->send(new ContactCompanyMail($data, $customerProfile->company_name));
        }
        // Email to customer
        Mail::to($request->email)->send(
            new AdvertisterEmailToCustomerMail($customerProfile, $data)
        );

        AdvertiserContactForm::create([
            'email_sent_by' => Auth::guard('customers')->check() ? Auth::guard('customers')->user()->id : null,
            'customer_profile_id' => $request->customer_profile_id,
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'message' => $request->message,
        ]);

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_17']);
        $message_17 = isset($general_messages['message_17']) ? $general_messages['message_17'] : '';

        return $this->successResponse([], $message_17);
    }

    function submitStats($profile_id)
    {
        $helperService = new HelperService;
        $ip = $helperService->getRealIpAddr();
        $ua = $helperService->getBrowser();
        $browser = isset($ua['name']) ? $ua['name'] : null;
        $browser_version = isset($ua['version']) ? $ua['version'] : null;
        $visitorInfo = VisitorInfo::whereIpAddress($ip)->where('browser', $browser)->where('browser_version', $browser_version)->first();

        if (!$visitorInfo) {
            $location = $helperService->ip_info($ip, "location");
            $visitorInfo = VisitorInfo::create([
                'ip_address' => $ip,
                'country' => isset($location['country']) ? $location['country'] : null,
                'country_code' => isset($location['country_code']) ? $location['country_code'] : null,
                'state' => isset($location['state']) ? $location['state'] : null,
                'city' => isset($location['city']) ? $location['city'] : null,
                'browser' => isset($ua['name']) ? $ua['name'] : null,
                'browser_version' => isset($ua['version']) ? $ua['version'] : null,
                'platform' => isset($ua['platform']) ? $ua['platform'] : null,
                'user_agent' => isset($ua['userAgent']) ? $ua['userAgent'] : null,
            ]);
        }


        BusinessProfileStats::create([
            'customer_profile_id' => $profile_id,
            'visitor_info_id' => $visitorInfo->id,
            'type' => 'send_message',
        ]);
    }
}
