<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\CustomerResource;
use App\Mail\AdminCloseAccountMail;
use App\Mail\CloseAccountMail;
use App\Mail\CustomerPasswordResetSuccessMail;
use App\Mail\CustomerReactiveEmailMail;
use App\Mail\CustomerResetPasswordMail;
use App\Mail\CustomerVerifyEmailMail;
use App\Mail\CustomerWelcomeMail;
use App\Mail\NewCustomerAdminMail;
use App\Mail\RegistrationInvoiceToCustomerMail;
use App\Models\BusinessCategoryDetail;
use App\Models\Customer;
use App\Models\CustomerBusinessCategory;
use App\Models\CustomerGalleryImage;
use App\Models\CustomerMedia;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Models\Order;
use App\Models\Page;
use App\Rules\MaxKeywordsRule;
use App\Rules\MaxLines;
use App\Rules\MaxWordCount;
use App\Rules\MaxWordsPerKeywordRule;
use App\Rules\ValidUrl;
use App\Rules\YoutubeUrl;
use App\Services\PDFService;
use App\Traits\FileUploadTrait;
use App\Traits\StatusResponser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;

class SignupController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function signup(Request $request)
    {

        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $request['gallery_images'] = json_decode($request->gallery_images);
        
        // Check if user is logged in or if email exists
        $loggedInCustomer = Auth::guard('customers')->user();
        $existingCustomer = Customer::where('email', $request->email)
            ->where('is_account_closed', 0)
            ->whereNull('deleted_at')
            ->first();
        
        $validationRule = [
            'payment_frequency' => ['required', 'in:monthly,quarterly,semi_annually,annually'],
            'registration_package_id' => ['required', 'exists:App\Models\RegistrationPackage,id'],
            'is_auto_renew' => ['nullable'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email'], // REMOVED unique validation to allow existing emails
            'business_categories_id' => ['required', 'array', 'max:3'],
            'business_categories_id.*' => ['required', 'exists:App\Models\BusinessCategory,id'],
            'customer_profile_company_name' => ['required', 'string'],
            'customer_profile_company_email' => ['required', 'email'], // REMOVED unique validation
            'customer_profile_address' => ['required', 'string', new MaxLines(5)],
            'customer_profile_phone' => ['required', 'string'],
            'customer_profile_cta_btn' => ['nullable', 'string'],
            'customer_profile_cta_link' => ['nullable', new ValidUrl()],
            'customer_profile_website' => ['required', new ValidUrl()],
            'customer_profile_short_description' => ['required', 'string', new MaxWordCount(30)],
            'customer_profile_description' => ['required', 'string', new MaxWordCount(300)],
            'customer_profile_keywords' => ['required', 'string', new MaxKeywordsRule(), new MaxWordsPerKeywordRule()],
            'customer_media_title' => ['nullable', 'string', new MaxWordCount(10)],
            'customer_media_description' => ['nullable', 'string', new MaxWordCount(50)],
            'customer_media_video' => ['nullable', new YoutubeUrl()],
            'customer_media_logo' => ['nullable', 'string'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable'],
            'customer_social_media_facebook' => ['nullable', new ValidUrl()],
            'customer_social_media_twitter' => ['nullable', new ValidUrl()],
            'customer_social_media_youtube' => ['nullable', new ValidUrl()],
            'customer_social_media_linked_in' => ['nullable', new ValidUrl()],
            'customer_social_media_social_media5' => ['nullable', new ValidUrl()],
            'is_agree' => ['required', 'accepted'],
        ];
        
        // Password only required for NEW users (not logged in AND email doesn't exist)
        if (!$loggedInCustomer && !$existingCustomer) {
            $validationRule['password'] = ['required', 'confirmed', Password::min(8)->mixedCase()];
        }
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'name' => isset($regPageSettingDetail[0]->step_2_name_error) ? $regPageSettingDetail[0]->step_2_name_error : '',
                'email' => isset($regPageSettingDetail[0]->step_2_email_error) ? $regPageSettingDetail[0]->step_2_email_error : '',
                'password' => isset($regPageSettingDetail[0]->step_2_password_error) ? $regPageSettingDetail[0]->step_2_password_error : '',
                'password_confirmation' => isset($regPageSettingDetail[0]->step_2_confirm_password_error) ? $regPageSettingDetail[0]->step_2_confirm_password_error : '',
                'is_agree' => isset($regPageSettingDetail[0]->terms_and_conditions_error) ? $regPageSettingDetail[0]->terms_and_conditions_error : '',
                'registration_package_id' => isset($regPageSettingDetail[0]->registration_package_error) ? $regPageSettingDetail[0]->registration_package_error : '',
                'business_categories_id' => isset($regPageSettingDetail[0]->step_3_business_categories_error) ? $regPageSettingDetail[0]->step_3_business_categories_error : '',
                'gallery_images' => isset($regPageSettingDetail[0]->step_5_gallery_image_error) ? $regPageSettingDetail[0]->step_5_gallery_image_error : '',
                'customer_profile_address' => isset($regPageSettingDetail[0]->step_4_address_error) ? $regPageSettingDetail[0]->step_4_address_error : '',
                'customer_profile_company_email' => isset($regPageSettingDetail[0]->step_4_email_error) ? $regPageSettingDetail[0]->step_4_email_error : '',
                'customer_profile_company_name' => isset($regPageSettingDetail[0]->step_4_name_error) ? $regPageSettingDetail[0]->step_4_name_error : '',
                'customer_profile_description' => isset($regPageSettingDetail[0]->step_4_description_error) ? $regPageSettingDetail[0]->step_4_description_error : '',
                'customer_profile_keywords' => isset($regPageSettingDetail[0]->step_4_keywords_error) ? $regPageSettingDetail[0]->step_4_keywords_error : '',
                'customer_profile_cta_link' => isset($regPageSettingDetail[0]->step_4_cta_link_error) ? $regPageSettingDetail[0]->step_4_cta_link_error : '',
                'customer_profile_cta_btn' => isset($regPageSettingDetail[0]->step_4_cta_btn_error) ? $regPageSettingDetail[0]->step_4_cta_btn_error : '',

                'customer_profile_phone' => isset($regPageSettingDetail[0]->step_4_phone_error) ? $regPageSettingDetail[0]->step_4_phone_error : '',
                'customer_profile_short_description' => isset($regPageSettingDetail[0]->step_4_short_description_error) ? $regPageSettingDetail[0]->step_4_short_description_error : '',
                'customer_profile_website' => isset($regPageSettingDetail[0]->step_4_website_error) ? $regPageSettingDetail[0]->step_4_website_error : '',
                'customer_media_video' => isset($regPageSettingDetail[0]->step_5_video_error) ? $regPageSettingDetail[0]->step_5_video_error : '',
                'customer_media_title' => isset($regPageSettingDetail[0]->step_5_title_error) ? $regPageSettingDetail[0]->step_5_title_error : '',
                'customer_media_description' => isset($regPageSettingDetail[0]->step_5_description_error) ? $regPageSettingDetail[0]->step_5_description_error : '',
                'customer_media_logo' => isset($regPageSettingDetail[0]->step_5_logo_error) ? $regPageSettingDetail[0]->step_5_logo_error : '',
                'customer_social_media_facebook' => isset($regPageSettingDetail[0]->step_6_facebook_error) ? $regPageSettingDetail[0]->step_6_facebook_error : '',
                'customer_social_media_linked_in' => isset($regPageSettingDetail[0]->step_6_linkedin_error) ? $regPageSettingDetail[0]->step_6_linkedin_error : '',
                'customer_social_media_social_media5' => isset($regPageSettingDetail[0]->step_6_social_media5_error) ? $regPageSettingDetail[0]->step_6_social_media5_error : '',
                'customer_social_media_twitter' => isset($regPageSettingDetail[0]->step_6_twitter_error) ? $regPageSettingDetail[0]->step_6_twitter_error : '',
                'customer_social_media_youtube' => isset($regPageSettingDetail[0]->step_6_youtube_error) ? $regPageSettingDetail[0]->step_6_youtube_error : '',
            ];
        }
        $general_setting = getSignleGeneralSettingByKey(['user_forget_password_page']);
        $forgetPasswordUrl = isset($general_setting['user_forget_password_page']) ? route('front.index', $general_setting['user_forget_password_page']) : '#';
        $forgetPasswordUrl = langBasedURL($defaultLang, $forgetPasswordUrl);

        // $messages['email.unique'] = 'This email has already been taken. If you believe it is yours, <a class="text-white text-semibold underline" href=' . $forgetPasswordUrl . '>click here</a> to recover it';
        $messages['email.unique'] = 'This email has already been taken.';

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_29']);
        $message_29 = isset($general_messages['message_29']) ? $general_messages['message_29'] : '';
        $messages['password.confirmed'] = $message_29;

        $this->validate(
            $request,
            $validationRule,
            $messages,
            $niceNames
        );
        
        // Check for closed customer accounts
        $existingClosedCustomer = null;
        if ($request->filled('email')) {
            $existingClosedCustomer = Customer::where('email', $request->email)
                ->where('is_account_closed', 1)
                ->first();
        }
        
        $package = getRegistrationPackage($request->registration_package_id);
        DB::beginTransaction();
        try {
            $eventsAllowed = 0;
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

            $activeEmailUrl = Hash::make($request->email);
            $subscribeHash = Hash::make($request->email);
            $subscribeHash = str_replace('===', '/', $subscribeHash);
            $customerData = [
                'name' => $request->name,
                'email' => $request->email,
                'is_auto_renew' => isset($request->is_auto_renew) && $request->is_auto_renew == 'true' ? 1 : 0,
                'is_active' => 1,
                'active_email_url' => $activeEmailUrl,
                'password' => Hash::make($request->password),
                'type' => 'customer',
                'registration_package_id' => $request->registration_package_id,
                'payment_frequency' => $request->payment_frequency,
                'package_price' => $packagePrice,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_validity,
                'is_package_amount_paid' => 0,
                'events_allowed' => $eventsAllowed,
                'events_remaining' => $eventsAllowed,
                'images_allowed' => isset($package) ? $package->images_allowed : 0,
                'is_subscribe' => 1, // Default to subscribed
                'subscribe_hash' => $subscribeHash, // Same format as InfoLetter
                'is_account_closed' => 0,
                'verify_customer_email' => 0,
                'active_account_url' => null,
            ];

            // Determine which customer to use
            $customer = null;
            $isNewCustomer = false;
            
            if ($loggedInCustomer) {
                // User is logged in - use their account
                $customer = $loggedInCustomer;
                // Update customer with new package info
                $customer->update($customerData);
                Log::info('Logged-in customer creating exporter profile', ['customer_id' => $customer->id]);
            } elseif ($existingClosedCustomer) {
                // Reactivating a closed account
                $existingClosedCustomer->update($customerData);
                $customer = $existingClosedCustomer->fresh();

                CustomerProfile::withTrashed()->where('customer_id', $customer->id)->forceDelete();

                $existingMediaIds = CustomerMedia::where('customer_id', $customer->id)->pluck('id');
                if ($existingMediaIds->count()) {
                    CustomerGalleryImage::whereIn('customer_media_id', $existingMediaIds)->delete();
                }
                CustomerMedia::where('customer_id', $customer->id)->delete();
                CustomerBusinessCategory::where('customer_id', $customer->id)->delete();
                CustomerSocialMedia::where('customer_id', $customer->id)->delete();
                
                Log::info('Reactivated closed customer account', ['customer_id' => $customer->id]);
            } elseif ($existingCustomer) {
                // Email exists and account is active - use existing customer
                $customer = $existingCustomer;
                // Update with new package info and exporter type
                $customer->update(array_merge($customerData, [
                    'type' => 'customer', // Change type to customer (exporter)
                ]));
                Log::info('Using existing customer email for exporter profile', ['customer_id' => $customer->id]);
            } else {
                // Create new customer
                $customer = Customer::create($customerData);
                $isNewCustomer = true;
                Log::info('New exporter customer created', ['customer_id' => $customer->id]);
            }

            $customerProfile = CustomerProfile::create([
                'company_name' => $request->customer_profile_company_name,
                'slug' => $this->generateUniqueSlug($request->customer_profile_company_name),
                'company_email' => $request->customer_profile_company_email,
                'short_description' => $request->customer_profile_short_description,
                'description' => $request->customer_profile_description,
                'phone' => $request->customer_profile_phone,
                'website' => $request->customer_profile_website,
                'keywords' => $request->customer_profile_keywords,
                'address' => $request->customer_profile_address,
                'cta_link' => $request->customer_profile_cta_link,
                'cta_btn' => $request->customer_profile_cta_btn,
                'customer_id' => $customer->id,
            ]);
            $businessCategoriesName = [];
            $defaultLang = getDefaultLanguage();
            foreach ($request->business_categories_id as $business_category_id) {
                $businessCategoriesName[] = BusinessCategoryDetail::whereBusinessCategoryId($business_category_id)->where('language_id', $defaultLang->id)->value('name');
                CustomerBusinessCategory::create([
                    'business_category_id' => $business_category_id,
                    'customer_id' => $customer->id,
                    'customer_profile_id' => $customerProfile->id
                ]);
            }

            if (isset($request->customer_media_logo)) {
                $media = json_decode($request->customer_media_logo, 1);
                $files = $this->moveFile($media, 'media/customers', 'profile_logo');
            }

            $customerMedia = CustomerMedia::create([
                "logo" => isset($files, $files[0]) ? $files[0]->id : null,
                "video" => $request->customer_media_video,
                "title" => $request->customer_media_title,
                "description" => $request->customer_media_description,
                "video_frame" => getVideoHtmlAttribute($request->customer_media_video),
                "customer_id" => $customer->id,
                'customer_profile_id' => $customerProfile->id
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
                "facebook" => $request->customer_social_media_facebook,
                "twitter" => $request->customer_social_media_twitter,
                "youtube" => $request->customer_social_media_youtube,
                "linked_in" => $request->customer_social_media_linked_in,
                "social_media5" => $request->customer_social_media_social_media5,
                "customer_id" => $customer->id,
                'customer_profile_id' => $customerProfile->id
            ]);


            $data['user_id'] = $activeEmailUrl;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['company_name'] = $request->customer_profile_company_name;
            $data['company_email'] = $request->customer_profile_company_email;
            $data['business_categories_name'] = $businessCategoriesName;
            $data['package'] = $package;
            $data['package_type'] = $package;
            $data['package_price'] = $packagePrice;
            $data['payment_frequency'] = $request->payment_frequency;
            $data['created_at'] = date("F d, Y, g:i a");

            $general_setting = getGeneralSettingByKey();
            if (isset($general_setting['admin_email'])) {
                $adminEmailsArr = explode(',', $general_setting['admin_email']);
            }
            if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
                $to_email = $adminEmailsArr[0];
                unset($adminEmailsArr[0]);
                Mail::to($to_email)->cc($adminEmailsArr)->send(new NewCustomerAdminMail($data));
            } else {
                $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
                if ($to_email) {
                    Mail::to($to_email)->send(new NewCustomerAdminMail($data));
                }
            }
            // Only send verification email to NEW customers
            if ($isNewCustomer) {
                // ----Mail::to($request->email)->send(new CustomerVerifyEmailMail($data));
            }

            // if ($packagePrice <= 0) {

            //     $order = Order::create([
            //         'registration_package_id' => $package->id,
            //         'customer_id' => $customer->id,
            //         'type' => 'profile',
            //     ]);
            //     $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
            //     $order->update([
            //         'invoice_no' => $invoiceNo
            //     ]);

            //     $customer = $customer->loadMissing('customerProfile');

            //     $data = ['package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $packagePrice, 'payment_frequency' => $request->payment_frequency, 'package_validity' => $packageValidity, 'customer' => $customer, 'order' => $order, 'package_expiry_date' => $package_validity];

            //     $PDFService = new PDFService();

            //     $PDFService->createRegistrationInvoicePDF(null, $data);

            //     Mail::to($request->email)->send(new RegistrationInvoiceToCustomerMail($data));
            // }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }

        $data = [];
        // if ($packagePrice > 0) {
        //     Auth::guard('customers')->login($customer);
        //     $defaultLang = getDefaultLanguage(1);
        //     $data['redirect_url'] = route('user.payment.index', [$defaultLang->abbreviation]);
        // } else {
        //     $data['redirect_url'] = route('front.index', $defaultLang->abbreviation);
        //     $data['redirect_url'] = langBasedURL(null, $data['redirect_url']);
        // }
        $data['redirect_url'] = route('front.index', $defaultLang->abbreviation);
        $data['redirect_url'] = langBasedURL(null, $data['redirect_url']);
        // $general_setting = getGeneralSettingByKey();
        // $url = langBasedURL(null, $general_setting['user_signin_page']);
        // $data['redirect_url'] = url($url);
        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_23']);
        $message_23 = isset($general_messages['message_23']) ? $general_messages['message_23'] : '';

        Session::flash('message', $message_23);
        Session::flash('type', 'success');


        return $this->successResponse($data, $message_23);
    }

    public function logout()
    {
        if (Auth::guard('customers')->check()) {
            Auth::guard('customers')->logout();
        }
        $url = langBasedURL(null, route('front.index'));
        return Redirect::to($url);
    }

    public function login(Request $request)
    {
        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $loginPageSetting = getLoginPageSetting($defaultLang, Page::whereId($request->page_id)->first());
            $loginPageSettingDetail = $loginPageSetting->loginPageSettingDetail;
            $niceNames = [
                'email' => isset($loginPageSettingDetail[0]->email_error) ? $loginPageSettingDetail[0]->email_error : '',
                'password' => isset($loginPageSettingDetail[0]->password_error) ? $loginPageSettingDetail[0]->password_error : '',
            ];
        }
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [], $niceNames);

        $credentials['is_account_closed'] = 0;


        if (Auth::guard('customers')->attempt($credentials)) {

            if (Auth::guard('customers')->user()->is_package_amount_paid == '0') {
                if (Auth::guard('customers')->user()->verify_customer_email != '1') {
                    if (Auth::guard('customers')->check()) {
                        Auth::guard('customers')->logout();
                    }
                    $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_34']);
                    $message_34 = isset($general_messages['message_34']) ? $general_messages['message_34'] : '';

                    $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_35_a', 'message_35_b']);
                    $message_35_a = isset($general_messages['message_35_a']) ? $general_messages['message_35_a'] : '';
                    $message_35_b = isset($general_messages['message_35_b']) ? $general_messages['message_35_b'] : '';

                    $errorMessage = $message_34 . "<br /><br /><a aria-label='Candian Exporters' class='text-white text-semibold underline' href=" . route('web.resend-verification-email.request', [$defaultLang->abbreviation]) . ">" . $message_35_a . "</a> " . $message_35_b;
                    return back()->withErrors([
                        "email" => $errorMessage,
                    ])->onlyInput("email");
                } else {
                    $request->session()->regenerate();
                    return redirect()->route('user.payment.index', [$defaultLang->abbreviation]);
                }
            } else if (Auth::guard('customers')->user()->verify_customer_email != '1') {
                if (Auth::guard('customers')->check()) {
                    Auth::guard('customers')->logout();
                }
                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_34']);
                $message_34 = isset($general_messages['message_34']) ? $general_messages['message_34'] : '';

                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_35_a', 'message_35_b']);
                $message_35_a = isset($general_messages['message_35_a']) ? $general_messages['message_35_a'] : '';
                $message_35_b = isset($general_messages['message_35_b']) ? $general_messages['message_35_b'] : '';

                $errorMessage = $message_34 . "<br /><br /><a aria-label='Candian Exporters' class='text-white text-semibold underline' href=" . route('web.resend-verification-email.request', [$defaultLang->abbreviation]) . ">" . $message_35_a . "</a> " . $message_35_b;
                return back()->withErrors([
                    "email" => $errorMessage,
                ])->onlyInput("email");
            }
            // else if (Auth::guard('customers')->user()->is_account_closed == '1') {
            //     if (Auth::guard('customers')->check()) {
            //         Auth::guard('customers')->logout();
            //     }
            //     $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_43']);
            //     $message_43 = isset($general_messages['message_43']) ? $general_messages['message_43'] : '';

            //     $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_44_a', 'message_44_b']);
            //     $message_44_a = isset($general_messages['message_44_a']) ? $general_messages['message_44_a'] : '';
            //     $message_44_b = isset($general_messages['message_44_b']) ? $general_messages['message_44_b'] : '';

            //     $errorMessage = $message_43 . "<br /><br /><a aria-label='Candian Exporters' class='text-white text-semibold underline resend-activation-email' href='#'>" . $message_44_a . "</a> " . $message_44_b;
            //     return back()->withErrors([
            //         "email" => $errorMessage,
            //     ])->onlyInput("email");
            // }
            else if (Auth::guard('customers')->user()->is_active == '1') {
                if (Session::has('url.intended')) {
                    $intendedUrl = Session::get('url.intended');
                    $parsedUrl = parse_url($intendedUrl, PHP_URL_PATH);

                    // Check if the intended URL is the specific one you want to exclude
                    if ($parsedUrl == '/get-registration-packages') {
                        $page = Page::whereTemplate('event_create_template')->first();
                        $url = langBasedURL(null, route('front.index', $page->slug));
                        return redirect($url);
                    }

                    return redirect(Session::get('url.intended'));
                }
                $request->session()->regenerate();
                $redirect_url = route('user.profile-settings.index');
                $redirect_url = langBasedURL(null, $redirect_url);
                return redirect($redirect_url);
            } else if (Auth::guard('customers')->user()->is_active != '1') {
                if (Auth::guard('customers')->check()) {
                    Auth::guard('customers')->logout();
                }
                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_7']);
                $message_7 = isset($general_messages['message_7']) ? $general_messages['message_7'] : '';

                return back()->withErrors([
                    "email" => $message_7,
                ])->onlyInput("email");
            }
        }

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_25']);
        
        $message_25 = isset($general_messages['message_25']) ? $general_messages['message_25'] : '';

        return back()->withErrors([
            'credentials' => $message_25,
        ])->onlyInput('email');
    }

    public function showForgotPassword($abbreviation)
    {
        updateLangByAbber($abbreviation);
        return view('web.forgot-password.index');
    }


    public function forgotPassword(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $forget_password_setting = getI2bModalSetting($defaultLang, ['forget_password_setting']);
            $niceNames = [
                'email' => isset($forget_password_setting['email_error_text']) ? $forget_password_setting['email_error_text'] : '',
            ];
        }
        $request->validate(['email' => 'required|email'], [], $niceNames);
        $customer = Customer::where('email', $request->email)->first();
        if (!Customer::where('email', $request->email)->exists()) {
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_27']);
            $message_27 = isset($general_messages['message_27']) ? $general_messages['message_27'] : '';

            return back()->withErrors(['email' => $message_27]);
        }
        if ($customer->is_account_closed == '1') {
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_43']);
            $message_43 = isset($general_messages['message_43']) ? $general_messages['message_43'] : '';

            return back()->withErrors(['email' => $message_43]);
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);


        $data = ['token' => $token, 'lang' => $defaultLang, 'email' => $request->email, 'name' => $customer->name,];
        Mail::to($request->email)->send(new CustomerResetPasswordMail($data));

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_51']);
        $message_51 = isset($general_messages['message_51']) ? $general_messages['message_51'] : '';

        return back()->with(['status' => $message_51]);

        // $status = Password::broker('customers')->sendResetLink(
        //     $request->only('email')
        // );
        // dd(1);
        // return $status === Password::RESET_LINK_SENT
        //     ? back()->with(['status' => __($status)])
        //     : back()->withErrors(['email' => __($status)]);
    }

    //     public function forgotPassword(Request $request)
    // {
    //     $defaultLang = getDefaultLanguage(1);
    //     $niceNames = [];
    //     if ($defaultLang) {
    //         App::setLocale($defaultLang->abbreviation);
    //         $forget_password_setting = getI2bModalSetting($defaultLang, ['forget_password_setting']);
    //         $niceNames = [
    //             'email' => isset($forget_password_setting['email_error_text']) ? $forget_password_setting['email_error_text'] : '',
    //         ];
    //     }

    //     $request->validate(['email' => 'required|email'], [], $niceNames);

    //     $customer = Customer::where('email', $request->email)->first();

    //     if (!$customer) {
    //         $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_27']);
    //         $message_27 = isset($general_messages['message_27']) ? $general_messages['message_27'] : '';

    //         return back()->withErrors(['email' => $message_27]);
    //     }

    //     $token = Str::random(64);

    //     DB::table('password_resets')->insert([
    //         'email' => $request->email,
    //         'token' => $token,
    //         'created_at' => Carbon::now(),
    //     ]);

    //     // Send Reset Password Email
    //     $data = [
    //         'token' => $token,
    //         'lang' => $defaultLang,
    //         'email' => $request->email,
    //         'name' => $customer->name,
    //     ];
    //     Mail::to($request->email)->send(new CustomerResetPasswordMail($data));

    //     // Send Confirmation Email for Successful Reset
    //     $confirmationEmailData = [
    //         'name' => $customer->name,
    //     ];
    //     Mail::to($request->email)->send(new CustomerPasswordResetSuccessMail($confirmationEmailData));

    //     $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_51']);
    //     $message_51 = isset($general_messages['message_51']) ? $general_messages['message_51'] : '';

    //     return back()->with(['status' => $message_51]);
    // }


    function getLoggedInUser()
    {
        if (Auth::guard('customers')->check()) {
            Session::forget('inquiry_id');
            $customer = Customer::whereId(Auth::guard('customers')->user()->id)->with(['registrationPackage' => function ($q) {
                $q->where('type', 'customer');
            }])->first();

            $customer = new CustomerResource($customer);
            $payment_setting = getI2bModalSetting(null, ['payment_setting']);
            $data = [];
            $data['customer'] = $customer;
            $data['payment_setting'] = $payment_setting;
            return $this->successResponse($data, 'user logged in.');
        }

        return $this->errorResponse('user not logged in.');
    }

    public function loggedInUser(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            $setting = getSignleGeneralSettingByKey(['user_signin_page']);
            $user_signin_page = isset($setting['user_signin_page']) ? $setting['user_signin_page'] : null;
            App::setLocale($defaultLang->abbreviation);
            $loginPageSetting = getLoginPageSetting($defaultLang, Page::whereSlug($user_signin_page)->first());
            $loginPageSettingDetail = isset($loginPageSetting->loginPageSettingDetail) ? $loginPageSetting->loginPageSettingDetail : null;
            $niceNames = [
                'email' => isset($loginPageSettingDetail[0]->email_error) ? $loginPageSettingDetail[0]->email_error : '',
                'password' => isset($loginPageSettingDetail[0]->password_error) ? $loginPageSettingDetail[0]->password_error : '',
            ];
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [], $niceNames);
        if (Auth::guard('customers')->attempt($credentials)) {
            // Session::put('inquiry_id', $request->inquiry_id);
            // $request->session()->regenerate();
            // $customer = Auth::guard('customers')->user();
            // return $this->successResponse(new CustomerResource($customer), 'user logged in.');

            if (Auth::guard('customers')->user()->is_package_amount_paid == '0') {
                Auth::guard('customers')->logout();
                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_6']);
                $message_6 = isset($general_messages['message_6']) ? $general_messages['message_6'] : '';

                return $this->errorResponse($message_6);
            } else if (Auth::guard('customers')->user()->is_active == '1') {
                Session::put('inquiry_id', $request->inquiry_id);
                $request->session()->regenerate();
                $customer = Auth::guard('customers')->user();
                return $this->successResponse(new CustomerResource($customer), 'user logged in.');
            } else {
                if (Auth::guard('customers')->check()) {
                    Auth::guard('customers')->logout();
                }
                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_7']);
                $message_7 = isset($general_messages['message_7']) ? $general_messages['message_7'] : '';

                return $this->errorResponse($message_7);
            }
        }
        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_25']);
        $message_25 = isset($general_messages['message_25']) ? $general_messages['message_25'] : '';


        return $this->errorResponse($message_25);
    }

    // public function deleteProfile(Request $request)
    // {
    //     if (Auth::guard('customers')->check()) {
    //         Customer::whereId(Auth::guard('customers')->user()->id)->update([
    //             'is_account_closed' => 1
    //         ]);
    //         Auth::guard('customers')->logout();
    //     }
    //     $data['redirect_url'] = langBasedURL(null, route('front.index'));

    //     $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_24']);
    //     $message_24 = isset($general_messages['message_24']) ? $general_messages['message_24'] : '';


    //     return $this->successResponse($data, $message_24);
    // }
    public function deleteProfile(Request $request)
    {
        if (Auth::guard('customers')->check()) {
            $customer = Customer::find(Auth::guard('customers')->user()->id);
            $company_name = $customer->customerProfile->company_name ?? 'N/A';

            // Update the customer's account status
            Customer::whereId($customer->id)->update([
                'is_account_closed' => 1
            ]);

            // Delete related customer data
            $customer->customerProfile()->delete();
            $customer->customerBusinessCategory()->delete();
            $customer->customerPaymentMethod()->delete();
            $customer->customerMedia()->delete();
            $customer->customerSocialMedia()->delete();
            $customer->order()->delete();

            // Logout the customer
            Auth::guard('customers')->logout();

            // Prepare email data
            $emailData = [
                'name' => $request->input('name', $customer->name), // Use form data if available, otherwise use customer's name
                'email' => $request->input('email', $customer->email), // Use form data if available, otherwise use customer's email
                'message' => $request->input('message', 'No message provided'), // Use form data if available, otherwise use a default message
                'account_closed_date' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'company_name' => $company_name,
            ];

            // Send email to the customer
            Mail::to($customer->email)->send(new CloseAccountMail($emailData));

            // Send email to the admin
            $general_setting = getGeneralSettingByKey();
            if (isset($general_setting['admin_email'])) {
                $adminEmailsArr = explode(',', $general_setting['admin_email']);
            }

            if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
                $to_email = $adminEmailsArr[0];
                unset($adminEmailsArr[0]);
                Mail::to($to_email)->cc($adminEmailsArr)->send(new AdminCloseAccountMail($emailData));
            } else {
                $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
                if ($to_email) {
                    Mail::to($to_email)->send(new AdminCloseAccountMail($emailData));
                }
            }

            // Prepare response data
            $data['redirect_url'] = langBasedURL(null, route('front.index'));
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_24']);
            $message_24 = isset($general_messages['message_24']) ? $general_messages['message_24'] : '';

            return $this->successResponse($data, $message_24);
        }
    }
    public function updateNewUserStatus($email, $id)
    {
        if (!isset($_GET['status']) || !isset($email) || !isset($id)) {
            abort(404);
        }
        $id = str_replace('===', '/', $id);
        $result = Hash::check($email, $id);
        if ($result == false) {
            abort(404);
        }

        $customer = Customer::where('email', $email)->whereNotNull('active_email_url')->firstOrFail();
        Customer::where('email', $email)->update([
            'active_email_url' => null,
            'is_active' => $_GET['status'] == 'active' ? 1 : 0,
        ]);

        if ($_GET['status'] == 'active') {
            Session::flash('message', 'User has been activated sucessfully.');
            // $data = [
            //     'name' => $customer->name
            // ];
            // Mail::to($email)->send(new CustomerWelcomeMail($data));
        } else {
            Session::flash('message', 'User has been inactivate sucessfully.');
        }

        return view('front.pages.flash-messages');
    }

    // public function customerVerifyEmail($email, $id)
    // {
    //     if (!isset($_GET['status']) || !isset($email) || !isset($id)) {
    //         abort(404);
    //     }
    //     $id = str_replace('===', '/', $id);
    //     $result = Hash::check($email, $id);
    //     if ($result == false) {
    //         abort(404);
    //     }
    //     $customer = Customer::where('email', $email)->first();
    //     if ($customer->verify_customer_email == '1') {
    //         $redirect_url = langBasedURL(null, route('front.index'));
    //         return Redirect::to($redirect_url);
    //     }
    //     Customer::where('email', $email)->update([
    //         'verify_customer_email' => 1,
    //     ]);

    //     if ($_GET['status'] == 'active') {
    //         Auth::guard('customers')->loginUsingId($customer->id);
    //         Session::flash('message', 'Congratulations! Your email address has been successfully verified');
    //         Session::flash('type', 'success');
    //         $redirect_url = langBasedURL(null, route('front.index'));
    //         return Redirect::to($redirect_url)->with('status', 'Congratulations! Your email address has been successfully verified');
    //     }
    //     abort(404);
    // }
    public function customerVerifyEmail($email, $id)
    {
        if (!isset($_GET['status']) || !isset($email) || !isset($id)) {
            abort(404);
        }

        $id = str_replace('===', '/', $id);
        if (!Hash::check($email, $id)) {
            abort(404);
        }

        $customer = Customer::where('email', $email)->first();
        if ($customer->is_package_amount_paid == '1') {
            $redirect_url = langBasedURL(null, route('front.index'));
            return Redirect::to($redirect_url);
        }

        // Update verification status
        Customer::where('email', $email)->update([
            'verify_customer_email' => 1,
        ]);

        if ($_GET['status'] == 'active') {
            Auth::guard('customers')->loginUsingId($customer->id);

            // Redirect to payment page after verification (but don't restrict other pages)
            $defaultLang = getDefaultLanguage(1);
            Session::flash('message', 'Congratulations! Your email address has been successfully verified');
            Session::flash('type', 'success');
            return redirect()->route('user.payment.index', [$defaultLang->abbreviation]);
        }

        abort(404);
    }


    public function showResendVerificationEmail($abbreviation)
    {
        updateLangByAbber($abbreviation);
        return view('web.resend-verification-email.index');
    }


    public function resendVerificationEmail(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $resend_email_verification_setting = getI2bModalSetting($defaultLang, ['resend_email_verification_setting']);
            $niceNames = [
                'email' => isset($resend_email_verification_setting['email_error_text']) ? $resend_email_verification_setting['email_error_text'] : '',
            ];
        }
        $request->validate(['email' => 'required|email'], [], $niceNames);

        if (!Customer::where('email', $request->email)->exists()) {
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_27']);
            $message_27 = isset($general_messages['message_27']) ? $general_messages['message_27'] : '';

            return back()->withErrors(['email' => $message_27]);
        }

        $activeEmailUrl = Hash::make($request->email);
        $customer = Customer::where('email', $request->email)->firstOrFail();
        $customer->update([
            'active_email_url' => $activeEmailUrl
        ]);
        $data['user_id'] = $activeEmailUrl;
        $data['name'] = $customer->name;
        $data['email'] = $customer->email;


        Mail::to($customer->email)->send(new CustomerVerifyEmailMail($data));

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_52']);
        $message_52 = isset($general_messages['message_52']) ? $general_messages['message_52'] : '';

        return back()->with(['status' => $message_52]);

        // $status = Password::broker('customers')->sendResetLink(
        //     $request->only('email')
        // );
        // dd(1);
        // return $status === Password::RESET_LINK_SENT
        //     ? back()->with(['status' => __($status)])
        //     : back()->withErrors(['email' => __($status)]);
    }

    public function reactiveCustomerAccount(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        if (!Customer::where('email', $request->email)->exists()) {
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_27']);
            $message_27 = isset($general_messages['message_27']) ? $general_messages['message_27'] : '';

            return $this->errorResponse($message_27);
        }

        $activeEmailUrl = Hash::make($request->email);
        $customer = Customer::where('email', $request->email)->firstOrFail();
        $customer->update([
            'active_account_url' => $activeEmailUrl
        ]);
        $data['user_id'] = $activeEmailUrl;
        $data['name'] = $customer->name;
        $data['email'] = $customer->email;


        Mail::to($customer->email)->send(new CustomerReactiveEmailMail($data));

        return $this->successResponse("We have sent you an email to reactive your account.");
    }

    public function customerReactiveEmail($email, $id)
    {
        if (!isset($_GET['status']) || !isset($email) || !isset($id)) {
            abort(404);
        }
        $id = str_replace('===', '/', $id);
        $result = Hash::check($email, $id);
        if ($result == false) {
            abort(404);
        }

        $customerExists = Customer::where('email', $email)->where('active_account_url', $id)->where('is_account_closed', 0)->exists();
        if ($customerExists) {
            $defaultLang = getDefaultLanguage(1);
            $redirect_url = route('front.index', $defaultLang->abbreviation);
            $url = langBasedURL($defaultLang, $redirect_url);
            Session::flash('message', 'Your request can not be proceed.');
            Session::flash('type', 'success');
            return redirect($url);
        }
        // else{
        //     $defaultLang = getDefaultLanguage(1);
        //     $redirect_url = route('front.index', $defaultLang->abbreviation);
        //     $url = langBasedURL($defaultLang, $redirect_url);
        //     Session::flash('message', 'Your request can not be proceed.');
        //     Session::flash('type', 'success');
        //     return redirect($url);
        // }

        Customer::where('email', $email)->update([
            'active_account_url' => null,
            'is_account_closed' => 0,
        ]);

        // if ($_GET['status'] == 'active') {
        //     Session::flash('message', 'Congratulations! Your email address has been successfully verified.');
        // }
        $customer = Customer::where('email', $email)->first();
        Auth::guard('customers')->loginUsingId($customer->id);

        $defaultLang = getDefaultLanguage(1);
        $redirect_url = route('front.index', $defaultLang->abbreviation);
        $url = langBasedURL($defaultLang, $redirect_url);
        Session::flash('message', 'Your account has been reactivated successfully.');
        Session::flash('type', 'success');
        return redirect($url);

        // return Redirect::to($url)->with('status', 'Your account has been reactivated successfully.');

        // Customer::where('email', $email)->update([
        //     'active_account_url' => null,
        //     'is_account_closed' => 0,
        // ]);

        // if ($_GET['status'] == 'active') {
        //     Session::flash('message', 'Congratulations! Your email address has been successfully verified.');
        // }

        // return view('web.reactive-email.index', ['email' => $email, 'id' => $id]);
    }

    public function updateCustomerReactiveEmail(Request $request)
    {

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_29']);
        $message_29 = isset($general_messages['message_29']) ? $general_messages['message_29'] : '';
        $messages = [];
        $messages['password.confirmed'] = $message_29;
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()],
        ]);
        $token = str_replace('===', '/', $request->token);
        $result = Hash::check($request->email, $token);
        if ($result == false) {
            return back()->withErrors(['email' => 'Token miss matched.']);
        }
        $customerExists = Customer::where('email', $request->email)->where('active_account_url', $request->token)->where('is_account_closed', 1)->exists();
        if (!$customerExists) {
            return back()->withErrors(['email' => 'Your request can not be proceed.']);
        }

        Customer::where('email', $request->email)->update([
            'active_account_url' => null,
            'is_account_closed' => 0,
            'password' => Hash::make($request->password),
        ]);

        // if ($_GET['status'] == 'active') {
        //     Session::flash('message', 'Congratulations! Your email address has been successfully verified.');
        // }
        $general_setting = getGeneralSettingByKey();
        $url = langBasedURL(null, $general_setting['user_signin_page']);

        return Redirect::to($url)->with('status', 'Your account has been reactivated successfully.');
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
}
