<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AutoResponseToCustomerMail;
use App\Mail\BecomeSponsorResponseMail;
use App\Mail\BecomeSponsorMail;
use App\Mail\NewSponsorPaymentNotification;
use App\Mail\SponsorContactRequestNotification;
use App\Mail\SponsorCredentialsMail;
use App\Models\Banner;
use App\Models\CoffeeWallBeneficiary;
use App\Models\Customer;
use App\Models\Sponsor;
use App\Rules\ValidUrl;
use App\Services\EmailSettingService;
use App\Services\PaypalService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class BecomeSponsorController extends Controller
{
    use StatusResponser, FileUploadTrait;


    public function sendMessage(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $setting = getSponsorPageSetting($defaultLang, $request->page_id);
            $niceNames = [
                'name' => $setting->becomeSponsorSettingDetail[0]->name_error ?? '',
                'company_name' => $setting->becomeSponsorSettingDetail[0]->company_name_error ?? '',
                'email' => $setting->becomeSponsorSettingDetail[0]->email_error ?? '',
                'contact_number' => $setting->becomeSponsorSettingDetail[0]->contact_number_error ?? '',
                'message' => $setting->becomeSponsorSettingDetail[0]->message_error ?? '',
                'image' => $setting->becomeSponsorSettingDetail[0]->image_error ?? '',
                'feature_image' => $setting->becomeSponsorSettingDetail[0]->feature_image_error ?? '',
                'url' => $setting->becomeSponsorSettingDetail[0]->url_error ?? '',
                'time_to_call' => $setting->becomeSponsorSettingDetail[0]->time_to_call_error ?? '',
                'appointment' => $setting->becomeSponsorSettingDetail[0]->appointment_error ?? '',
                'appointment_date' => $setting->becomeSponsorSettingDetail[0]->appointment_date_error ?? '',
            ];
        }
        $data = $this->validate($request, [
            "name" => "required",
            "company_name" => "required",
            "email" => "required|email",
            "contact_number" => "required|string",
            "summary" => "required|string",
            "detail_description" => "required|string",
            "message" => "required|string",
            "url" => ['required', new ValidUrl()],
            "time_to_call" => ['required', 'in:am,pm'],
            "appointment" => ['required', 'in:yes,no'],
            "appointment_date" => ['nullable', 'date', 'after:today'],
            'image' => ['nullable', 'string'],
            'feature_image' => ['nullable', 'string']
        ], [], $niceNames);

        $emailService = new EmailSettingService();
        $result = $emailService->canadianExportersForm();
        if ($result['status'] == 'Error') {
            return $result;
        }

        $general_setting = getGeneralSettingByKey();
        if (isset($general_setting['admin_email'])) {
            $adminEmailsArr = explode(',', $general_setting['admin_email']);
        }
        if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
            $to_email = $adminEmailsArr[0];
            unset($adminEmailsArr[0]);
            Mail::to($to_email)->cc($adminEmailsArr)->send(new BecomeSponsorMail($data));
        } else {
            $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
            if ($to_email) {
                Mail::to($to_email)->send(new BecomeSponsorMail($data));
            }
        }

        Mail::to($request->email)->send(new BecomeSponsorResponseMail([
            'name' => $data['name']
        ]));

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_46']);
        $message_46 = isset($general_messages['message_46']) ? $general_messages['message_46'] : '';

        return $this->successResponse([], $message_46);
    }

    public function updateProfile(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $setting = getSponsorPageSetting($defaultLang, $request->page_id);
            $niceNames = [
                'name' => $setting->becomeSponsorSettingDetail[0]->name_error ?? '',
                'company_name' => $setting->becomeSponsorSettingDetail[0]->company_name_error ?? '',
                'email' => $setting->becomeSponsorSettingDetail[0]->email_error ?? '',
                'feature_image' => $setting->becomeSponsorSettingDetail[0]->feature_image_error ?? '',
                'image' => $setting->becomeSponsorSettingDetail[0]->image_error ?? '',
                'url' => $setting->becomeSponsorSettingDetail[0]->url_error ?? '',
            ];
        }
        $data = $this->validate($request, [
            "name" => "required",
            "company_name" => "required",
            "email" => "required|email",
            "summary" => "required|string",
            "detail_description" => "required|string",
            "url" => ['required', new ValidUrl()],
            'feature_image' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
        ], [], $niceNames);

        if (isset($request->feature_image) && !is_array($request->feature_image)) {
            $media = json_decode($request->feature_image, 1);
            $files = $this->moveFile($media, 'media/banners', ($request->type == 'banners' ? 'banners' : 'sponsor'));
        }
        if (isset($request->image) && !is_array($request->image)) {
            $media = json_decode($request->image, 1);
            $files2 = $this->moveFile($media, 'media/banners', ($request->type == 'banners' ? 'banners' : 'sponsor'));
        }

        $banner = Banner::whereId($request->id)->first();
        $banner->update([
            'business_name' => $request->company_name,
            'small_business_description' => $request->summary,
            'detail_description' => $request->detail_description,
            'url' => $request->url,
            'media_id' => !isset($request->feature_image) ? null : (isset($files, $files[0]) ? $files[0]->id : $banner->media_id),
            'image' => isset($files2, $files2[0]) ? $files2[0]->id : $banner->image,
        ]);

        Customer::whereId($banner->customer_id)->update([
            'email' => $request->email,
            'name' => $request->name,
        ]);

        return $this->successResponse([], 'Profile updated successfully');
    }

    /**
     * Process sponsor payment and registration
     * Handles both "Enter Your Amount" and "Talk to Us First" options
     */
    public function processSponsorPayment(Request $request)
    {
        try {
            Log::info('===== Sponsor Payment Processing Started =====');
            Log::info('Request data', $request->all());

            $defaultLang = getDefaultLanguage(1);

            // Determine if this is "Talk to Us First" or payment option
            $talkToUsFirst = $request->input('talk_to_us_first', false);

            // Check if user is already logged in
            $loggedInCustomer = \Illuminate\Support\Facades\Auth::guard('customers')->user();

            // Check if this email already exists in the system
            $existingCustomer = Customer::where('email', $request->email)->first();

            // Dynamic validation rules based on option selected
            $rules = [
                'company_name' => 'required|string|max:255',
                'contact_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'contact_number' => 'required|string|max:50',
                'url' => 'nullable|url',  // Use Laravel's built-in URL validation after normalization
                'beneficiary_ids' => 'nullable|array',
                'beneficiary_ids.*' => 'exists:coffee_wall_beneficiaries,id',
            ];

            // Password only required for NEW users (not logged in AND email doesn't exist)
            if (!$loggedInCustomer && !$existingCustomer) {
                $rules['password'] = 'required|string|min:8|confirmed';
            }

            // If "Enter Your Amount" option is selected
            if (!$talkToUsFirst) {
                $rules = array_merge($rules, [
                    'sponsorship_amount' => 'required|numeric|min:1',
                    'frequency' => 'required|in:one_time,monthly,quarterly,annually',
                    'beneficiary_ids' => 'required|array|min:1',
                    'beneficiary_ids.*' => 'exists:coffee_wall_beneficiaries,id',
                    'payment_method' => 'required|in:stripe,paypal',
                    'summary' => 'required|string',
                    'detail_description' => 'required|string',
                    'logo' => 'required|string',  // Profile Image - REQUIRED
                    'featured_image' => 'required|string',  // Featured Image - REQUIRED
                    // Stripe specific (same as coffee wall)
                    'payment_method_id' => 'required_if:payment_method,stripe|string',
                    'cardholder_name' => 'required_if:payment_method,stripe',
                ]);
            } else {
                // If "Talk to Us First" option - all fields optional except basic contact
                $rules = array_merge($rules, [
                    'summary' => 'nullable|string',
                    'detail_description' => 'nullable|string',
                    'logo' => 'nullable|string',
                    'featured_image' => 'nullable|string',
                    'preferred_call_time' => 'required|string',
                    'preferred_call_date' => 'nullable|date|after:today',
                    'talk_to_us_name' => 'required|string',
                    'talk_to_us_phone' => 'required|string',
                    'message' => 'nullable|string',
                ]);
            }

            // Normalize URL - add https:// if no protocol is present and handle www variations
            $url = trim($request->url ?? '');

            if (!empty($url)) {
                // Add protocol if missing
                if (!preg_match('/^https?:\/\//i', $url)) {
                    $url = 'https://' . $url;
                }

                // Parse the URL to normalize it
                $parsedUrl = parse_url($url);

                if ($parsedUrl && isset($parsedUrl['host'])) {
                    // Normalize the host by removing or standardizing 'www'
                    $host = strtolower($parsedUrl['host']);

                    // Remove 'www.' prefix for consistency (you can also choose to always add it instead)
                    $host = preg_replace('/^www\./i', '', $host);

                    // Rebuild the normalized URL
                    $normalizedUrl = ($parsedUrl['scheme'] ?? 'https') . '://' . $host;

                    if (isset($parsedUrl['port'])) {
                        $normalizedUrl .= ':' . $parsedUrl['port'];
                    }
                    if (isset($parsedUrl['path'])) {
                        $normalizedUrl .= $parsedUrl['path'];
                    }
                    if (isset($parsedUrl['query'])) {
                        $normalizedUrl .= '?' . $parsedUrl['query'];
                    }
                    if (isset($parsedUrl['fragment'])) {
                        $normalizedUrl .= '#' . $parsedUrl['fragment'];
                    }

                    $request->merge(['url' => $normalizedUrl]);
                } else {
                    // Invalid URL format
                    $request->merge(['url' => $url]);
                }
            } else {
                // If URL is empty/whitespace, set to null for nullable validation
                $request->merge(['url' => null]);
            }

            // Custom validation messages
            $messages = [
                'url.url' => 'Please enter a valid website URL (e.g., www.example.com or https://example.com)',
                'sponsorship_amount.required' => 'Please select a sponsorship amount',
                'sponsorship_amount.numeric' => 'Sponsorship amount must be a number',
                'sponsorship_amount.min' => 'Sponsorship amount must be at least $1',
                'beneficiary_ids.required' => 'Please select at least one beneficiary',
                'beneficiary_ids.array' => 'Invalid beneficiary selection',
                'payment_method.required' => 'Please select a payment method',
                'logo.required' => 'Profile Image is required',
                'featured_image.required' => 'Featured Image is required',
                'cardholder_name.required_if' => 'Cardholder name is required for card payments',
                'payment_method_id.required_if' => 'Please enter your card details',
            ];

            $validated = $request->validate($rules, $messages);

            Log::info('Validation passed');

            $beneficiaryIds = collect($request->input('beneficiary_ids', []))
                ->map(fn($id) => (int) $id)
                ->filter(fn($id) => $id > 0)
                ->unique()
                ->values();

            $allBeneficiaryId = CoffeeWallBeneficiary::query()
                ->whereRaw('LOWER(name) = ?', ['all'])
                ->value('id');

            if ($allBeneficiaryId) {
                if ($beneficiaryIds->contains((int) $allBeneficiaryId) && $beneficiaryIds->count() > 1) {
                    $beneficiaryIds = $beneficiaryIds->reject(fn($id) => $id === (int) $allBeneficiaryId)->values();
                }

                if ($beneficiaryIds->isEmpty()) {
                    $beneficiaryIds = collect([(int) $allBeneficiaryId]);
                }
            }

            if (!$talkToUsFirst && $beneficiaryIds->isEmpty()) {
                return $this->errorResponse('Please select at least one beneficiary.');
            }

            $primaryBeneficiaryId = $beneficiaryIds->first();

            // Handle file uploads
            $logoMediaId = null;
            $featuredMediaId = null;

            // Check if GD library is available before processing images
            if (!extension_loaded('gd')) {
                Log::error('GD Library is not enabled. Cannot process images.');
                return $this->errorResponse('Image processing is currently unavailable. Please contact support. (Error: GD Library not enabled)');
            }

            if ($request->logo && !is_array($request->logo)) {
                $media = json_decode($request->logo, true);
                try {
                    $files = $this->moveFile($media, 'media/sponsors', 'sponsor');
                    $logoMediaId = (!empty($files) && is_array($files) && isset($files[0])) ? $files[0]->id : null;
                } catch (\Exception $e) {
                    Log::error('Error processing logo image', ['error' => $e->getMessage()]);
                    return $this->errorResponse('Error uploading Profile Image. Please try again or contact support.');
                }
            }

            if ($request->featured_image && !is_array($request->featured_image)) {
                $media = json_decode($request->featured_image, true);
                try {
                    $files = $this->moveFile($media, 'media/sponsors', 'sponsor');
                    $featuredMediaId = (!empty($files) && is_array($files) && isset($files[0])) ? $files[0]->id : null;
                } catch (\Exception $e) {
                    Log::error('Error processing featured image', ['error' => $e->getMessage()]);
                    return $this->errorResponse('Error uploading Featured Image. Please try again or contact support.');
                }
            }

            // Generate unique slug
            $slug = $this->generateUniqueSlug($request->company_name);

            // Create or find customer account
            $customer = null;
            $sendWelcomeEmail = false;
            $isNewCustomer = false;

            if (!$talkToUsFirst) {
                // Use logged-in customer or check by email
                if ($loggedInCustomer) {
                    // User is already logged in - use their account for additional sponsorship
                    $customer = $loggedInCustomer;
                    Log::info('Logged-in customer creating additional sponsorship', ['customer_id' => $customer->id]);
                } else {
                    // Not logged in - check if email exists
                    $customer = Customer::where('email', $request->email)->first();

                    if (!$customer) {
                        // Create new customer account for first-time sponsors
                        try {
                            Log::info('Creating new customer account', ['email' => $request->email]);
                            $customer = Customer::create([
                                'name' => $request->contact_name,
                                'email' => $request->email,
                                'business_name' => $request->company_name,
                                'is_active' => 1,
                                'password' => Hash::make($request->password),
                                'type' => 'sponsor',
                                'verify_customer_email' => 1,
                                'is_package_amount_paid' => 1,
                            ]);
                            $sendWelcomeEmail = true;
                            $isNewCustomer = true;
                            Log::info('New sponsor customer created', ['customer_id' => $customer->id]);
                        } catch (\Exception $e) {
                            Log::error('Failed to create customer account', [
                                'error' => $e->getMessage(),
                                'email' => $request->email,
                                'trace' => $e->getTraceAsString()
                            ]);
                            throw new \Exception('Failed to create customer account: ' . $e->getMessage());
                        }
                    } else {
                        // Email exists - allow sponsor to use it without logging in
                        // Just associate the sponsorship with the existing customer
                        Log::info('Using existing customer email for new sponsorship', ['customer_id' => $customer->id]);
                        $isNewCustomer = false;
                        // Do NOT send welcome email since customer already exists
                        $sendWelcomeEmail = false;
                    }
                }
            }

            // Process payment for "Enter Your Amount" option
            $transactionId = null;
            $stripePaymentIntentId = null;
            $stripeSubscriptionId = null;
            $paypalSubscriptionId = null;
            $paymentStatus = $talkToUsFirst ? 'not_required' : 'pending';
            $sponsorshipType = $talkToUsFirst ? 'talk_to_us' : 'paid';
            $status = $talkToUsFirst ? 'pending' : 'pending'; // Will be changed to active after payment
            $isVisible = false; // Will be set to true after payment

            if (!$talkToUsFirst && $request->payment_method === 'stripe' && $request->sponsorship_amount > 0) {
                Log::info('Processing Stripe payment', ['frequency' => $request->frequency]);

                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                try {
                    // Create Stripe Customer
                    $stripeCustomer = \Stripe\Customer::create([
                        'name' => $request->cardholder_name ?? $request->contact_name,
                        'email' => $request->email,
                    ]);

                    $stripe_customer_id = $stripeCustomer->id;

                    Log::info('Stripe customer created', ['customer_id' => $stripe_customer_id]);

                    // Attach the payment method to customer
                    $paymentMethod = \Stripe\PaymentMethod::retrieve($request->payment_method_id);
                    $paymentMethod->attach(['customer' => $stripe_customer_id]);

                    // Set the payment method as default for the customer
                    \Stripe\Customer::update($stripe_customer_id, [
                        'invoice_settings' => [
                            'default_payment_method' => $request->payment_method_id
                        ]
                    ]);

                    $frequency = $request->frequency ?? 'one_time';

                    // Handle one-time payment
                    if ($frequency === 'one_time') {
                        // Create payment intent for one-time payment
                        $paymentIntent = \Stripe\PaymentIntent::create([
                            'amount' => intval($request->sponsorship_amount * 100), // Convert to cents
                            'currency' => 'usd',
                            'customer' => $stripe_customer_id,
                            'payment_method' => $request->payment_method_id,
                            'confirm' => true,
                            'automatic_payment_methods' => [
                                'enabled' => true,
                                'allow_redirects' => 'never'
                            ],
                            'description' => 'Sponsorship - ' . $request->company_name,
                            'metadata' => [
                                'company_name' => $request->company_name,
                                'contact_name' => $request->contact_name,
                                'email' => $request->email,
                                'beneficiary_ids' => $beneficiaryIds->implode(','),
                                'frequency' => $frequency,
                            ],
                        ]);

                        Log::info('Payment Intent created', [
                            'payment_intent_id' => $paymentIntent->id,
                            'status' => $paymentIntent->status
                        ]);

                        if ($paymentIntent->status === 'succeeded') {
                            $transactionId = $paymentIntent->id;
                            $stripePaymentIntentId = $paymentIntent->id;
                            $paymentStatus = 'paid';
                            $status = 'active'; // Auto-approve
                            $isVisible = true; // Make visible immediately

                            Log::info('Stripe one-time payment succeeded', ['payment_intent_id' => $transactionId]);
                        } elseif ($paymentIntent->status === 'requires_action' || $paymentIntent->status === 'requires_payment_method') {
                            Log::error('Stripe payment requires action', [
                                'status' => $paymentIntent->status,
                                'payment_intent_id' => $paymentIntent->id
                            ]);
                            return $this->errorResponse('Your card requires additional authentication. Please try again or use a different payment method.');
                        } elseif ($paymentIntent->status === 'processing') {
                            Log::info('Stripe payment is processing', ['payment_intent_id' => $paymentIntent->id]);
                            // Payment is still processing - we'll mark it as pending
                            $transactionId = $paymentIntent->id;
                            $stripePaymentIntentId = $paymentIntent->id;
                            $paymentStatus = 'pending';
                            $status = 'pending';
                        } else {
                            Log::error('Stripe payment failed', [
                                'status' => $paymentIntent->status,
                                'payment_intent_id' => $paymentIntent->id,
                                'last_payment_error' => $paymentIntent->last_payment_error ?? null
                            ]);
                            $errorMessage = 'Payment processing failed';
                            if (isset($paymentIntent->last_payment_error)) {
                                $errorMessage = $paymentIntent->last_payment_error->message ?? $errorMessage;
                            }
                            return $this->errorResponse($errorMessage);
                        }
                    } else {
                        // Handle recurring subscription
                        // Map frequency to Stripe interval
                        $intervalMap = [
                            'monthly' => ['interval' => 'month', 'interval_count' => 1],
                            'quarterly' => ['interval' => 'month', 'interval_count' => 3],
                            'annually' => ['interval' => 'year', 'interval_count' => 1],
                        ];

                        if (!isset($intervalMap[$frequency])) {
                            Log::error('Invalid frequency', ['frequency' => $frequency]);
                            return $this->errorResponse('Invalid payment frequency selected.');
                        }

                        $interval = $intervalMap[$frequency];

                        // Create a product for this sponsorship
                        $product = \Stripe\Product::create([
                            'name' => 'Sponsorship - ' . $request->company_name,
                            'description' => 'Sponsorship payment',
                        ]);

                        // Create a price for this subscription
                        $price = \Stripe\Price::create([
                            'product' => $product->id,
                            'unit_amount' => intval($request->sponsorship_amount * 100), // Convert to cents
                            'currency' => 'usd',
                            'recurring' => $interval,
                        ]);

                        Log::info('Created Stripe price for subscription', ['price_id' => $price->id, 'frequency' => $frequency]);

                        // Create subscription with immediate payment
                        $subscription = \Stripe\Subscription::create([
                            'customer' => $stripe_customer_id,
                            'items' => [
                                ['price' => $price->id],
                            ],
                            'expand' => ['latest_invoice.payment_intent'],
                            'metadata' => [
                                'company_name' => $request->company_name,
                                'contact_name' => $request->contact_name,
                                'email' => $request->email,
                                'beneficiary_ids' => $beneficiaryIds->implode(','),
                                'frequency' => $frequency,
                            ],
                        ]);

                        Log::info('Stripe subscription created', ['subscription_id' => $subscription->id]);

                        // Check the payment intent from the invoice
                        $invoice = $subscription->latest_invoice;
                        $paymentIntent = is_string($invoice->payment_intent)
                            ? \Stripe\PaymentIntent::retrieve($invoice->payment_intent, ['expand' => ['payment_method']])
                            : $invoice->payment_intent;

                        if ($paymentIntent && $paymentIntent->status === 'succeeded') {
                            $transactionId = $paymentIntent->id;
                            $stripePaymentIntentId = $paymentIntent->id;
                            $stripeSubscriptionId = $subscription->id;
                            $paymentStatus = 'paid';
                            $status = 'active'; // Auto-approve
                            $isVisible = true; // Make visible immediately

                            Log::info('Stripe subscription payment succeeded', [
                                'subscription_id' => $subscription->id,
                                'payment_intent_id' => $transactionId
                            ]);
                        } else if ($paymentIntent && $paymentIntent->status === 'requires_payment_method') {
                            Log::error('Stripe subscription payment requires payment method', [
                                'subscription_id' => $subscription->id,
                                'payment_intent_id' => $paymentIntent->id
                            ]);
                            return $this->errorResponse('Payment method was declined. Please try a different card.');
                        } else {
                            // Payment requires action (3D Secure, etc.) or other status
                            $transactionId = $paymentIntent->id ?? null;
                            $stripePaymentIntentId = $paymentIntent->id ?? null;
                            $stripeSubscriptionId = $subscription->id;
                            $paymentStatus = 'pending';
                            $status = 'pending';

                            Log::info('Stripe subscription requires action', [
                                'subscription_id' => $subscription->id,
                                'payment_intent_status' => $paymentIntent->status ?? 'unknown',
                                'payment_intent_id' => $paymentIntent->id ?? null
                            ]);

                            return $this->errorResponse('Payment requires additional authentication. Please try again or use a different payment method.');
                        }
                    }
                } catch (\Stripe\Exception\CardException $e) {
                    Log::error('Stripe card error', [
                        'error' => $e->getMessage(),
                        'decline_code' => $e->getDeclineCode(),
                        'code' => $e->getCode(),
                    ]);
                    return $this->errorResponse($e->getMessage());
                } catch (\Stripe\Exception\RateLimitException $e) {
                    Log::error('Stripe rate limit error', ['error' => $e->getMessage()]);
                    return $this->errorResponse('Too many requests. Please try again later.');
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    Log::error('Stripe invalid request error', [
                        'error' => $e->getMessage(),
                        'param' => $e->getStripeParam(),
                    ]);
                    return $this->errorResponse('Invalid payment request: ' . $e->getMessage());
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    Log::error('Stripe authentication error', ['error' => $e->getMessage()]);
                    return $this->errorResponse('Payment authentication failed. Please contact support.');
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    Log::error('Stripe API connection error', ['error' => $e->getMessage()]);
                    return $this->errorResponse('Payment service connection error. Please try again.');
                } catch (\Exception $e) {
                    Log::error('Stripe payment error', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return $this->errorResponse('Payment error: ' . $e->getMessage());
                }
            } elseif (!$talkToUsFirst && $request->payment_method === 'paypal' && $request->sponsorship_amount > 0) {
                Log::info('Processing PayPal payment - redirecting to PayPal');

                // For PayPal, we need to create the sponsor first, then redirect
                // We'll handle the actual payment completion in the success callback
                $paymentStatus = 'pending';
                $status = 'pending';
            }

            // Create sponsor record
            try {
                Log::info('Creating sponsor record', [
                    'company_name' => $request->company_name,
                    'email' => $request->email,
                    'payment_status' => $paymentStatus,
                    'customer_id' => $customer->id ?? null
                ]);

                $sponsor = Sponsor::create([
                    'business_name' => $request->company_name,
                    'slug' => $slug,
                    'contact_name' => $request->contact_name,
                    'email' => $request->email,
                    'contact_number' => $request->contact_number,
                    'url' => $request->url,
                    'logo_media_id' => $logoMediaId,
                    'featured_media_id' => $featuredMediaId,
                    'summary' => $request->summary,
                    'detail_description' => $request->detail_description,
                    'message' => $request->message,
                    'sponsorship_type' => $sponsorshipType,
                    'sponsorship_amount' => $request->sponsorship_amount ?? null,
                    'frequency' => $request->frequency ?? 'one_time',
                    'talk_to_us_first' => $talkToUsFirst,
                    'preferred_call_time' => $request->preferred_call_time ?? null,
                    'preferred_call_date' => $request->preferred_call_date ?? null,
                    'talk_to_us_name' => $request->talk_to_us_name ?? null,
                    'talk_to_us_phone' => $request->talk_to_us_phone ?? null,
                    'beneficiary_id' => $primaryBeneficiaryId,
                    'payment_status' => $paymentStatus,
                    'payment_method' => $request->payment_method ?? null,
                    'transaction_id' => $transactionId,
                    'stripe_payment_intent_id' => $stripePaymentIntentId,
                    'stripe_subscription_id' => $stripeSubscriptionId,
                    'paypal_subscription_id' => $paypalSubscriptionId,
                    'paid_at' => $paymentStatus === 'paid' ? now() : null,
                    'status' => $status,
                    'is_visible' => $isVisible,
                    'customer_id' => $customer->id ?? null,
                ]);

                Log::info('Sponsor created successfully', ['sponsor_id' => $sponsor->id]);
            } catch (\Exception $e) {
                Log::error('Failed to create sponsor record', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

            // Sync beneficiaries
            try {
                if ($beneficiaryIds->isNotEmpty()) {
                    Log::info('Syncing beneficiaries', ['beneficiary_ids' => $beneficiaryIds->toArray()]);
                    $sponsor->beneficiaries()->sync($beneficiaryIds->all());
                    Log::info('Beneficiaries synced successfully');
                }
            } catch (\Exception $e) {
                Log::error('Failed to sync beneficiaries', [
                    'error' => $e->getMessage(),
                    'sponsor_id' => $sponsor->id,
                    'beneficiary_ids' => $beneficiaryIds->toArray()
                ]);
                // Don't throw - continue even if beneficiary sync fails
            }

            try {
                $sponsor->load(['beneficiaries', 'beneficiary']);
            } catch (\Exception $e) {
                Log::error('Failed to load sponsor relationships', [
                    'error' => $e->getMessage(),
                    'sponsor_id' => $sponsor->id
                ]);
                // Don't throw - continue even if loading fails
            }

            // Send admin notifications (wrap in try-catch to prevent email failures from breaking the flow)
            try {
                $general_setting = getGeneralSettingByKey();
                if (isset($general_setting['admin_email'])) {
                    $adminEmailsArr = explode(',', $general_setting['admin_email']);

                    if ($talkToUsFirst) {
                        // Send "Talk to Us" notification
                        Mail::to($adminEmailsArr)->send(new SponsorContactRequestNotification($sponsor));
                        Log::info('Admin notification sent (Talk to Us)');
                    } elseif ($paymentStatus === 'paid') {
                        // Send payment success notification
                        Mail::to($adminEmailsArr)->send(new NewSponsorPaymentNotification($sponsor));
                        Log::info('Admin notification sent (Payment success)');
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to send admin notification', [
                    'error' => $e->getMessage(),
                    'sponsor_id' => $sponsor->id
                ]);
                // Don't throw - continue even if email fails
            }

            // Send welcome email to sponsor if new account (no password needed - they set it themselves)
            if ($sendWelcomeEmail && $customer) {
                // You can send a welcome email here if needed
                // Mail::to($request->email)->send(new SponsorWelcomeMail([
                //     'name' => $request->contact_name
                // ]));
            }

            // Send auto-response to customer (wrap in try-catch to prevent email failures from breaking the flow)
            try {
                Mail::to($request->email)->send(new BecomeSponsorResponseMail([
                    'name' => $request->contact_name
                ]));
                Log::info('Auto-response email sent to customer');
            } catch (\Exception $e) {
                Log::error('Failed to send auto-response email', [
                    'error' => $e->getMessage(),
                    'email' => $request->email
                ]);
                // Don't throw - continue even if email fails
            }

            // Auto-login the customer after successful payment (only for new customers)
            if (!$talkToUsFirst && $customer && $paymentStatus === 'paid' && $isNewCustomer && !$loggedInCustomer) {
                \Illuminate\Support\Facades\Auth::guard('customers')->loginUsingId($customer->id);
                Log::info('Customer auto-logged in after payment', ['customer_id' => $customer->id]);
            }

            // Handle PayPal redirect
            if (!$talkToUsFirst && $request->payment_method === 'paypal') {
                $paypal = new PaypalService();

                // Create PayPal order for one-time payment
                try {
                    $data = [
                        'intent' => 'CAPTURE',
                        'purchase_units' => [[
                            'amount' => [
                                'currency_code' => 'USD',
                                'value' => number_format($request->sponsorship_amount, 2, '.', '')
                            ],
                            'description' => 'Sponsorship - ' . $request->company_name
                        ]],
                        'application_context' => [
                            'return_url' => route('paypal.subscription.success.sponsor', [
                                'sponsor_id' => $sponsor->id
                            ]),
                            'cancel_url' => route('paypal.cancel.sponsor', [
                                'sponsor_id' => $sponsor->id
                            ])
                        ]
                    ];

                    $order = $paypal->createOrder($data);

                    if (isset($order['status']) && $order['status'] === 'CREATED') {
                        $approvalUrl = collect($order['links'])->firstWhere('rel', 'approve')['href'] ?? null;

                        if ($approvalUrl) {
                            return $this->successResponse([
                                'type' => 'paypal',
                                'redirect_url' => $approvalUrl,
                                'sponsor_id' => $sponsor->id
                            ], 'Redirecting to PayPal...');
                        }
                    }

                    Log::error('PayPal order creation failed', ['response' => $order]);
                    return $this->errorResponse('PayPal payment initialization failed.');
                } catch (\Exception $e) {
                    Log::error('PayPal error', ['error' => $e->getMessage()]);
                    return $this->errorResponse('PayPal error: ' . $e->getMessage());
                }
            }

            Log::info('===== Sponsor Payment Processing Completed Successfully =====');

            $message = $talkToUsFirst
                ? 'Thank you! We will contact you shortly to discuss sponsorship opportunities.'
                : 'Thank you for your sponsorship! Your profile is now live.';

            return $this->successResponse([
                'sponsor' => $sponsor,
                'customer' => $customer
            ], $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('===== Sponsor Payment Processing Failed =====');
            Log::error('Exception occurred', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'password_confirmation', 'logo', 'featured_image'])
            ]);

            // Return more specific error message if possible
            $errorMessage = 'An error occurred while processing your request. Please try again.';
            if (strpos($e->getMessage(), 'SQLSTATE') !== false) {
                $errorMessage = 'Database error occurred. Please contact support.';
            } elseif (strpos($e->getMessage(), 'Mail') !== false || strpos($e->getMessage(), 'email') !== false) {
                $errorMessage = 'Payment processed successfully, but there was an issue sending confirmation email. Please contact support.';
            }

            return $this->errorResponse($errorMessage);
        }
    }

    /**
     * Generate unique slug for sponsor
     */
    protected function generateUniqueSlug($businessName): string
    {
        $slug = Str::slug($businessName);
        $count = 1;

        while (Sponsor::where('slug', $slug)->exists()) {
            $slug = Str::slug($businessName . '-' . $count);
            $count++;
        }

        return $slug;
    }

    /**
     * Get all sponsorships for logged-in customer
     */
    public function getSponsorProfile(Request $request)
    {
        try {
            $customer = \Illuminate\Support\Facades\Auth::guard('customers')->user();

            if (!$customer) {
                Log::warning('getSponsorProfile: No authenticated customer');
                return $this->errorResponse('Unauthorized', 401);
            }

            Log::info('Fetching sponsor profiles', ['customer_id' => $customer->id]);

            // Get all sponsorships for this customer
            $sponsors = Sponsor::where('customer_id', $customer->id)
                ->with(['logoMedia', 'featuredMedia', 'beneficiaries', 'beneficiary'])
                ->orderBy('created_at', 'desc')
                ->get();

            if ($sponsors->isEmpty()) {
                Log::warning('No sponsor profiles found for customer', ['customer_id' => $customer->id]);
                return $this->errorResponse('No sponsor profiles found', 404);
            }

            Log::info('Sponsor profiles found', ['customer_id' => $customer->id, 'count' => $sponsors->count()]);
            return $this->successResponse(\App\Http\Resources\Web\SponsorResource::collection($sponsors), 'Profiles loaded successfully');
        } catch (\Exception $e) {
            Log::error('Error fetching sponsor profiles', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse('Error loading profiles');
        }
    }

    /**
     * Get a specific sponsorship by ID for editing
     */
    public function getSponsorById(Request $request, $id)
    {
        try {
            $customer = \Illuminate\Support\Facades\Auth::guard('customers')->user();

            if (!$customer) {
                Log::warning('getSponsorById: No authenticated customer');
                return $this->errorResponse('Unauthorized', 401);
            }

            Log::info('Fetching specific sponsor profile', ['customer_id' => $customer->id, 'sponsor_id' => $id]);

            // Get specific sponsorship that belongs to this customer
            $sponsor = Sponsor::where('id', $id)
                ->where('customer_id', $customer->id)
                ->with(['logoMedia', 'featuredMedia', 'beneficiaries', 'beneficiary'])
                ->first();

            if (!$sponsor) {
                Log::warning('Sponsor profile not found or unauthorized', ['customer_id' => $customer->id, 'sponsor_id' => $id]);
                return $this->errorResponse('Sponsor profile not found', 404);
            }

            Log::info('Sponsor profile found', ['sponsor_id' => $sponsor->id]);
            return $this->successResponse(new \App\Http\Resources\Web\SponsorResource($sponsor), 'Profile loaded successfully');
        } catch (\Exception $e) {
            Log::error('Error fetching sponsor profile', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse('Error loading profile');
        }
    }

    /**
     * Update sponsor profile (for logged-in sponsors)
     */
    public function updateSponsorProfile(Request $request)
    {
        try {
            $customer = \Illuminate\Support\Facades\Auth::guard('customers')->user();

            if (!$customer) {
                Log::warning('updateSponsorProfile: No authenticated customer');
                return $this->errorResponse('Unauthorized', 401);
            }

            Log::info('Updating sponsor profile', ['customer_id' => $customer->id, 'data' => $request->except(['logo', 'featured_image'])]);

            // Normalize URL - add https:// if no protocol is present
            $url = trim($request->url ?? '');
            if (!empty($url)) {
                if (!preg_match('/^https?:\/\//i', $url)) {
                    $url = 'https://' . $url;
                }
                $request->merge(['url' => $url]);
            } else {
                $request->merge(['url' => null]);
            }

            $validated = $request->validate([
                'id' => 'required|exists:sponsors,id',
                'company_name' => 'required|string|max:255',
                'contact_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'contact_number' => 'required|string|max:50',
                'url' => 'nullable|url',  // Use Laravel's built-in URL validation
                'summary' => 'required|string',
                'detail_description' => 'required|string',
                'message' => 'nullable|string',
                'logo' => 'nullable|string',
                'featured_image' => 'nullable|string',
                'remove_logo' => 'nullable|boolean',
                'remove_featured_image' => 'nullable|boolean',
                'current_password' => 'nullable|string',
                'new_password' => 'nullable|string|min:8|confirmed',
            ]);

            // Fetch the specific sponsor by ID and verify it belongs to this customer
            $sponsor = Sponsor::where('id', $request->id)
                ->where('customer_id', $customer->id)
                ->firstOrFail();

            // Handle file uploads
            $logoMediaId = $sponsor->logo_media_id;
            $featuredMediaId = $sponsor->featured_media_id;

            if ($request->remove_logo) {
                $logoMediaId = null;
            } elseif ($request->logo && !is_array($request->logo)) {
                $media = json_decode($request->logo, true);
                $files = $this->moveFile($media, 'media/sponsors', 'sponsor');
                $logoMediaId = (!empty($files) && is_array($files) && isset($files[0])) ? $files[0]->id : $logoMediaId;
            }

            if ($request->remove_featured_image) {
                $featuredMediaId = null;
            } elseif ($request->featured_image && !is_array($request->featured_image)) {
                $media = json_decode($request->featured_image, true);
                $files = $this->moveFile($media, 'media/sponsors', 'sponsor');
                $featuredMediaId = (!empty($files) && is_array($files) && isset($files[0])) ? $files[0]->id : $featuredMediaId;
            }

            // Update sponsor profile
            $sponsor->update([
                'business_name' => $request->company_name,
                'slug' => $this->generateUniqueSlugForUpdate($request->company_name, $sponsor->id),
                'contact_name' => $request->contact_name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'url' => $request->url,
                'summary' => $request->summary,
                'detail_description' => $request->detail_description,
                'message' => $request->message,
                'logo_media_id' => $logoMediaId,
                'featured_media_id' => $featuredMediaId,
            ]);

            // Update customer email, name, and password if changed
            if ($customer) {
                $customerUpdates = [];
                if ($customer->email !== $request->email) {
                    $customerUpdates['email'] = $request->email;
                }
                if ($customer->name !== $request->contact_name) {
                    $customerUpdates['name'] = $request->contact_name;
                }

                // Handle password change
                if ($request->filled('current_password') && $request->filled('new_password')) {
                    // Verify current password
                    if (!Hash::check($request->current_password, $customer->password)) {
                        return $this->errorResponse('Current password is incorrect.', 422);
                    }

                    // Update password
                    $customerUpdates['password'] = Hash::make($request->new_password);
                    Log::info('Password updated for customer', ['customer_id' => $customer->id]);
                }

                if (!empty($customerUpdates)) {
                    Customer::where('id', $customer->id)->update($customerUpdates);
                    Log::info('Customer info updated', ['customer_id' => $customer->id, 'updates' => array_keys($customerUpdates)]);
                }
            }

            // Reload sponsor with relationships
            $sponsor = $sponsor->fresh(['logoMedia', 'featuredMedia', 'beneficiary']);

            Log::info('Sponsor profile updated successfully', ['sponsor_id' => $sponsor->id]);
            return $this->successResponse(new \App\Http\Resources\Web\SponsorResource($sponsor), 'Profile updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in sponsor profile update', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating sponsor profile', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse('Error updating profile. Please try again.');
        }
    }

    /**
     * Generate unique slug for sponsor update (excluding current sponsor)
     */
    protected function generateUniqueSlugForUpdate($businessName, $currentId): string
    {
        $slug = Str::slug($businessName);
        $count = 1;

        while (Sponsor::where('slug', $slug)->where('id', '!=', $currentId)->exists()) {
            $slug = Str::slug($businessName . '-' . $count);
            $count++;
        }

        return $slug;
    }
}
