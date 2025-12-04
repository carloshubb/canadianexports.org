<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\CustomerVerifyEmailMail;
use App\Mail\NewCustomerAdminMail;
use App\Mail\RegistrationInvoiceToCustomerMail;
use App\Mail\WelcomeEventMail;
use App\Models\Customer;
use App\Models\CustomerMedia;
use App\Models\CustomerPaymentMethod;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Models\Event;
use App\Models\EventContact;
use App\Models\EventDetail;
use App\Models\EventMedia;
use App\Models\Order;
use App\Models\Page;
use App\Rules\ValidUrl;
use App\Services\PaypalService;
use App\Services\PDFService;
use App\Services\StripeService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe\Stripe;

class EventSignupController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function signup(Request $request)
    {
        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $request['gallery_images'] = isset($request->gallery_images) && $request->gallery_images != null ? json_decode($request->gallery_images) : null;
        
        // Check if user is already logged in or if email exists
        $loggedInCustomer = \Illuminate\Support\Facades\Auth::guard('customers')->user();
        $existingCustomer = Customer::where('email', $request->email)->first();
        
        $validationRule = [
            'name' => ['required', 'string'],
            'business_name' => ['nullable', 'string'],
            'email' => ['required', 'email'], // REMOVED unique validation to allow existing emails
            'package_id' => ['required', 'exists:registration_packages,id'],
            'zipcode' => ['nullable'],
            'gallery_images' => ['required', 'array'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
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
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.email' => 'required|email|max:255',
            'contacts.*.phone' => 'required|string|max:20',
            // 'contacts.*.designation' => 'required|string|max:255',
            'contacts.*.image_path' => 'nullable|string|max:255',
        ];
        
        // Password only required for NEW users (not logged in AND email doesn't exist)
        if (!$loggedInCustomer && !$existingCustomer) {
            $validationRule['password'] = ['required', 'confirmed', RulesPassword::min(8)->mixedCase()];
        }
        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $eventSignupSetting = getEventSignupSetting($defaultLang, Page::whereId($request->page_id)->first());
            $eventSignupSettingDetail = $eventSignupSetting->eventSignupSettingDetail;
            $setting = getEventCreateSettingById($defaultLang, $request->create_page_id);
            $niceNames = [
                'name' => isset($eventSignupSettingDetail[0]->name_error) ? $eventSignupSettingDetail[0]->name_error : '',
                'business_name' => isset($eventSignupSettingDetail[0]->business_name_error) ? $eventSignupSettingDetail[0]->business_name_error : '',
                'email' => isset($eventSignupSettingDetail[0]->email_error) ? $eventSignupSettingDetail[0]->email_error : '',
                'password' => isset($eventSignupSettingDetail[0]->password_error) ? $eventSignupSettingDetail[0]->password_error : '',
                'password_confirmation' => isset($eventSignupSettingDetail[0]->confirm_password_error) ? $eventSignupSettingDetail[0]->confirm_password_error : '',
                'package_id' => isset($eventSignupSettingDetail[0]->package_error) ? $eventSignupSettingDetail[0]->package_error : '',
            ];
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
        }

        $languages = getAllLanguages();
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

        $package = getRegistrationPackage($request->package_id);
        $price = 0;
        $eventsAllowed = 0;
        if ($package) {
            $price = $package->event_price;
            $eventsAllowed = $package->events_allowed;
            $package_validity = date('Y-m-d', strtotime('+1 months'));
        }

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_29']);
        $message_29 = isset($general_messages['message_29']) ? $general_messages['message_29'] : '';
        $messages = [
            'password.confirmed' => $message_29
        ];

        $this->validate(
            $request,
            $validationRule,
            $messages,
            $niceNames
        );

        try {
            // Use logged-in customer or check by email
            $customer = null;
            $sendWelcomeEmail = false;
            $isNewCustomer = false;
            
            if ($loggedInCustomer) {
                // User is already logged in - use their account for additional event
                $customer = $loggedInCustomer;
                Log::info('Logged-in customer creating additional event', ['customer_id' => $customer->id]);
            } else {
                // Not logged in - check if email exists
                $customer = $existingCustomer;
                
                if (!$customer) {
                    // Create new customer account for first-time event creators
                    $activeEmailUrl = Hash::make($request->email);
                    $customer = Customer::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'business_name' => $request->business_name,
                        'is_active' => 1,
                        'password' => Hash::make($request->password),
                        'type' => 'event',
                        'active_email_url' => $activeEmailUrl,
                        'registration_package_id' => $request->package_id,
                        'package_price' => $price,
                        'package_subscribed_date' => date('Y-m-d'),
                        'package_expiry_date' => $package_validity ?? date('Y-m-d'),
                        'is_package_amount_paid' => 0,
                        'events_allowed' => $eventsAllowed,
                        'events_remaining' => $eventsAllowed - 1,
                        'images_allowed' => $package->images_allowed ?? 0,
                    ]);
                    $sendWelcomeEmail = true;
                    $isNewCustomer = true;
                    Log::info('New event customer created', ['customer_id' => $customer->id]);
                    
                    // Create profile for new customer
                    CustomerProfile::create([
                        'customer_id' => $customer->id,
                        'company_name' => $request->business_name,
                        'slug' => $this->generateUniqueSlug($request->business_name),
                    ]);
                    CustomerSocialMedia::create(['customer_id' => $customer->id, 'facebook' => $request->facebook_url, 'twitter' => $request->twitter_url, 'linkedin' => $request->linkedin_url, 'youtube' => $request->youtube_url, 'pintrest' => $request->pintrest_url, 'instagram' => $request->instagram_url, 'snapchat' => $request->snapchat_url]);
                    CustomerMedia::create(['customer_id' => $customer->id]);
                } else {
                    // Email exists - allow user to create event with existing email
                    Log::info('Using existing customer email for new event', ['customer_id' => $customer->id]);
                    $isNewCustomer = false;
                    // Update event-related fields for existing customer
                    $customer->update([
                        'registration_package_id' => $request->package_id,
                        'package_price' => $price,
                        'package_subscribed_date' => date('Y-m-d'),
                        'package_expiry_date' => $package_validity ?? date('Y-m-d'),
                        'is_package_amount_paid' => 0,
                        'events_allowed' => $eventsAllowed,
                        'events_remaining' => max(0, ($customer->events_remaining ?? 0)),
                    ]);
                }
            }

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
                'customer_id' => $customer->id,
                'registration_package_id' => $request->package_id,
                'package_price' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : (isset($package->price) ? $package->price : 0),
                'free_subscription_days' => isset($package->free_subscription_days) ? $package->free_subscription_days : 0,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => date('Y-m-d', strtotime('+' . (isset($package) ? $package->package_validity_months : 0) . ' months')),
                'is_package_amount_paid' => 1,
                'payment_method' => $request->payment_method,
                'payment_method_id' => isset($subscription_id) ? $subscription_id : null,
            ]);

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
                if ($customer->id) {
                    Customer::whereId($customer->id)->update([
                        'events_remaining' => $customer->events_remaining - 1
                    ]);
                }
            }

            $data['user_id'] = $activeEmailUrl;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['contact_person_name'] = $contacts[0]['name'];
            $data['company_name'] = $request->business_name;
            $data['business_categories_name'] = null;
            $data['package'] = $package;
            $data['package_type'] = $package->package_type ?? 'Free';
            $data['package_price'] = $price;
            $data['payment_frequency'] = null;
            $data['created_at'] = date("F d, Y, g:i a");
            $data['signup_page'] = "event";
            $data['end_date'] = $package_validity;

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

            // Only send verification email to new customers
            if ($isNewCustomer) {
                Mail::to($request->email)->send(new CustomerVerifyEmailMail($data));
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_37']);
        $message_37 = isset($general_messages['message_37']) ? $general_messages['message_37'] : '';

        Session::flash('message', $message_37);
        Session::flash('type', 'success');

        $general_setting = getGeneralSettingByKey();
        $url = langBasedURL(null, $general_setting['user_signin_page']);
        $data['redirect_url'] = url($url);
        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_20']);
        $message_20 = isset($general_messages['message_20']) ? $general_messages['message_20'] : '';

        return $this->successResponse($data, $message_20);
    }

    public function signupPayment(Request $request)
    {
        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $request['gallery_images'] = isset($request->gallery_images) && $request->gallery_images != null ? json_decode($request->gallery_images) : null;
        $validationRule = [
            'name' => ['required', 'string'],
            'business_name' => ['nullable', 'string'],
            'package_id' => ['required', 'exists:registration_packages,id'],
            'zipcode' => ['nullable'],
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
            // 'contacts.*.name' => 'required|string|max:255',
            // 'contacts.*.email' => 'required|email|max:255',
            // 'contacts.*.phone' => 'required|string|max:20',
            // 'contacts.*.designation' => 'required|string|max:255',
        ];
        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $eventSignupSetting = getEventSignupSetting($defaultLang, Page::whereId($request->page_id)->first());
            $eventSignupSettingDetail = $eventSignupSetting->eventSignupSettingDetail;
            $payment_setting = getI2bModalSetting($defaultLang, ['payment_setting']);
            $setting = getEventCreateSettingById($defaultLang, $request->create_page_id);
            $niceNames = [
                'name' => isset($eventSignupSettingDetail[0]->name_error) ? $eventSignupSettingDetail[0]->name_error : '',
                'business_name' => isset($eventSignupSettingDetail[0]->business_name_error) ? $eventSignupSettingDetail[0]->business_name_error : '',
                'email' => isset($eventSignupSettingDetail[0]->email_error) ? $eventSignupSettingDetail[0]->email_error : '',
                'password' => isset($eventSignupSettingDetail[0]->password_error) ? $eventSignupSettingDetail[0]->password_error : '',
                'password_confirmation' => isset($eventSignupSettingDetail[0]->confirm_password_error) ? $eventSignupSettingDetail[0]->confirm_password_error : '',
                'package_id' => isset($eventSignupSettingDetail[0]->package_error) ? $eventSignupSettingDetail[0]->package_error : '',
                'card_holder_name' => isset($payment_setting['cardholder_name_error']) ? $payment_setting['cardholder_name_error'] : '',
            ];
            $niceNames['zipcode'] = isset($setting->eventCreateSettingDetail[0]->zipcode_error) ? $setting->eventCreateSettingDetail[0]->zipcode_error : '';
            $niceNames['media_id'] = isset($setting->eventCreateSettingDetail[0]->logo_error) ? $setting->eventCreateSettingDetail[0]->logo_error : '';
            $niceNames['start_date'] = isset($setting->eventCreateSettingDetail[0]->start_date_error) ? $setting->eventCreateSettingDetail[0]->start_date_error : '';
            $niceNames['end_date'] = isset($setting->eventCreateSettingDetail[0]->end_date_error) ? $setting->eventCreateSettingDetail[0]->end_date_error : '';
            $niceNames['event_website'] = isset($setting->eventCreateSettingDetail[0]->event_website_error) ? $setting->eventCreateSettingDetail[0]->event_website_error : '';
            $niceNames['exibitors_url'] = isset($setting->eventCreateSettingDetail[0]->exibitors_url_error) ? $setting->eventCreateSettingDetail[0]->exibitors_url_error : '';
            $niceNames['visitors_url'] = isset($setting->eventCreateSettingDetail[0]->visitors_url_error) ? $setting->eventCreateSettingDetail[0]->visitors_url_error : '';
            $niceNames['press_url'] = isset($setting->eventCreateSettingDetail[0]->press_url_error) ? $setting->eventCreateSettingDetail[0]->press_url_error : '';
            $niceNames['video_url'] = isset($setting->eventCreateSettingDetail[0]->video_url_error) ? $setting->eventCreateSettingDetail[0]->video_url_error : '';
            // $niceNames['contacts.*.name'] = isset($setting->eventCreateSettingDetail[0]->contact_name_error) ? $setting->eventCreateSettingDetail[0]->contact_name_error : '';
            // $niceNames['contacts.*.email'] = isset($setting->eventCreateSettingDetail[0]->contact_email_error) ? $setting->eventCreateSettingDetail[0]->contact_email_error : '';
            // $niceNames['contacts.*.phone'] = isset($setting->eventCreateSettingDetail[0]->contact_phone_error) ? $setting->eventCreateSettingDetail[0]->contact_phone_error : '';
            // $niceNames['contacts.*.designation'] = isset($setting->eventCreateSettingDetail[0]->contact_designation_error) ? $setting->eventCreateSettingDetail[0]->contact_designation_error : '';
            // $niceNames['contacts.*.image_path'] = isset($setting->eventCreateSettingDetail[0]->profile_image_error) ? $setting->eventCreateSettingDetail[0]->profile_image_error : '';
            $niceNames['facebook_url'] = isset($setting->eventCreateSettingDetail[0]->facebook_url_error) ? $setting->eventCreateSettingDetail[0]->facebook_url_error : '';
            $niceNames['twitter_url'] = isset($setting->eventCreateSettingDetail[0]->twitter_url_error) ? $setting->eventCreateSettingDetail[0]->twitter_url_error : '';
            $niceNames['linkedin_url'] = isset($setting->eventCreateSettingDetail[0]->linkedin_url_error) ? $setting->eventCreateSettingDetail[0]->linkedin_url_error : '';
            $niceNames['youtube_url'] = isset($setting->eventCreateSettingDetail[0]->youtube_url_error) ? $setting->eventCreateSettingDetail[0]->youtube_url_error : '';
            $niceNames['pintrest_url'] = isset($setting->eventCreateSettingDetail[0]->pintrest_url_error) ? $setting->eventCreateSettingDetail[0]->pintrest_url_error : '';
            $niceNames['instagram_url'] = isset($setting->eventCreateSettingDetail[0]->instagram_url_error) ? $setting->eventCreateSettingDetail[0]->instagram_url_error : '';
            $niceNames['snapchat_url'] = isset($setting->eventCreateSettingDetail[0]->snapchat_url_error) ? $setting->eventCreateSettingDetail[0]->snapchat_url_error : '';
        }

        $package = getRegistrationPackage($request->package_id);
        $price = 0;
        $totalAmount = 0;
        $eventsAllowed = 0;
        if ($package) {
            $price = $package->event_price;
            $totalAmount = $package->event_price;
            $eventsAllowed = $package->events_allowed;
            $package_validity = date('Y-m-d', strtotime('+1 months'));
        }
        if ($price > 0) {
            $validationRule = array_merge($validationRule, [
                'payment_method' => ['required', 'in:stripe,paypal'],
            ]);
        }
        if (isset($request->payment_method) && $request->payment_method == 'stripe' && $price > 0) {
            $validationRule = array_merge($validationRule, [
                'card_holder_name' => ['required'],
                'payment_method_id' => ['required', 'string']
            ]);
            $niceNames = array_merge($niceNames, [
                'payment_method_id' => 'Card information is required'
            ]);
            if ($request->payment_method == 'stripe') {
                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            }
        }

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_29']);
        $message_29 = isset($general_messages['message_29']) ? $general_messages['message_29'] : '';
        $messages = [
            'password.confirmed' => $message_29
        ];

        $this->validate(
            $request,
            $validationRule,
            $messages,
            $niceNames
        );

        try {
            Log::info('===== Event Signup Payment Started =====');
            Log::info('Request Data:', $request->except(['password', 'password_confirmation', 'card_holder_name', 'payment_method_id']));
            
            if ($price > 0) {
                if ($request->payment_method == 'stripe') {
                    Log::info('Processing Stripe payment for event signup', [
                        'payment_method_id' => $request->payment_method_id ? 'present' : 'missing',
                        'price' => $price
                    ]);
                    
                    $stripeService = new StripeService();
                    $stripeResponse = $stripeService->eventSignup($package, $request);
                    $subscription_id = $stripeResponse['subscription_id'];
                    $stripe_item_id = $stripeResponse['stripe_item_id'];
                    $stripe_customer_id = $stripeResponse['stripe_customer_id'];
                    $payment_method_id = $stripeResponse['payment_method_id'];
                    
                    Log::info('Stripe payment processed successfully', [
                        'subscription_id' => $subscription_id,
                        'stripe_customer_id' => $stripe_customer_id
                    ]);
                } else if ($request->payment_method == 'paypal') {
                    $user = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'business_name' => $request->business_name ?? '',
                    ];
                    $paypalService = new PaypalService();
                    $paypalResponse = $paypalService->createEventSubscription($request, $user, $package);

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
            }

            Customer::where('email', $request->email)->update([
                'name' => $request->name,
                'email' => $request->email,
                'business_name' => $request->business_name,
                'registration_package_id' => $request->package_id,
                'package_price' => $price,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_validity ?? date('Y-m-d'),
                'is_package_amount_paid' => 1,
                'events_allowed' => $eventsAllowed,
                'events_remaining' => $eventsAllowed - 1,
                'images_allowed' => $package->images_allowed ?? 0,
                'subscription_id' => $request->payment_method == 'stripe' && isset($subscription_id) ? $subscription_id : null,
                'payment_method' => $request->payment_method,
                'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                'stripe_customer_id' => $stripe_customer_id ?? null,
            ]);

            $customer = Customer::where('email', $request->email)->first();

            $event = Event::where('customer_id', $customer->id)->with(['eventDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])->first();

            if ($price > 0) {
                CustomerPaymentMethod::create([
                    'customer_id' => $customer->id,
                    'payment_method' => 'stripe',
                    'payment_method_id' => $payment_method_id ?? null,
                    'card_holder_name' => $request->card_holder_name,
                    'card_no' => null,
                    'exp_month' => null,
                    'exp_year' => null,
                    'cvc' => null,
                    'is_default' => 1,
                ]);
            }

            $data = ['customer' => $customer, 'event_name' => $event->eventDetail[0]->title, 'package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $price];
            Mail::to($request->email)->send(new WelcomeEventMail($data));

            if ($totalAmount > 0) {
                $order = Order::create([
                    'registration_package_id' => $package->id,
                    'customer_id' => $customer->id,
                    'type' => 'event',
                    'payment_method' => $request->payment_method ?? null,
                    'transaction_id' => $subscription_id ?? null,
                    'stripe_item_id' => $stripe_item_id ?? null,
                    'amount' => $totalAmount,
                ]);

                $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
                $order->update([
                    'invoice_no' => $invoiceNo
                ]);

                $customer = $customer->loadMissing('customerProfile');

                $data = ['package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $price, 'customer' => $customer, 'order' => $order, 'event_name' => $event->eventDetail[0]->title];

                $PDFService = new PDFService();

                $PDFService->createRegistrationInvoicePDF(null, $data);

                Mail::to($request->email)->send(new RegistrationInvoiceToCustomerMail($data));
            } else {
                $order = Order::create([
                    'registration_package_id' => $package->id,
                    'customer_id' => $customer->id,
                    'type' => 'event',
                ]);

                $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
                $order->update([
                    'invoice_no' => $invoiceNo
                ]);

                $customer = $customer->loadMissing('customerProfile');

                $data = ['package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $price, 'customer' => $customer, 'order' => $order];

                $PDFService = new PDFService();

                $PDFService->createRegistrationInvoicePDF(null, $data);

                Mail::to($request->email)->send(new RegistrationInvoiceToCustomerMail($data));
            }
            
            Log::info('===== Event Signup Payment Completed Successfully =====');
        } catch (\Exception $e) {
            Log::error('===== Event Signup Payment Failed =====');
            Log::error('Exception occurred:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse($e->getMessage());
        }

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_37']);
        $message_37 = isset($general_messages['message_37']) ? $general_messages['message_37'] : '';

        Session::flash('message', $message_37);
        Session::flash('type', 'success');

        $general_setting = getGeneralSettingByKey();
        $url = langBasedURL(null, $general_setting['user_signin_page']);
        $data['redirect_url'] = url($url);
        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_20']);
        $message_20 = isset($general_messages['message_20']) ? $general_messages['message_20'] : '';

        return $this->successResponse($data, $message_20);
    }

    public function logout()
    {
        if (Auth::guard('customers')->check()) {
            Auth::guard('customers')->logout();
        }
        $general_setting = getGeneralSettingByKey();
        $url = langBasedURL(null, $general_setting['user_signin_page']);
        return Redirect::to($url);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('customers')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.profile-settings.index', Auth::guard('customers')->user()->id);
        }

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_25']);
        $message_25 = isset($general_messages['message_25']) ? $general_messages['message_25'] : '';

        return back()->withErrors([
            'email' => $message_25,
        ])->onlyInput('email');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('customers')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function emailValidation(Request $request)
    {
        // REMOVED unique email validation - users can use any email even if it exists
        $validationRule = [
            'email' => ['required', 'email'],
        ];
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $eventSignupSetting = getEventSignupSetting($defaultLang, Page::whereId($request->page_id)->first());
            $eventSignupSettingDetail = $eventSignupSetting->eventSignupSettingDetail;
            $niceNames = [
                'email' => isset($eventSignupSettingDetail[0]->email_error) ? $eventSignupSettingDetail[0]->email_error : '',
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
