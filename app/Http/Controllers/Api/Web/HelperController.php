<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EventListingSettingResource;
use App\Http\Resources\Admin\EventResource;
use App\Http\Resources\Admin\RegPageSettingResource;
use App\Http\Resources\Admin\SponserListingSettingResource;
use App\Http\Resources\Web\RegistrationPackageResource;
use App\Mail\EventCreationInvoiceMail;
use App\Models\BillingPeriodDiscount;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryDetail;
use App\Models\BusinessProfileStats;
use App\Models\CoffeeWallPackage;
use App\Models\CoffeeWallBeneficiary;
use App\Models\Customer;
use App\Models\Event;
use App\Models\EventContact;
use App\Models\EventDetail;
use App\Models\EventListingSetting;
use App\Models\EventMedia;
use App\Models\HolidayEmail;
use App\Models\InfoLetter;
use App\Models\Order;
use App\Models\Page;
use App\Models\RegistrationPackage;
use App\Models\RegPageSetting;
use App\Models\SponserListingSetting;
use App\Models\VisitorInfo;
use App\Rules\ValidUrl;
use App\Services\HelperService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Traits\FileUploadTrait;
use App\Traits\StatusResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use LVR\CreditCard\CardNumber;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HelperController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function getRegistrationPackages()
    {
        $defaultLang = getDefaultLanguage(1);
        $registrationPackages = RegistrationPackage::select('id', 'is_default', 'monthly_price', 'quarterly_price', 'semi_annually_price', 'annually_price', 'package_type', 'images_allowed', 'event_price')->with(['registrationPackageDetail' => function ($q) use ($defaultLang) {
            $q->select('id', 'registration_package_id', 'name', 'short_description')->where('language_id', $defaultLang->id);
        }])->orderBy('is_default', 'asc');
        if (isset($_GET['getProfilePackagesOnly']) && $_GET['getProfilePackagesOnly'] == '1') {
            $registrationPackages = $registrationPackages->where('type', 'profile');
        }
        if (isset($_GET['withPackageFeatures']) && $_GET['withPackageFeatures'] == '1') {
            $registrationPackages = $registrationPackages->with(['registrationPackageFeature' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }]);
        }
        if (isset($_GET['getPayToGoPackagesOnly']) && $_GET['getPayToGoPackagesOnly'] == '1') {
            $registrationPackages = $registrationPackages->where('package_type', 'pay_to_go');
        }
        if (isset($_GET['getPackagesOnly']) && $_GET['getPackagesOnly'] == '1') {
            $registrationPackages = $registrationPackages->whereIn('package_type', ['free', 'featured', 'premium'])->orderBy('package_type', 'desc');
        }
        if (isset($_GET['getEventPackagesOnly']) && $_GET['getEventPackagesOnly'] == '1') {
            $registrationPackages = $registrationPackages->where('type', 'event');
        }
        $registrationPackages = $registrationPackages->get();
        return $this->successResponse($registrationPackages, 'Data Get Successfully!');
    }

    public function getCoffeeWallPackages()
    {
        $defaultLang = getDefaultLanguage(1);
        $registrationPackages = CoffeeWallPackage::where('custom', '0')->select('id', 'is_default', 'price')->with(['coffeeWallPackageDetail' => function ($q) use ($defaultLang) {
            $q->select('id', 'package_id', 'name', 'short_description')->where('language_id', $defaultLang->id);
        }])->orderBy('is_default', 'asc')->orderBy('price', 'asc');
        $registrationPackages = $registrationPackages->get();

        return $this->successResponse($registrationPackages, 'Data Get Successfully!');
    }

    public function getCoffeeWallBeneficiaries()
    {
        $beneficiaries = CoffeeWallBeneficiary::select('id', 'name')->orderBy('name', 'asc')->get();
        return $this->successResponse($beneficiaries, 'Data Get Successfully!');
    }

    public function getSponsorAmounts()
    {
        $amounts = \App\Models\SponsorAmount::select('id', 'amount', 'frequency', 'is_default')
            ->orderBy('frequency')
            ->orderBy('sort_order')
            ->orderBy('amount')
            ->get();

        // Group by frequency for easier frontend handling
        $grouped = $amounts->groupBy('frequency');

        return $this->successResponse([
            'amounts' => $amounts,
            'grouped' => $grouped,
            'frequencies' => \App\Models\SponsorAmount::$frequencies
        ], 'Data Get Successfully!');
    }

    public function getCoffeeWallFaqs()
    {
        $faqs = \App\Models\CoffeeWallFaq::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->groupBy('type');

        return $this->successResponse([
            'donor' => $faqs->get('donor', []),
            'beneficiary' => $faqs->get('beneficiary', [])
        ], 'Data Get Successfully!');
    }

    public function getBusinessCategories()
    {
        $defaultLang = getDefaultLanguage(1);
        $registrationPackages = BusinessCategory::select('id')->addSelect(['category_name' => BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')->where('business_category_detail.language_id', $defaultLang->id)->select('name')])
            ->orderBy('category_name', 'asc')->get();
        return $this->successResponse($registrationPackages, 'Data Get Successfully!');
    }

    public function getBillingDiscounts()
    {
        $discounts = BillingPeriodDiscount::select('period_type', 'discount_percentage', 'multiplier', 'months')
            ->orderBy('months', 'asc')
            ->get()
            ->keyBy('period_type');
        return $this->successResponse($discounts, 'Data Get Successfully!');
    }

    public function checkCustomerEmail(Request $request)
    {
        $validationRule = [
            'email' => ['required', 'email', 'unique:App\Models\Customer,email'],
        ];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'email' => isset($regPageSettingDetail[0]->step_2_email_error) ? $regPageSettingDetail[0]->step_2_email_error : '',
            ];
        }
        $general_setting = getSignleGeneralSettingByKey(['user_forget_password_page']);
        $forgetPasswordUrl = isset($general_setting['user_forget_password_page']) ? route('front.index', $general_setting['user_forget_password_page']) : '#';
        $forgetPasswordUrl = langBasedURL($defaultLang, $forgetPasswordUrl);

        // $messages['email.unique'] = 'This email has already been taken. If you believe it is yours, <a class="text-white text-semibold underline" href=' . $forgetPasswordUrl . '>click here</a> to recover it';
        $messages['email.unique'] = 'This email has already been taken.';
        $this->validate(
            $request,
            $validationRule,
            $messages,
            $niceNames
        );

        return $this->successResponse([], 'Email is valid!');
    }

    public function checkCustomerProfileEmail(Request $request)
    {
        $validationRule = [
            'customer_profile_company_email' => ['required', 'email', 'unique:App\Models\CustomerProfile,company_email'],
        ];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'customer_profile_company_email' => isset($regPageSettingDetail[0]->step_4_email_error) ? $regPageSettingDetail[0]->step_4_email_error : '',
            ];
        }
        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );

        return $this->successResponse([], 'Email is valid!');
    }

    public function setLanguage($language)
    {
        if (isset($_GET['url']) && $_GET['url'] != '') {
            $url = langBasedURL(null, $_GET['url'], $language);
            if (isset($_GET['url_params']) && $_GET['url_params'] != '') {
                $url = $url . '?reload=1';
                foreach ($_GET as $key => $param) {
                    if ($key != 'url' && $key == 'url_params') {
                        $url = $url . '&' . $param;
                    } else if ($key != 'url') {
                        if (is_array($param)) {
                            $url = $url . '&' . $key . '[]=' . implode('&' . $key . '[]=', $param);
                        } else {
                            $url = $url . '&' . $key . '=' . $param;
                        }
                    }
                }
            }
            return Redirect::to($url);
        }
        Session::put('webLanguage', $language);
        return redirect()->back();
    }

    public function getRegPageSetting()
    {
        $defaultLang = getDefaultLanguage(true);
        $regPageSetting = RegPageSetting::with(['regPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['findByPageId'])) {
            $regPageSetting = $regPageSetting->wherePageId($_GET['findByPageId']);
        }
        if (isset($_GET['getDefaultPageSetting']) && $_GET['getDefaultPageSetting'] == '1') {
            $setting = getSignleGeneralSettingByKey(['user_signup_page']);
            $user_signup_page = $setting['user_signup_page'];
            $page = Page::where('slug', $user_signup_page)->first();
            if (isset($page)) {
                $regPageSetting = $regPageSetting->wherePageId($page->id);
            }
        }
        $regPageSetting = $regPageSetting->first();
        return $this->successResponse(new RegPageSettingResource($regPageSetting), 'Data Get Successfully!');
    }

    public function processPayment(Request $request)
    {
        $package = getRegistrationPackage($request->registration_package_id);
        $request['gallery_images'] = isset($request->gallery_images) && $request->gallery_images != null ? json_decode($request->gallery_images) : null;
        $validationRule = [
            'zipcode' => ['nullable'],
            'gallery_images' => ['required', 'array'],
            'start_date' => ['required', 'date'],
            // 'end_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'event_website' => ['required', new ValidUrl()],
            'exibitors_url' => ['nullable', new ValidUrl()],
            'visitors_url' => ['nullable', new ValidUrl()],
            'press_url' => ['nullable', new ValidUrl()],
            'video_url' => ['nullable', new ValidUrl()],
            'facebook_url' => ['nullable', new ValidUrl()],
            'twitter_url' => ['nullable', new ValidUrl()],
            'linkedin_url' => ['nullable', new ValidUrl()],
            'youtube_url' => ['nullable', new ValidUrl()],
            'pintrest_url' => ['nullable', new ValidUrl()],
            'instagram_url' => ['nullable', new ValidUrl()],
            'snapchat_url' => ['nullable', new ValidUrl()],
            'is_agree' => ['required', 'accepted'],
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.email' => 'required|email|max:255',
            'contacts.*.phone' => 'required|string|max:20',
            // 'contacts.*.designation' => 'required|string|max:255',
            'contacts.*.image_path' => 'nullable|string|max:255',
        ];

        $errorMessages = [];
        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);

        $events_remaining = Auth::guard('customers')->user()->events_remaining;
        if (Auth::guard('customers')->user()->type !== 'event' && Auth::guard('customers')->user()->package_expiry_date < date('Y-m-d')) {
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_3']);
            $message_3 = isset($general_messages['message_3']) ? $general_messages['message_3'] : '';

            return $this->errorResponse($message_3);
        }

        $languages = getAllLanguages();

        // if ($events_remaining == null || $events_remaining <= 0) {
        //     // $validationRule = array_merge($validationRule, ['registration_package_id' => ['required', 'exists:registration_packages,id']]);

        //     // $niceNames['registration_package_id'] = 'package';
        //     return $this->errorResponse("Your access to events is limited to the end; consider upgrading your package for extended privileges.");
        // }
        if ($events_remaining == null || $events_remaining <= 0) {
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_62']);
            $message_62 = isset($general_messages['message_62']) ? $general_messages['message_62'] : 'Your access to events is limited to the end; consider upgrading your package for extended privileges.';
            return $this->errorResponse($message_62);
        }

        if ((isset($package) && $package->price > 0 && ($events_remaining == null || $events_remaining <= 0))) {
            $validationRule = array_merge($validationRule, ['payment_method' => ['required', 'in:stripe,paypal']]);

            if (isset($request->payment_method) && $request->payment_method == 'stripe') {
                $validationRule = array_merge($validationRule, ['customer_payment_method_id' => ['required']]);
                $validationRule = array_merge($validationRule, ['card_holder_name' => ['nullable', 'required_if:customer_payment_method_id,add_new_card']]);
                $validationRule = array_merge($validationRule, ['card_no' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', new CardNumber]]);
                $validationRule = array_merge($validationRule, ['expiry_month' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'min:01', 'max:12']]);
                $validationRule = array_merge($validationRule, ['expiry_year' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'digits:4']]);
                $validationRule = array_merge($validationRule, ['cvc' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'min:3', 'max:4']]);

                $payment_setting = getI2bModalSetting($defaultLang, ['payment_setting']);

                $niceNames['card_holder_name'] = isset($payment_setting['cardholder_name_error']) ? $payment_setting['cardholder_name_error'] : '';
                $niceNames['card_no'] = isset($payment_setting['card_number_error']) ? $payment_setting['card_number_error'] : '';
                $niceNames['expiry_month'] = isset($payment_setting['expiry_month_error']) ? $payment_setting['expiry_month_error'] : '';
                $niceNames['expiry_year'] = isset($payment_setting['expiry_year_error']) ? $payment_setting['expiry_year_error'] : '';
                $niceNames['cvc'] = isset($payment_setting['cvv_error']) ? $payment_setting['cvv_error'] : '';
            }
        }

        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $setting = getEventCreateSettingById($defaultLang, $request->page_id);
            $niceNames['zipcode'] = isset($setting->eventCreateSettingDetail[0]->zipcode_error) ? $setting->eventCreateSettingDetail[0]->zipcode_error : '';
            $niceNames['media_id'] = isset($setting->eventCreateSettingDetail[0]->logo_error) ? $setting->eventCreateSettingDetail[0]->logo_error : '';
            $niceNames['start_date'] = isset($setting->eventCreateSettingDetail[0]->start_date_error) ? $setting->eventCreateSettingDetail[0]->start_date_error : '';
            $niceNames['end_date'] = isset($setting->eventCreateSettingDetail[0]->end_date_error) ? $setting->eventCreateSettingDetail[0]->end_date_error : '';
            // $niceNames['end_date'] = isset($setting->eventCreateSettingDetail[0]->end_date_error) ?
            // $setting->eventCreateSettingDetail[0]->end_date_error :
            // 'The End date cannot be earlier than the Start date';
            $niceNames['event_website'] = isset($setting->eventCreateSettingDetail[0]->event_website_error) ? $setting->eventCreateSettingDetail[0]->event_website_error : '';
            $niceNames['exibitors_url'] = isset($setting->eventCreateSettingDetail[0]->exibitors_url_error) ? $setting->eventCreateSettingDetail[0]->exibitors_url_error : '';
            $niceNames['visitors_url'] = isset($setting->eventCreateSettingDetail[0]->visitors_url_error) ? $setting->eventCreateSettingDetail[0]->visitors_url_error : '';
            $niceNames['press_url'] = isset($setting->eventCreateSettingDetail[0]->press_url_error) ? $setting->eventCreateSettingDetail[0]->press_url_error : '';
            $niceNames['video_url'] = isset($setting->eventCreateSettingDetail[0]->video_url_error) ? $setting->eventCreateSettingDetail[0]->video_url_error : '';
            $niceNames['contacts.*.name'] = isset($setting->eventCreateSettingDetail[0]->contact_name_error) ? $setting->eventCreateSettingDetail[0]->contact_name_error : '';
            $niceNames['contacts.*.email'] = isset($setting->eventCreateSettingDetail[0]->contact_email_error) ? $setting->eventCreateSettingDetail[0]->contact_email_error : '';
            $niceNames['contacts.*.phone'] = isset($setting->eventCreateSettingDetail[0]->contact_phone_error) ? $setting->eventCreateSettingDetail[0]->contact_phone_error : '';
            // $niceNames['contacts.*.designation'] = isset($setting->eventCreateSettingDetail[0]->contact_designation_error) ? $setting->eventCreateSettingDetail[0]->contact_designation_error : '';
            $niceNames['contacts.*.image_path'] = isset($setting->eventCreateSettingDetail[0]->profile_image_error) ? $setting->eventCreateSettingDetail[0]->profile_image_error : '';
            $niceNames['facebook_url'] = isset($setting->eventCreateSettingDetail[0]->facebook_url_error) ? $setting->eventCreateSettingDetail[0]->facebook_url_error : '';
            $niceNames['twitter_url'] = isset($setting->eventCreateSettingDetail[0]->twitter_url_error) ? $setting->eventCreateSettingDetail[0]->twitter_url_error : '';
            $niceNames['linkedin_url'] = isset($setting->eventCreateSettingDetail[0]->linkedin_url_error) ? $setting->eventCreateSettingDetail[0]->linkedin_url_error : '';
            $niceNames['youtube_url'] = isset($setting->eventCreateSettingDetail[0]->youtube_url_error) ? $setting->eventCreateSettingDetail[0]->youtube_url_error : '';
            $niceNames['pintrest_url'] = isset($setting->eventCreateSettingDetail[0]->pintrest_url_error) ? $setting->eventCreateSettingDetail[0]->pintrest_url_error : '';
            $niceNames['instagram_url'] = isset($setting->eventCreateSettingDetail[0]->instagram_url_error) ? $setting->eventCreateSettingDetail[0]->instagram_url_error : '';
            $niceNames['snapchat_url'] = isset($setting->eventCreateSettingDetail[0]->snapchat_url_error) ? $setting->eventCreateSettingDetail[0]->snapchat_url_error : '';
            $niceNames['is_agree'] = isset($setting->eventCreateSettingDetail[0]->terms_and_conditions_error) ? $setting->eventCreateSettingDetail[0]->terms_and_conditions_error : '';
        }

        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $niceNames['title.title_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->title_error) ? $setting->eventCreateSettingDetail[0]->title_error : '';

            $validationRule = array_merge($validationRule, ['country.country_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $niceNames['country.country_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->country_error) ? $setting->eventCreateSettingDetail[0]->country_error : '';

            $validationRule = array_merge($validationRule, ['city.city_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $niceNames['city.city_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->city_error) ? $setting->eventCreateSettingDetail[0]->city_error : '';


            $validationRule = array_merge($validationRule, ['street_name.street_name_' . $language->id => ['nullable', 'string']]);
            $niceNames['street_name.street_name_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->street_name_error) ? $setting->eventCreateSettingDetail[0]->street_name_error : '';


            $validationRule = array_merge($validationRule, ['venue.venue_' . $language->id => ['nullable', 'string', 'max:255']]);
            $niceNames['venue.venue_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->venue_error) ? $setting->eventCreateSettingDetail[0]->venue_error : '';


            $validationRule = array_merge($validationRule, ['product_search.product_search_' . $language->id => ['nullable', 'string']]);
            $niceNames['product_search.product_search_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->product_search_error) ? $setting->eventCreateSettingDetail[0]->product_search_error : '';


            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
            $niceNames['short_description.short_description_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->short_description_error) ? $setting->eventCreateSettingDetail[0]->short_description_error : '';


            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:300']]);
            $niceNames['description.description_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->description_error) ? $setting->eventCreateSettingDetail[0]->description_error : '';
        }

        $this->validate($request, $validationRule, $errorMessages, $niceNames);

        if ($request->payment_method == 'stripe' && ($events_remaining == null || $events_remaining <= 0)) {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        }

        try {
            $user = Auth::guard('customers')->user();
            if (($events_remaining == null || $events_remaining <= 0)) {
                if ($request->payment_method == 'stripe') {
                    try {
                        $stripeService = new StripeService();
                        $stripeResponse = $stripeService->eventPackagePayAsGo($request, $user, $package);
                        $subscription_id = $stripeResponse['subscription_id'];
                        $stripe_item_id = $stripeResponse['stripe_item_id'];
                    } catch (\Exception $e) {
                        return $this->errorResponse($e->getMessage());
                    }
                }
            }
            $filesArr = [];

            if (isset($request->gallery_images)) {
                $galleryImages = $this->moveFile($request->gallery_images, 'media/events', 'events');
            }

            foreach ($languages as $language) {
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                    $slug = $request['title']['title_' . $language->id] ?? null;
                }
            }
            $event = Event::create([
                'zipcode' => $request->zipcode,
                'media_id' => isset($galleryImages, $galleryImages[0]) ? $galleryImages[0]->id : null,
                'slug' => $this->generateUniqueSlug($slug),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                // 'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                'event_website' => $request->event_website,
                'exibitors_url' => $request->exibitors_url,
                'visitors_url' => $request->visitors_url,
                'press_url' => $request->press_url,
                'video_url' => $request->video_url,
                'facebook_url' => $request->facebook_url,
                'twitter_url' => $request->twitter_url,
                'linkedin_url' => $request->linkedin_url,
                'youtube_url' => $request->youtube_url,
                'pintrest_url' => $request->pintrest_url,
                'instagram_url' => $request->instagram_url,
                'snapchat_url' => $request->snapchat_url,
                'customer_id' => isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : null,
                'registration_package_id' => $request->registration_package_id,
                'package_price' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : (isset($package->price) ? $package->price : 0),
                'free_subscription_days' => isset($package) ? $package->free_subscription_days : 0,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => date('Y-m-d', strtotime('+' . (isset($package) ? $package->package_validity_months : 0) . ' months')),
                'is_package_amount_paid' => 1,
                'payment_method' => $request->payment_method,
                'payment_method_id' => isset($subscription_id) ? $subscription_id : null,
            ]);
            if ($request->payment_method == 'paypal') {
                $event->update([
                    'deleted_at' => date('Y-m-d H:i:s')
                ]);
            }

            if ($event) {
                if (isset($galleryImages)) {
                    foreach ($galleryImages as $key => $file) {
                        EventMedia::create([
                            'event_id' => $event->id,
                            'media_id' => $file->id,
                        ]);
                    }
                }
                foreach ($languages as $language) {
                    EventDetail::create([
                        'event_id' => $event->id,
                        'language_id' => $language->id,
                        'title' => $request['title']['title_' . $language->id] ?? null,
                        'country' => $request['country']['country_' . $language->id] ?? null,
                        'city' => $request['city']['city_' . $language->id] ?? null,
                        'street_name' => $request['street_name']['street_name_' . $language->id] ?? null,
                        'venue' => $request['venue']['venue_' . $language->id] ?? null,
                        'product_search' => $request['product_search']['product_search_' . $language->id] ?? null,
                        'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                        'description' => $request['description']['description_' . $language->id] ?? null,
                    ]);
                }
                $contacts = $request->input('contacts');
                foreach ($contacts as $contactData) {
                    EventContact::create([
                        'event_id' => $event->id,
                        'name' => $contactData['name'],
                        'email' => $contactData['email'],
                        'phone' => $contactData['phone'],
                        // 'designation' => $contactData['designation'],
                        'image_path' => $contactData['image_path'],
                    ]);
                }
                if ($request->payment_method == 'paypal') {
                    $paypalService = new PaypalService();
                    $paypalResponse = $paypalService->createSubscription($request, $user, $package, 'customer_create_event');

                    Customer::whereId($user->id)->update([
                        'temp_registration_package_id' => $event->id,
                    ]);

                    if ($paypalResponse['status'] == 'Error') {
                        return $this->errorResponse($paypalResponse['message']);
                    } else if ($paypalResponse['status'] == 'Success') {
                        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_19']);
                        $message_19 = isset($general_messages['message_19']) ? $general_messages['message_19'] : '';

                        $username = auth()->guard('customers')->user()->name ?? null;
                        $message_19 = str_replace(":name", $username, $message_19);

                        return $this->successResponse(
                            [
                                'type' => 'paypal',
                                'redirect_url' => $paypalResponse['redirect_url'],
                            ],
                            $message_19,
                        );
                    }
                    return $this->errorResponse();
                }
                if (($events_remaining == null || $events_remaining <= 0)) {
                    Order::create([
                        'registration_package_id' => $package->id,
                        'customer_id' => auth()->guard('customers')->user()->id,
                        'type' => 'event',
                        'payment_method' => $request->payment_method,
                        'transaction_id' => isset($subscription_id) ? $subscription_id : null,
                        'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                        'amount' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : $package->price,
                    ]);
                }
                if (isset(Auth::guard('customers')->user()->id)) {
                    Customer::whereId(Auth::guard('customers')->user()->id)->update([
                        'events_remaining' => Auth::guard('customers')->user()->events_remaining - 1
                    ]);
                }

                $defaultLang = getDefaultLanguage(1);

                $event = Event::with('customer')->with(['eventDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                }])->whereId($event->id)->first();


                // Mail::to(Auth::guard('customers')->user()->email)->send(new EventCreationInvoiceMail($event, 'customer'));
                $general_setting = getGeneralSettingByKey();
                if (isset($general_setting['admin_email'])) {
                    $adminEmailsArr = explode(',', $general_setting['admin_email']);
                    $event->email_to = 'admin';
                }
                // if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
                //     $to_email = $adminEmailsArr[0];
                //     unset($adminEmailsArr[0]);
                //     Mail::to($to_email)->cc($adminEmailsArr)->send(new EventCreationInvoiceMail($event, 'admin'));
                // } else {
                //     $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
                //     if ($to_email) {
                //         Mail::to($to_email)->send(new EventCreationInvoiceMail($event, 'admin'));
                //     }
                // }

                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_21']);
                $message_21 = isset($general_messages['message_21']) ? $general_messages['message_21'] : '';

                return $this->apiSuccessResponse(new EventResource($event), $message_21);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
            return $this->errorResponse($e->getMessage());
        }
    }

    public function CreateEventRestriction()
    {
        $url = langBasedURL(null, route('front.index'));
        // Session::flash('message', "Your access to events is limited to the end; consider upgrading your package for extended privileges.");
        $defaultLang = getDefaultLanguage(1);
        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_62']);
        $message_62 = isset($general_messages['message_62']) ? $general_messages['message_62'] : 'Your access to events is limited to the end; consider upgrading your package for extended privileges.';
        Session::flash('message', $message_62);
        Session::flash('type', 'success');
        return Redirect::to($url);
    }

    public function editProcessPayment(Request $request, $id)
    {
        $package = getRegistrationPackage($request->registration_package_id);
        $request['gallery_images'] = isset($request->gallery_images) && $request->gallery_images != null ? json_decode($request->gallery_images) : null;
        $validationRule = [
            'zipcode' => ['nullable'],
            'gallery_images' => ['required', 'array'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'event_website' => ['required', new ValidUrl()],
            'exibitors_url' => ['nullable', new ValidUrl()],
            'visitors_url' => ['nullable', new ValidUrl()],
            'press_url' => ['nullable', new ValidUrl()],
            'video_url' => ['nullable', new ValidUrl()],
            'facebook_url' => ['nullable', new ValidUrl()],
            'twitter_url' => ['nullable', new ValidUrl()],
            'linkedin_url' => ['nullable', new ValidUrl()],
            'youtube_url' => ['nullable', new ValidUrl()],
            'pintrest_url' => ['nullable', new ValidUrl()],
            'instagram_url' => ['nullable', new ValidUrl()],
            'snapchat_url' => ['nullable', new ValidUrl()],
            'is_agree' => ['required', 'accepted'],
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.email' => 'required|email|max:255',
            'contacts.*.phone' => 'required|string|max:20',
            // 'contacts.*.designation' => 'required|string|max:255',
            'contacts.*.image_path' => 'nullable|string|max:255',
        ];

        $errorMessages = [];
        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);

        // $events_remaining = Auth::guard('customers')->user()->events_remaining;
        // if (Auth::guard('customers')->user()->package_expiry_date < date('Y-m-d')) {
        //     $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_3']);
        //     $message_3 = isset($general_messages['message_3']) ? $general_messages['message_3'] : '';

        //     return $this->errorResponse($message_3);
        // }

        $languages = getAllLanguages();

        // if ($events_remaining == null || $events_remaining <= 0) {
        //     $validationRule = array_merge($validationRule, ['registration_package_id' => ['required', 'exists:registration_packages,id']]);

        //     $niceNames['registration_package_id'] = 'package';
        // }

        // if ((isset($package) && $package->price > 0 && ($events_remaining == null || $events_remaining <= 0))) {
        //     $validationRule = array_merge($validationRule, ['payment_method' => ['required', 'in:stripe,paypal']]);

        //     if (isset($request->payment_method) && $request->payment_method == 'stripe') {
        //         $validationRule = array_merge($validationRule, ['customer_payment_method_id' => ['required']]);
        //         $validationRule = array_merge($validationRule, ['card_holder_name' => ['nullable', 'required_if:customer_payment_method_id,add_new_card']]);
        //         $validationRule = array_merge($validationRule, ['card_no' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', new CardNumber]]);
        //         $validationRule = array_merge($validationRule, ['expiry_month' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'min:01', 'max:12']]);
        //         $validationRule = array_merge($validationRule, ['expiry_year' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'digits:4']]);
        //         $validationRule = array_merge($validationRule, ['cvc' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'min:3', 'max:4']]);

        //         $payment_setting = getI2bModalSetting($defaultLang, ['payment_setting']);

        //         $niceNames['card_holder_name'] = isset($payment_setting['cardholder_name_error']) ? $payment_setting['cardholder_name_error'] : '';
        //         $niceNames['card_no'] = isset($payment_setting['card_number_error']) ? $payment_setting['card_number_error'] : '';
        //         $niceNames['expiry_month'] = isset($payment_setting['expiry_month_error']) ? $payment_setting['expiry_month_error'] : '';
        //         $niceNames['expiry_year'] = isset($payment_setting['expiry_year_error']) ? $payment_setting['expiry_year_error'] : '';
        //         $niceNames['cvc'] = isset($payment_setting['cvv_error']) ? $payment_setting['cvv_error'] : '';
        //     }
        // }

        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $setting = getEventCreateSettingById($defaultLang, $request->page_id);
            $niceNames['zipcode'] = isset($setting->eventCreateSettingDetail[0]->zipcode_error) ? $setting->eventCreateSettingDetail[0]->zipcode_error : '';
            $niceNames['media_id'] = isset($setting->eventCreateSettingDetail[0]->logo_error) ? $setting->eventCreateSettingDetail[0]->logo_error : '';
            $niceNames['start_date'] = isset($setting->eventCreateSettingDetail[0]->start_date_error) ? $setting->eventCreateSettingDetail[0]->start_date_error : '';
            $niceNames['end_date'] = isset($setting->eventCreateSettingDetail[0]->end_date_error) ? $setting->eventCreateSettingDetail[0]->end_date_error : '';
            $niceNames['event_website'] = isset($setting->eventCreateSettingDetail[0]->event_website_error) ? $setting->eventCreateSettingDetail[0]->event_website_error : '';
            $niceNames['exibitors_url'] = isset($setting->eventCreateSettingDetail[0]->exibitors_url_error) ? $setting->eventCreateSettingDetail[0]->exibitors_url_error : '';
            $niceNames['visitors_url'] = isset($setting->eventCreateSettingDetail[0]->visitors_url_error) ? $setting->eventCreateSettingDetail[0]->visitors_url_error : '';
            $niceNames['press_url'] = isset($setting->eventCreateSettingDetail[0]->press_url_error) ? $setting->eventCreateSettingDetail[0]->press_url_error : '';
            $niceNames['video_url'] = isset($setting->eventCreateSettingDetail[0]->video_url_error) ? $setting->eventCreateSettingDetail[0]->video_url_error : '';
            $niceNames['contacts.*.name'] = isset($setting->eventCreateSettingDetail[0]->contact_name_error) ? $setting->eventCreateSettingDetail[0]->contact_name_error : '';
            $niceNames['contacts.*.email'] = isset($setting->eventCreateSettingDetail[0]->contact_email_error) ? $setting->eventCreateSettingDetail[0]->contact_email_error : '';
            $niceNames['contacts.*.phone'] = isset($setting->eventCreateSettingDetail[0]->contact_phone_error) ? $setting->eventCreateSettingDetail[0]->contact_phone_error : '';
            // $niceNames['contacts.*.designation'] = isset($setting->eventCreateSettingDetail[0]->contact_designation_error) ? $setting->eventCreateSettingDetail[0]->contact_designation_error : '';
            $niceNames['contacts.*.image_path'] = isset($setting->eventCreateSettingDetail[0]->profile_image_error) ? $setting->eventCreateSettingDetail[0]->profile_image_error : '';
            $niceNames['facebook_url'] = isset($setting->eventCreateSettingDetail[0]->facebook_url_error) ? $setting->eventCreateSettingDetail[0]->facebook_url_error : '';
            $niceNames['twitter_url'] = isset($setting->eventCreateSettingDetail[0]->twitter_url_error) ? $setting->eventCreateSettingDetail[0]->twitter_url_error : '';
            $niceNames['linkedin_url'] = isset($setting->eventCreateSettingDetail[0]->linkedin_url_error) ? $setting->eventCreateSettingDetail[0]->linkedin_url_error : '';
            $niceNames['youtube_url'] = isset($setting->eventCreateSettingDetail[0]->youtube_url_error) ? $setting->eventCreateSettingDetail[0]->youtube_url_error : '';
            $niceNames['pintrest_url'] = isset($setting->eventCreateSettingDetail[0]->pintrest_url_error) ? $setting->eventCreateSettingDetail[0]->pintrest_url_error : '';
            $niceNames['instagram_url'] = isset($setting->eventCreateSettingDetail[0]->instagram_url_error) ? $setting->eventCreateSettingDetail[0]->instagram_url_error : '';
            $niceNames['snapchat_url'] = isset($setting->eventCreateSettingDetail[0]->snapchat_url_error) ? $setting->eventCreateSettingDetail[0]->snapchat_url_error : '';
            $niceNames['is_agree'] = isset($setting->eventCreateSettingDetail[0]->terms_and_conditions_error) ? $setting->eventCreateSettingDetail[0]->terms_and_conditions_error : '';
        }

        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $niceNames['title.title_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->title_error) ? $setting->eventCreateSettingDetail[0]->title_error : '';

            $validationRule = array_merge($validationRule, ['country.country_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $niceNames['country.country_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->country_error) ? $setting->eventCreateSettingDetail[0]->country_error : '';

            $validationRule = array_merge($validationRule, ['city.city_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $niceNames['city.city_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->city_error) ? $setting->eventCreateSettingDetail[0]->city_error : '';


            $validationRule = array_merge($validationRule, ['street_name.street_name_' . $language->id => ['nullable', 'string']]);
            $niceNames['street_name.street_name_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->street_name_error) ? $setting->eventCreateSettingDetail[0]->street_name_error : '';


            $validationRule = array_merge($validationRule, ['venue.venue_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $niceNames['venue.venue_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->venue_error) ? $setting->eventCreateSettingDetail[0]->venue_error : '';


            $validationRule = array_merge($validationRule, ['product_search.product_search_' . $language->id => ['nullable', 'string']]);
            $niceNames['product_search.product_search_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->product_search_error) ? $setting->eventCreateSettingDetail[0]->product_search_error : '';


            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
            $niceNames['short_description.short_description_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->short_description_error) ? $setting->eventCreateSettingDetail[0]->short_description_error : '';


            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => ['nullable', 'string', 'maxwords:3000']]);
            $niceNames['description.description_' . $language->id] = isset($setting->eventCreateSettingDetail[0]->description_error) ? $setting->eventCreateSettingDetail[0]->description_error : '';
        }

        $this->validate($request, $validationRule, $errorMessages, $niceNames);

        // if ($request->payment_method == 'stripe' && ($events_remaining == null || $events_remaining <= 0)) {
        //     Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        // }

        try {
            $user = Auth::guard('customers')->user();
            // if (($events_remaining == null || $events_remaining <= 0)) {
            //     if ($request->payment_method == 'stripe') {
            //         try {
            //             $stripeService = new StripeService();
            //             $stripeResponse = $stripeService->eventPackagePayAsGo($request, $user, $package);
            //             $subscription_id = $stripeResponse['subscription_id'];
            //             $stripe_item_id = $stripeResponse['stripe_item_id'];
            //         } catch (\Exception $e) {
            //             return $this->errorResponse($e->getMessage());
            //         }
            //     }
            // }
            $event = Event::whereId($id)->with('eventMedia')->first();
            $mediaId = $event->media_id;
            if (isset($request->gallery_images)) {
                $oldMediaPath = [];
                $oldMediaIds = [];
                if (isset($event->eventMedia)) {
                    foreach ($event->eventMedia as $key => $eventMedia) {
                        if (isset($eventMedia->media)) {
                            $oldMediaPath[] = $eventMedia->media->path;
                            if (in_array($eventMedia->media->path, $request->gallery_images)) {
                                $oldMediaIds[] = $eventMedia->media->id;
                            }
                        }
                    }
                }
                $newMedia = array_merge(array_diff($request->gallery_images, $oldMediaPath), array_diff($oldMediaPath, $request->gallery_images));
                $galleryImages = [];
                if ($newMedia) {
                    $galleryImages = $this->moveFile($newMedia, 'media/events', 'events');
                    if (isset($galleryImages[0]) && empty($oldMediaIds)) {
                        $mediaId = isset($galleryImages, $galleryImages[0]) ? $galleryImages[0]->id : null;
                    } else if (isset($oldMediaIds[0])) {
                        $mediaId = $oldMediaIds[0];
                    }
                }
            }

            foreach ($languages as $language) {
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                    $slug = $request['title']['title_' . $language->id] ?? null;
                }
            }
            EventMedia::whereNotIn('media_id', $oldMediaIds)->whereEventId($event->id)->delete();
            Event::whereId($id)->update([
                'zipcode' => $request->zipcode,
                'media_id' => $mediaId,
                'slug' => $this->generateUniqueSlug($slug),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'event_website' => $request->event_website,
                'exibitors_url' => $request->exibitors_url,
                'visitors_url' => $request->visitors_url,
                'press_url' => $request->press_url,
                'video_url' => $request->video_url,
                'facebook_url' => $request->facebook_url,
                'twitter_url' => $request->twitter_url,
                'linkedin_url' => $request->linkedin_url,
                'youtube_url' => $request->youtube_url,
                'pintrest_url' => $request->pintrest_url,
                'instagram_url' => $request->instagram_url,
                'snapchat_url' => $request->snapchat_url,
                'customer_id' => isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : null,
            ]);
            // if ($request->payment_method == 'paypal') {
            //     $event->update([
            //         'deleted_at' => date('Y-m-d H:i:s')
            //     ]);
            // }

            if ($event) {
                if (isset($galleryImages)) {
                    // EventMedia::whereEventId($event->id)->delete();
                    foreach ($galleryImages as $key => $file) {
                        EventMedia::create([
                            'event_id' => $event->id,
                            'media_id' => $file->id,
                        ]);
                    }
                }
                foreach ($languages as $language) {
                    $eventDetail = EventDetail::whereEventId($event->id)->whereLanguageId($language->id)->exists();
                    if ($eventDetail) {
                        EventDetail::whereEventId($event->id)->whereLanguageId($language->id)->update([
                            'title' => $request['title']['title_' . $language->id] ?? null,
                            'country' => $request['country']['country_' . $language->id] ?? null,
                            'city' => $request['city']['city_' . $language->id] ?? null,
                            'street_name' => $request['street_name']['street_name_' . $language->id] ?? null,
                            'venue' => $request['venue']['venue_' . $language->id] ?? null,
                            'product_search' => $request['product_search']['product_search_' . $language->id] ?? null,
                            'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                            'description' => $request['description']['description_' . $language->id] ?? null,
                        ]);
                    } else {
                        EventDetail::create([
                            'event_id' => $event->id,
                            'language_id' => $language->id,
                            'title' => $request['title']['title_' . $language->id] ?? null,
                            'country' => $request['country']['country_' . $language->id] ?? null,
                            'city' => $request['city']['city_' . $language->id] ?? null,
                            'street_name' => $request['street_name']['street_name_' . $language->id] ?? null,
                            'venue' => $request['venue']['venue_' . $language->id] ?? null,
                            'product_search' => $request['product_search']['product_search_' . $language->id] ?? null,
                            'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                            'description' => $request['description']['description_' . $language->id] ?? null,
                        ]);
                    }
                }
                $contacts = $request->input('contacts');
                EventContact::whereEventId($event->id)->delete();

                foreach ($contacts as $contactData) {
                    $contact = [
                        'event_id' => $event->id,
                        'name' => $contactData['name'],
                        'email' => $contactData['email'],
                        'phone' => $contactData['phone'],
                        // 'designation' => $contactData['designation'],
                        'image_path' => $contactData['image_path'],
                    ];
                    if (isset($contactData['id'])) {
                        EventContact::whereId($contactData['id'])->update($contact);
                    } else {
                        EventContact::create($contact);
                    }
                }
                // if ($request->payment_method == 'paypal') {
                //     $paypalService = new PaypalService();
                //     $paypalResponse = $paypalService->createSubscription($request, $user, $package, 'customer_create_event');

                //     Customer::whereId($user->id)->update([
                //         'temp_registration_package_id' => $event->id,
                //     ]);

                //     if ($paypalResponse['status'] == 'Error') {
                //         return $this->errorResponse($paypalResponse['message']);
                //     } else if ($paypalResponse['status'] == 'Success') {
                //         $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_19']);
                //         $message_19 = isset($general_messages['message_19']) ? $general_messages['message_19'] : '';

                //         return $this->successResponse(
                //             [
                //                 'type' => 'paypal',
                //                 'redirect_url' => $paypalResponse['redirect_url'],
                //             ],
                //             $message_19,
                //         );
                //     }
                //     return $this->errorResponse();
                // }
                // if (($events_remaining == null || $events_remaining <= 0)) {
                //     Order::create([
                //         'registration_package_id' => $package->id,
                //         'customer_id' => auth()->guard('customers')->user()->id,
                //         'type' => 'event',
                //         'payment_method' => $request->payment_method,
                //         'transaction_id' => isset($subscription_id) ? $subscription_id : null,
                //         'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                //         'amount' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : $package->price,
                //     ]);
                // }
                // if (isset(Auth::guard('customers')->user()->id)) {
                //     Customer::whereId(Auth::guard('customers')->user()->id)->update([
                //         'events_remaining' => Auth::guard('customers')->user()->events_remaining - 1
                //     ]);
                // }

                // $defaultLang = getDefaultLanguage(1);

                // $event = Event::with('customer')->with(['eventDetail' => function ($q) use ($defaultLang) {
                //     $q->where('language_id', $defaultLang->id);
                // }])->whereId($event->id)->first();


                // Mail::to(Auth::guard('customers')->user()->email)->send(new EventCreationInvoiceMail($event, 'customer'));
                // $general_setting = getGeneralSettingByKey();
                // if (isset($general_setting['admin_email'])) {
                //     $adminEmailsArr = explode(',', $general_setting['admin_email']);
                //     $event->email_to = 'admin';
                // }
                // if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
                //     $to_email = $adminEmailsArr[0];
                //     unset($adminEmailsArr[0]);
                //     // Mail::to($to_email)->cc($adminEmailsArr)->send(new EventCreationInvoiceMail($event, 'admin'));
                // } else {
                //     $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
                //     if ($to_email) {
                //         // Mail::to($to_email)->send(new EventCreationInvoiceMail($event, 'admin'));
                //     }
                // }

                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_21']);
                $message_21 = isset($general_messages['message_21']) ? $general_messages['message_21'] : '';

                return $this->apiSuccessResponse(new EventResource($event), $message_21);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
            return $this->errorResponse($e->getMessage());
        }
    }

    function getProfilePackages()
    {
        $registrationPackages = RegistrationPackage::query();
        if (isset($_GET['onlyProfilePackages']) && $_GET['onlyProfilePackages'] == '1') {
            $registrationPackages = $registrationPackages->whereType('profile');
        }

        return $this->apiSuccessResponse(new RegistrationPackageResource($registrationPackages), 'packages get successfully.');
    }

    function acceptCookies(Request $request)
    {
        // Session::put('cookies_allow', 1);
        $cookie_name = "cookies_allow";
        $cookie_value = true;
        $expiration_time = (time() + 3600 * 24 * 7) * 2; // Cookie expires in 2 weeks

        setcookie($cookie_name, $cookie_value, $expiration_time, "/");
        return true;
    }

    function getStaticSetting()
    {
        if (isset($_GET['getGeneralSetting']) && $_GET['getGeneralSetting'] == '1') {
            $setting = getI2bModalSetting(null, ['general']);
            return $this->successResponse($setting, 'package setting get successfully.');
        } else if (isset($_GET['GetUpgradeModalSetting']) && $_GET['GetUpgradeModalSetting'] == '1') {
            $setting = getI2bModalSetting(null, ['upgrade_modal']);
            return $this->successResponse($setting, 'package setting get successfully.');
        }
    }

    function getEventListingSetting()
    {
        $lang = getDefaultLanguage(1);
        $eventListingSettting = EventListingSetting::query();
        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $eventListingSettting = $eventListingSettting->wherePageId($_GET['findByPageId']);
        }
        if (isset($_GET['withEventListingSettingDetail']) && $_GET['withEventListingSettingDetail'] == '1') {
            $eventListingSettting = $eventListingSettting->with(['eventListingSettingDetail' => function ($q) use ($lang) {
                $q->where('language_id', $lang->id);
            }]);
        }
        $eventListingSettting = $eventListingSettting->first();
        return $this->successResponse(new EventListingSettingResource($eventListingSettting), 'package setting get successfully.');
    }
    function getSponserListingSetting()
    {
        // dd( $_GET['findByPageId']);
        $lang = getDefaultLanguage(1);
        $sponserListingSettting = SponserListingSetting::query();
        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $sponserListingSettting = $sponserListingSettting->wherePageId($_GET['findByPageId']);
        }
        if (isset($_GET['withSponserListingSettingDetail']) && $_GET['withSponserListingSettingDetail'] == '1') {
            $sponserListingSettting = $sponserListingSettting->with(['sponserListingSettingDetail' => function ($q) use ($lang) {
                $q->where('language_id', $lang->id);
            }]);
        }
        $sponserListingSettting = $sponserListingSettting->first();
        return $this->successResponse(new SponserListingSettingResource($sponserListingSettting), 'package setting get successfully.');
    }
    function getCaptchaError()
    {
        $general_messages = getStaticTranslationByKey(null, 'general_messages', ['message_26']);
        $message_26 = isset($general_messages['message_26']) ? $general_messages['message_26'] : '';
        return $this->errorResponse($message_26);
    }

    function getBusinessProfileLimitError()
    {
        $general_messages = getStaticTranslationByKey(null, 'general_messages', ['message_28']);
        $message_28 = isset($general_messages['message_28']) ? $general_messages['message_28'] : '';
        return $this->errorResponse($message_28);
    }

    function getPasswordMissMatchError()
    {
        $general_messages = getStaticTranslationByKey(null, 'general_messages', ['message_29']);
        $message_29 = isset($general_messages['message_29']) ? $general_messages['message_29'] : '';
        return $this->errorResponse($message_29);
    }

    // function visitorStats(Request $request)
    // {
    //     $helperService = new HelperService;
    //     $ip = $helperService->getRealIpAddr();
    //     $ua = $helperService->getBrowser();
    //     $browser = isset($ua['name']) ? $ua['name'] : null;
    //     $browser_version = isset($ua['version']) ? $ua['version'] : null;
    //     $visitorInfo = VisitorInfo::whereIpAddress($ip)->where('browser', $browser)->where('browser_version', $browser_version)->first();
    //     if (!$visitorInfo) {
    //         $location = $helperService->ip_info($ip, "location");
    //         $visitorInfo = VisitorInfo::create([
    //             'ip_address' => $ip,
    //             'country' => isset($location['country']) ? $location['country'] : null,
    //             'country_code' => isset($location['country_code']) ? $location['country_code'] : null,
    //             'state' => isset($location['state']) ? $location['state'] : null,
    //             'city' => isset($location['city']) ? $location['city'] : null,
    //             'browser' => isset($ua['name']) ? $ua['name'] : null,
    //             'browser_version' => isset($ua['version']) ? $ua['version'] : null,
    //             'platform' => isset($ua['platform']) ? $ua['platform'] : null,
    //             'user_agent' => isset($ua['userAgent']) ? $ua['userAgent'] : null,
    //         ]);
    //     }


    //     if ($request->type == 'tab-overview') {
    //         $type = 'overview';
    //     } else if ($request->type == 'tab-media') {
    //         $type = 'media';
    //     } else if ($request->type == 'tab-contact') {
    //         $type = 'contact';
    //     }

    //     $sql = BusinessProfileStats::where('created_at', '>', Carbon::now()->subMinutes(10)->toDateTimeString())->where('type', $type)->exists();

    //     if (!$sql) {
    //         BusinessProfileStats::create([
    //             'customer_profile_id' => $request->profile_id,
    //             'visitor_info_id' => $visitorInfo->id,
    //             'type' => $type,
    //         ]);
    //     }

    //     return $this->successResponse([], 'Stats update successfully!');
    // }
    function visitorStats(Request $request)
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

        $type = null;
        if ($request->type == 'tab-overview') {
            $type = 'overview';
        } else if ($request->type == 'tab-media') {
            $type = 'media';
        } else if ($request->type == 'tab-contact') {
            $type = 'contact';
        } else if ($request->type == 'cta_click') {
            $type = 'cta_click';
        }

        if ($type) {
            $sql = BusinessProfileStats::where('created_at', '>', Carbon::now()->subMinutes(10)->toDateTimeString())->where('type', $type)->exists();

            if (!$sql) {
                BusinessProfileStats::create([
                    'customer_profile_id' => $request->profile_id,
                    'visitor_info_id' => $visitorInfo->id,
                    'type' => $type,
                ]);
            }
        }

        return $this->successResponse([], 'Stats update successfully!');
    }
    function confirmUnsubscribe()
    {
        $url = langBasedURL(null, route('front.index'));
        if (!isset($_GET['q'])) {
            Session::flash('message', "Link has been expired");
            Session::flash('type', 'success');
            return Redirect::to($url);
        }
        $infoLetter = InfoLetter::where('subscribe_hash', $_GET['q'])->first();
        if (!$infoLetter) {
            Session::flash('message', "Link has been expired");
            Session::flash('type', 'success');
            return Redirect::to($url);
        }
        return view('web.unsubscribe-info-letter.index');
    }

    // public function unsubscribeInfoLetter(Request $request)
    // {
    //     $validationRule = [
    //         'q' => ['required', 'exists:App\Models\InfoLetter,subscribe_hash'],
    //     ];
    //     $niceNames['q'] = "link";
    //     $this->validate(
    //         $request,
    //         $validationRule,
    //         [],
    //         $niceNames
    //     );

    //     $infoLetter = InfoLetter::where('subscribe_hash', $request->q)->first();
    //     InfoLetter::where('email', $infoLetter->email)->update([
    //         'is_subscribe' => 0,
    //     ]);

    //     Session::flash(
    //         'message',
    //         'This is a confirmation that your preference to no longer receive emails related to our Info Letter has been updated. This change has been recorded for the email address ' . $infoLetter->email
    //     );

    //     $url = langBasedURL(null, route('front.index'));

    //     Session::flash('type', 'success');
    //     return Redirect::to($url);
    // }
    public function unsubscribeInfoLetter(Request $request)
    {
        $validationRule = [
            'q' => ['required', 'exists:App\Models\InfoLetter,subscribe_hash'],
        ];
        $niceNames['q'] = "link";
        $this->validate($request, $validationRule, [], $niceNames);

        $defaultLang = getDefaultLanguage(1);
        $infoLetter = InfoLetter::where('subscribe_hash', $request->q)->first();

        // Begin transaction
        DB::beginTransaction();

        try {
            // Update both systems
            InfoLetter::where('email', $infoLetter->email)->update(['is_subscribe' => 0]);
            Customer::where('email', $infoLetter->email)->update(['is_subscribe' => 0]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('message', "Failed to update subscription preferences");
            Session::flash('type', 'error');
            return Redirect::back();
        }

        $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_65']);
        $message = isset($general_messages['message_65']) ?
            str_replace('{email}', $infoLetter->email, $general_messages['message_65']) :
            'You have been unsubscribed from all our email communications. This change has been recorded for the email address ' . $infoLetter->email;

        Session::flash('message', $message);
        Session::flash('type', 'success');

        return Redirect::to(langBasedURL(null, route('front.index')));
    }
    function confirmUnsubscribeHoliday()
    {
        $url = langBasedURL(null, route('front.index'));
        if (!isset($_GET['q'])) {
            Session::flash('message', "Link has been expired");
            Session::flash('type', 'success');
            return Redirect::to($url);
        }

        $customer = Customer::where('subscribe_hash', $_GET['q'])->first();
        if (!$customer) {
            Session::flash('message', "Link has been expired");
            Session::flash('type', 'success');
            return Redirect::to($url);
        }

        return view('web.unsubscribe-holiday-email.index');
    }

    // public function unsubscribeHoliday(Request $request)
    // {
    //     $validationRule = [
    //         'q' => ['required', 'exists:App\Models\Customer,subscribe_hash'],
    //     ];

    //     $niceNames['q'] = "link";
    //     $this->validate($request, $validationRule, [], $niceNames);

    //     $customer = Customer::where('subscribe_hash', $request->q)->first();
    //     $customer->update([
    //         'is_subscribe' => 0,
    //     ]);

    //     Session::flash(
    //         'message',
    //         'You have been unsubscribed from holiday emails. This change has been recorded for the email address ' . $customer->email
    //     );

    //     $url = langBasedURL(null, route('front.index'));
    //     Session::flash('type', 'success');
    //     return Redirect::to($url);
    // }

    public function unsubscribeHoliday(Request $request)
    {
        $validationRule = [
            'q' => ['required', 'exists:App\Models\Customer,subscribe_hash'],
        ];

        $niceNames['q'] = "link";
        $this->validate($request, $validationRule, [], $niceNames);

        $defaultLang = getDefaultLanguage(1);
        $customer = Customer::where('subscribe_hash', $request->q)->first();

        // Begin database transaction to ensure both updates succeed or fail together
        DB::beginTransaction();

        try {
            // Update both systems
            $customer->update(['is_subscribe' => 0]);
            InfoLetter::where('email', $customer->email)->update(['is_subscribe' => 0]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Session::flash('message', "Failed to update subscription preferences");
            Session::flash('type', 'error');
            return Redirect::back();
        }

        $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_65']);
        $message = isset($general_messages['message_65']) ?
            str_replace('{email}', $customer->email, $general_messages['message_65']) :
            'You have been unsubscribed from all our email communications. This change has been recorded for the email address ' . $customer->email;

        Session::flash('message', $message);
        Session::flash('type', 'success');

        return Redirect::to(langBasedURL(null, route('front.index')));
    }
    protected function generateUniqueSlug($initialSlug): string
    {
        $slug = Str::slug($initialSlug);
        $count = 1;

        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($initialSlug . '-' . $count);
            $count++;
        }

        return $slug;
    }
}
