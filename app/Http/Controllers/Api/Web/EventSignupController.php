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
use Illuminate\Support\Facades\URL;
use Stripe\Stripe;

class EventSignupController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function signup(Request $request)
    {
        // Decode and clean business_categories_id if present (for consistency, even though not validated for events)
        if ($request->has('business_categories_id') && $request->business_categories_id) {
            $businessCategoriesId = json_decode($request->business_categories_id, true);
            if (is_array($businessCategoriesId)) {
                $businessCategoriesId = array_values(array_unique(array_filter($businessCategoriesId, function($id) {
                    return !is_null($id) && $id !== '' && $id !== 0;
                })));
                $request['business_categories_id'] = $businessCategoriesId;
            } else {
                $request['business_categories_id'] = [];
            }
        }
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
            
            // Initialize activeEmailUrl variable
            $activeEmailUrl = null;
            
            if ($loggedInCustomer) {
                // User is already logged in - use their account for additional event
                $customer = $loggedInCustomer;
                // Get existing active_email_url or create a new one if it doesn't exist
                $activeEmailUrl = $customer->active_email_url;
                if (!$activeEmailUrl) {
                    $activeEmailUrl = Hash::make($customer->email);
                    $customer->update(['active_email_url' => $activeEmailUrl]);
                }
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
                    // Get existing active_email_url or create a new one if it doesn't exist
                    $activeEmailUrl = $customer->active_email_url;
                    if (!$activeEmailUrl) {
                        $activeEmailUrl = Hash::make($customer->email);
                        $customer->update(['active_email_url' => $activeEmailUrl]);
                    }
                    // Update event-related fields and add event role for existing customer
                    $customer->update([
                        'registration_package_id' => $request->package_id,
                        'package_price' => $price,
                        'package_subscribed_date' => date('Y-m-d'),
                        'package_expiry_date' => $package_validity ?? date('Y-m-d'),
                        'is_package_amount_paid' => 0,
                        'events_allowed' => $eventsAllowed,
                        'events_remaining' => max(0, ($customer->events_remaining ?? 0)),
                        'is_event' => true,
                    ]);
                }
            }

            $galleryImages = null;
            if (isset($request->gallery_images) && !empty($request->gallery_images)) {
                $galleryImages = $this->moveFile($request->gallery_images, 'media/events', 'events');
            }
            $contacts = $request->input('contacts', []);
            foreach ($languages as $language) {
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                    $slug = $request['title']['title_' . $language->id] ?? null;
                }
            }
            $event = Event::create([
                'zipcode' => $request->zipcode,
                'media_id' => isset($galleryImages, $galleryImages[0]) ? $galleryImages[0]->id : null,
                'slug' => $this->generateUniqueEventSlug($slug),
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
                'payment_method' => null,
                'payment_method_id' => null,
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
            $data['contact_person_name'] = isset($contacts[0]['name']) ? $contacts[0]['name'] : $request->name;
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

            // Verification email and redirect: depend on new vs existing and verify_customer_email
            $emailSent = false;
            $redirectToReview = false;

            $shouldSendVerification = $isNewCustomer
                || (!$loggedInCustomer && $existingCustomer && ($customer->verify_customer_email ?? 0) != 1);

            if ($shouldSendVerification) {
                try {
                    Log::info('Attempting to send verification email', [
                        'email' => $request->email,
                        'customer_id' => $customer->id ?? null,
                        'is_new_customer' => $isNewCustomer
                    ]);
                    Mail::to($request->email)->send(new CustomerVerifyEmailMail($data));
                    $emailSent = true;
                    Log::info('Verification email sent successfully', [
                        'email' => $request->email,
                        'customer_id' => $customer->id ?? null
                    ]);
                } catch (\Exception $emailException) {
                    Log::error('Failed to send verification email', [
                        'email' => $request->email,
                        'customer_id' => $customer->id ?? null,
                        'error' => $emailException->getMessage(),
                        'trace' => $emailException->getTraceAsString()
                    ]);
                }
            } elseif (!$loggedInCustomer && $existingCustomer && ($customer->verify_customer_email ?? 0) == 1) {
                $redirectToReview = true;
                Log::info('Existing verified customer - redirect to review without verification email', [
                    'email' => $request->email,
                    'customer_id' => $customer->id ?? null
                ]);
            } else {
                Log::info('Skipping verification email - logged-in customer', [
                    'email' => $request->email,
                    'customer_id' => $customer->id ?? null
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Event signup failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse($e->getMessage());
        }

        $general_setting = getGeneralSettingByKey();
        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_37', 'message_20', 'message_20_review']);

        if ($redirectToReview) {
            $message_20_review = $general_messages['message_20_review'] ?? 'Your event has been submitted. You have been logged in.';
            $data['redirect_url'] = URL::temporarySignedRoute(
                'web.event-signup.verify-and-redirect',
                now()->addMinutes(60),
                ['customer_id' => $customer->id, 'abbreviation' => $defaultLang->abbreviation ?? 'en']
            );
            return $this->successResponse($data, $message_20_review);
        }

        $message_37 = $general_messages['message_37'] ?? '';
        Session::flash('message', $message_37);
        Session::flash('type', 'success');
        $url = langBasedURL(null, $general_setting['user_signin_page']);
        $data['redirect_url'] = url($url);
        $message_20 = $general_messages['message_20'] ?? '';
        return $this->successResponse($data, $message_20);
    }

    public function signupPayment(Request $request)
    {
        // Decode and clean business_categories_id if present (for consistency, even though not validated for events)
        if ($request->has('business_categories_id') && $request->business_categories_id) {
            $businessCategoriesId = json_decode($request->business_categories_id, true);
            if (is_array($businessCategoriesId)) {
                $businessCategoriesId = array_values(array_unique(array_filter($businessCategoriesId, function($id) {
                    return !is_null($id) && $id !== '' && $id !== 0;
                })));
                $request['business_categories_id'] = $businessCategoriesId;
            } else {
                $request['business_categories_id'] = [];
            }
        }
        $request['gallery_images'] = isset($request->gallery_images) && $request->gallery_images != null ? json_decode($request->gallery_images) : null;
        
        // Get authenticated user
        $loggedInUser = auth()->guard('customers')->user();
        
        // If user is logged in and email is not provided, use their email
        if ($loggedInUser && !$request->has('email')) {
            $request->merge(['email' => $loggedInUser->email]);
        }
        
        $validationRule = [
            'name' => ['required', 'string'],
            'business_name' => ['nullable', 'string'],
            'email' => ['required', 'email'], // Email is required but can come from authenticated user
            'package_id' => ['required', 'exists:registration_packages,id'],
            'zipcode' => ['nullable'],
            'gallery_images' => ['nullable', 'array'], // Optional: Review & Confirm page has no Main Event Image upload
            'start_date' => ['required', 'date'], // Added start_date validation
            'end_date' => ['required', 'date', 'after_or_equal:start_date'], // Added end_date validation
            'event_website' => ['required', new ValidUrl()], // Added event_website validation
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
            'contacts.*.name' => 'required|string|max:255', // Uncommented contacts validation
            'contacts.*.email' => 'required|email|max:255',
            'contacts.*.phone' => 'required|string|max:20',
            // 'contacts.*.designation' => 'required|string|max:255',
            'contacts.*.image_path' => 'nullable|string|max:255',
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

        // Add language-specific validation rules
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
        $totalAmount = 0;
        $eventsAllowed = 0;
        if ($package) {
            $price = $package->event_price ?? 0;
            $totalAmount = $package->event_price ?? 0;
            $eventsAllowed = $package->events_allowed;
            $package_validity = date('Y-m-d', strtotime('+1 months'));
        }
        
        // For logged-in users, check if they're free users or already have a package
        // If so, they don't need to pay for event registration
        if ($loggedInUser) {
            // If user is a free exporter or already has events_remaining, they don't need to pay
            $isFreeUser = ($loggedInUser->package_price ?? 0) == 0;
            $hasExistingPackage = ($loggedInUser->registration_package_id ?? null) !== null;
            
            if ($isFreeUser || $hasExistingPackage) {
                $price = 0;
                $totalAmount = 0;
                Log::info('Event Signup Payment - Free user or existing package holder', [
                    'user_id' => $loggedInUser->id,
                    'is_free_user' => $isFreeUser,
                    'has_existing_package' => $hasExistingPackage,
                    'package_price' => $loggedInUser->package_price ?? 0
                ]);
            }
        }
        
        // Log package details for debugging
        Log::info('Event Signup Payment - Package Details', [
            'package_id' => $request->package_id,
            'package_name' => $package ? ($package->registrationPackageDetail[0]->name ?? 'N/A') : 'Not Found',
            'event_price' => $price,
            'has_payment_method' => $request->has('payment_method'),
            'payment_method' => $request->payment_method ?? 'none',
            'is_logged_in' => $loggedInUser ? true : false
        ]);
        
        // Only require payment if price > 0 AND payment_method is provided
        if ($price > 0 && $request->has('payment_method')) {
            $validationRule = array_merge($validationRule, [
                'payment_method' => ['required', 'in:stripe,paypal'],
            ]);
            
            if ($request->payment_method == 'stripe') {
                $validationRule = array_merge($validationRule, [
                    'card_holder_name' => ['required'],
                    'payment_method_id' => ['required', 'string']
                ]);
                $niceNames = array_merge($niceNames, [
                    'payment_method_id' => 'Card information is required'
                ]);
                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            }
        }

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_29']);
        $message_29 = isset($general_messages['message_29']) ? $general_messages['message_29'] : '';
        $messages = [
            'password.confirmed' => $message_29
        ];

        // Log request data for debugging
        Log::info('Event Signup Payment - Validating request', [
            'has_email' => $request->has('email'),
            'has_gallery_images' => $request->has('gallery_images'),
            'gallery_images_type' => gettype($request->gallery_images),
            'has_start_date' => $request->has('start_date'),
            'has_end_date' => $request->has('end_date'),
            'has_event_website' => $request->has('event_website'),
            'has_contacts' => $request->has('contacts'),
            'contacts_count' => is_array($request->contacts) ? count($request->contacts) : 0,
            'has_title' => $request->has('title'),
            'has_country' => $request->has('country'),
            'has_city' => $request->has('city'),
        ]);

        try {
            $this->validate(
                $request,
                $validationRule,
                $messages,
                $niceNames
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Event Signup Payment - Validation Failed', [
                'errors' => $e->errors(),
                'failed_rules' => array_keys($e->errors())
            ]);
            throw $e;
        }

        try {
            Log::info('===== Event Signup Payment Started =====');
            Log::info('Request Data:', $request->except(['password', 'password_confirmation', 'card_holder_name', 'payment_method_id']));
            
            // Get the logged-in customer
            $customer = auth()->guard('customers')->user();
            
            if (!$customer) {
                Log::error('No authenticated customer found for event signup payment');
                return $this->errorResponse('You must be logged in to register for an event.');
            }
            
            // Initialize payment-related vars (used when price > 0; avoid undefined when free)
            $subscription_id = null;
            $stripe_item_id = null;
            $stripe_customer_id = null;
            $payment_method_id = null;
            
            // Process payment if price > 0
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

            // Update customer with package info
            $customer->update([
                'name' => $request->name,
                'business_name' => $request->business_name,
                'registration_package_id' => $request->package_id,
                'package_price' => $price,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_validity ?? date('Y-m-d'),
                'is_package_amount_paid' => 1,
                'events_allowed' => $eventsAllowed,
                'events_remaining' => max(0, ($customer->events_remaining ?? $eventsAllowed) - 1),
                'images_allowed' => $package->images_allowed ?? 0,
                'subscription_id' => $request->payment_method == 'stripe' && isset($subscription_id) ? $subscription_id : null,
                'payment_method' => $request->payment_method ?? null,
                'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                'stripe_customer_id' => $stripe_customer_id ?? null,
            ]);

            // Create the event
            $galleryImages = null;
            if (isset($request->gallery_images) && !empty($request->gallery_images)) {
                $galleryImages = $this->moveFile($request->gallery_images, 'media/events', 'events');
            }
            
            $contacts = $request->input('contacts', []);
            $slug = null;
            foreach ($languages as $language) {
                if ($language->is_default == '1') {
                    $slug = $request['title']['title_' . $language->id] ?? null;
                }
            }
            
            $event = Event::create([
                'zipcode' => $request->zipcode,
                'media_id' => isset($galleryImages, $galleryImages[0]) ? $galleryImages[0]->id : null,
                'slug' => $this->generateUniqueEventSlug($slug),
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
                'payment_method' => $request->payment_method ?? null,
                'payment_method_id' => isset($subscription_id) ? $subscription_id : null,
            ]);

            if ($event) {
                // Save event media
                if (isset($galleryImages)) {
                    foreach ($galleryImages as $key => $file) {
                        EventMedia::create([
                            'event_id' => $event->id,
                            'media_id' => $file->id,
                        ]);
                    }
                }
                
                // Save event details for all languages
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
                
                // Save event contacts
                foreach ($contacts as $contactData) {
                    EventContact::create([
                        'event_id' => $event->id,
                        'name' => $contactData['name'],
                        'email' => $contactData['email'],
                        'phone' => $contactData['phone'],
                        // 'designation' => $contactData['designation'],
                        'image_path' => $contactData['image_path'] ?? null,
                    ]);
                }
            }
            
            // Reload event with details
            $event = $event->load(['eventDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }]);

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

            // Safely get event name from eventDetail
            $eventName = 'N/A';
            if (isset($event->eventDetail) && count($event->eventDetail) > 0 && isset($event->eventDetail[0]->title)) {
                $eventName = $event->eventDetail[0]->title;
            }

            $data = ['customer' => $customer, 'event_name' => $eventName, 'package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $price];
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

                $data = ['package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $price, 'customer' => $customer, 'order' => $order, 'event_name' => $eventName];

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

                $data = ['package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $price, 'customer' => $customer, 'order' => $order, 'event_name' => $eventName];

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

    /**
     * Verify signed link and log in existing verified customer, then redirect to review-confirmation.
     * Used when existing exporter (not logged in) creates event with already-verified email.
     */
    public function verifyAndRedirectToReview(Request $request)
    {
        $signinUrl = function () {
            $general_setting = getGeneralSettingByKey();
            $slug = $general_setting['user_signin_page'] ?? null;
            return $slug ? url(langBasedURL(null, $slug)) : url('/');
        };

        if (!$request->hasValidSignature()) {
            Log::warning('Event signup verify-and-redirect: invalid or expired signature');
            return Redirect::to($signinUrl())->with('message', 'Invalid or expired link. Please sign in.')->with('type', 'error');
        }

        $customerId = $request->query('customer_id');
        $abbreviation = $request->query('abbreviation', 'en');

        if (!$customerId) {
            Log::warning('Event signup verify-and-redirect: missing customer_id');
            return Redirect::to($signinUrl())->with('message', 'Invalid link.')->with('type', 'error');
        }

        $customer = Customer::find($customerId);
        if (!$customer) {
            Log::warning('Event signup verify-and-redirect: customer not found', ['customer_id' => $customerId]);
            return Redirect::to($signinUrl())->with('message', 'Invalid link.')->with('type', 'error');
        }

        Auth::guard('customers')->login($customer);

        $defaultLang = getDefaultLanguage(1);
        $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_20_review']);
        $message = $general_messages['message_20_review'] ?? 'Your event has been submitted. You have been logged in.';

        Session::flash('message', $message);
        Session::flash('type', 'success');

        return Redirect::to(url(route('user.payment.index', [$abbreviation])));
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

    /**
     * Generate a unique slug for events (checked against Event model).
     */
    protected function generateUniqueEventSlug($initialSlug): string
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
