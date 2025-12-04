<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\CustomerVerifyEmailMail;
use App\Mail\CustomerWelcomeMail;
use App\Mail\EventCreationInvoiceMail;
use App\Mail\RegistrationInvoiceToCustomerMail;
use App\Mail\WelcomeEventMail;
use App\Models\CoffeeWallet;
use App\Models\CoffeeWallPackage;
use App\Models\Customer;
use App\Models\CustomerInquiry;
use App\Models\CustomerMedia;
use App\Models\Event;
use App\Models\Order;
use App\Services\CustomerProfileService;
use App\Services\PaypalService;
use App\Services\PDFService;
use App\Services\StripeService;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use App\Traits\StatusResponser;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Stripe\Refund;
use Stripe\Stripe;

class PaymentController extends Controller
{
    use StatusResponser;

    public function index($abbreviation)
    {
        if (!Auth::guard('customers')->check()) {
            $general_setting = getGeneralSettingByKey();
            $url = url(langBasedURL(null, $general_setting['user_signin_page']));
            return Redirect::to($url);
        } else {
            // if already paid
            $user = Customer::whereId(auth()->guard('customers')->user()->id)->first();
            $paid = Customer::whereId($user->id)->where('is_package_amount_paid', 1)->first();
            if ($paid) {
                $general_setting = getGeneralSettingByKey();
                // Redirect to home page instead of payment page
                $defaultLang = getDefaultLanguage(1);
                $homeUrl = langBasedURL($defaultLang, route('front.index', $defaultLang->abbreviation));
                return Redirect::to($homeUrl);
            }
        }
        updateLangByAbber($abbreviation);
        return view('web.signup-payment.index');
    }

    public function processRegistrationPayment(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $customerProfileService = new CustomerProfileService();
        $response = $customerProfileService->updateCustomerProfileValidation($request, $defaultLang);

        $user = Customer::whereId(auth()->guard('customers')->user()->id)->first();
        if (!$user) {
            return $this->errorResponse('Customer not found');
        }

        $paid = Customer::whereId($user->id)->where('is_package_amount_paid', 1)->first();
        if ($paid) {
            return $this->errorResponse(['Package amount already paid.']);
        }

        $package = getRegistrationPackage($request->registration_package_id);
        if (!$package) {
            return $this->errorResponse('Package not found');
        }

        $response['rules'] = $customerProfileService->ValidationForPaymentFields($request, $package, $response['rules']);
        $payment_setting = getI2bModalSetting(null, ['payment_setting']);
        $response['niceNames'] = $customerProfileService->niceNamesForPaymentFields($response['niceNames'], $payment_setting);


        $this->validate(
            $request,
            $response['rules'],
            [],
            $response['niceNames']
        );

        $orderAmount = 0;
        $package_expiry_date = date('Y-m-d');
        $frequency = $request->payment_frequency;
        if ($frequency == 'monthly') {
            $price = $package->monthly_price;
            $package_price = $package->monthly_price;
            $package_expiry_date = date('Y-m-d', strtotime('+1 months'));
            $orderAmount = $package_price;
            $packageValidity = '1 month';
        } else if ($frequency == 'quarterly') {
            $price = $package->quarterly_price;
            $package_price = $package->quarterly_price * 3;
            $package_expiry_date = date('Y-m-d', strtotime('+3 months'));
            $orderAmount = $package_price;
            $packageValidity = '3 months';
        } else if ($frequency == 'semi_annually') {
            $price = $package->semi_annually_price;
            $package_price = $package->semi_annually_price * 6;
            $package_expiry_date = date('Y-m-d', strtotime('+6 months'));
            $orderAmount = $package_price;
            $packageValidity = '6 months';
        } else if ($frequency == 'annually') {
            $price = $package->annually_price;
            $package_price = $package->annually_price * 12;
            $package_expiry_date = date('Y-m-d', strtotime('+12 months'));
            $orderAmount = $package_price;
            $packageValidity = '12 months';
        }

        $isAutoRenew = $request->is_auto_renew == 'true' || $request->is_auto_renew == '1' ? 1 : 0;

        if ($request->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        }

        $subscription_id = null;
        $stripe_item_id = null;
        $subscription_status = null;

        try {
            if ($request->payment_method == 'paypal' && $package_price > 0) {
                Customer::whereId($user->id)->update([
                    'temp_registration_package_id' => $package->id,
                    'temp_payment_frequency' => $request->payment_frequency,
                    'temp_is_auto_renew' => $isAutoRenew,
                    'temp_type' => 'customer',
                ]);

                $customerProfileService->updateCustomer($request, null);
                $customerProfileService->updateCustomerProfile($request);
                $customerProfileService->updateBusinessCategories($request);

                $customerMedia = CustomerMedia::whereCustomerId(Auth::guard('customers')->user()->id)->with('customerGalleryImages.media')->first();

                $customerProfileService->updateCustomerMedia($request, $customerMedia);
                $customerProfileService->updateCustomerGalleryImage($request, $customerMedia);
                $customerProfileService->updateCustomerSocialMedia($request);

                $paypalService = new PaypalService();
                $paypalResponse = $paypalService->createSubscription($request, $user, $package);

                if (isset($paypalResponse['status']) && $paypalResponse['status'] === 'Error') {
                    return $this->errorResponse($paypalResponse['message'] ?? 'PayPal error');
                } elseif (isset($paypalResponse['status']) && $paypalResponse['status'] === 'Success') {
                    $general_messages = getStaticTranslationByKey($defaultLang ?? null, 'general_messages', ['message_19']);
                    $message_19 = $general_messages['message_19'] ?? '';
                    $username = $authCustomer->name ?? null;
                    $message_19 = str_replace(":name", $username, $message_19);

                    $data = ['name' => $username, 'email' => $user->email];
                    Mail::to($user->email)->send(new CustomerWelcomeMail($data));

                    return $this->successResponse(
                        ['type' => 'paypal', 'redirect_url' => $paypalResponse['redirect_url']],
                        $message_19
                    );
                } else {
                    return $this->errorResponse('Unexpected PayPal response.');
                }
            }

            // Stripe subscription creation (if Stripe chosen and price > 0)
            if ($request->payment_method === 'stripe' && $package_price > 0) {
                $stripeService = new StripeService();
                $stripeResponse = $stripeService->registrationPayment($package, $user, $request);

                // Expect stripeResponse to contain subscription_id and stripe_item_id
                $subscription_id = $stripeResponse['subscription_id'] ?? null;
                $stripe_item_id = $stripeResponse['stripe_item_id'] ?? null;

                if ($isAutoRenew === 1) {
                    $subscription_status = 'ok';
                }
            }

            // For non-paypal flows, update the customer profile once
            $customerProfileService->updateCustomer($request, null);
            $customerProfileService->updateCustomerProfile($request);
            $customerProfileService->updateBusinessCategories($request);
            $customerMedia = CustomerMedia::whereCustomerId($user->id)->with('customerGalleryImages.media')->first();
            $customerProfileService->updateCustomerMedia($request, $customerMedia);
            $customerProfileService->updateCustomerGalleryImage($request, $customerMedia);
            $customerProfileService->updateCustomerSocialMedia($request);


            Customer::whereId($user->id)->update([
                'registration_package_id' => $request->registration_package_id,
                'payment_frequency' => $request->payment_frequency,
                'package_price' => $price,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_expiry_date,
                'is_active' => 1,
                'is_auto_renew' => $isAutoRenew,
                'is_package_amount_paid' => 1,
                'subscription_status' => $subscription_status,
                'subscription_id' => ($request->payment_method === 'stripe' && $package_price > 0) ? $subscription_id : null,
                'payment_method' => $package_price > 0 ? $request->payment_method : null,
                'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
            ]);

            if ($package_price <= 0) {
                Log::info('Package price is 0');
                $customer = Customer::whereId($user->id)->first();
                $order = Order::create([
                    'registration_package_id' => $package->id,
                    'customer_id' => $customer->id,
                    'type' => 'profile',
                ]);
                $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
                $order->update([
                    'invoice_no' => $invoiceNo
                ]);

                $customer = $customer->loadMissing('customerProfile');

                $data = [
                    'package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '',
                    'package_price' => $package_price,
                    'payment_frequency' => $request->payment_frequency,
                    'package_validity' => $packageValidity,
                    'customer' => $customer,
                    'order' => $order,
                    'package_expiry_date' => $package_expiry_date
                ];

                $PDFService = new PDFService();
                $PDFService->createRegistrationInvoicePDF(null, $data);
                Mail::to($request->email)->send(new RegistrationInvoiceToCustomerMail($data));
            } else {
                $order = Order::create([
                    'registration_package_id' => $package->id,
                    'customer_id' => $user->id,
                    'type' => 'profile',
                    'payment_method' => $package_price > 0 ? $request->payment_method : null,
                    'transaction_id' => isset($subscription_id) ? $subscription_id : null,
                    'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                    'amount' => $orderAmount,
                ]);

                $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
                $order->update([
                    'invoice_no' => $invoiceNo
                ]);

                // **Mail Send Logic Added for Non-Zero Price**
                $data = [
                    'package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '',
                    'package_price' => $package_price,
                    'payment_frequency' => $request->payment_frequency,
                    'package_validity' => $packageValidity,
                    'customer' => $user,
                    'order' => $order,
                    'package_expiry_date' => $package_expiry_date
                ];

                $PDFService = new PDFService();
                $PDFService->createRegistrationInvoicePDF(null, $data);
                Mail::to($request->email)->send(new RegistrationInvoiceToCustomerMail($data));
            }

            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_19']);
            $message_19 = isset($general_messages['message_19']) ? $general_messages['message_19'] : '';

            $username = auth()->guard('customers')->user()->name ?? null;
            $message_19 = str_replace(":name", $username, $message_19);

            Session::flash('message', $message_19);
            Session::flash('type', 'pre_success');

            $data = [
                'name' => $username,
                'email' => $user->email
            ];
            Mail::to($user->email)->send(new CustomerWelcomeMail($data));
            return $this->successResponse([], $message_19);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function processUpgradeAccount(Request $request)
    {
        $errorMessages = [];
        $validationRule = [];
        $validationRule = array_merge($validationRule, ['payment_method' => ['required', 'in:stripe,paypal']]);
        $validationRule = array_merge($validationRule, ['paymentMethodId' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['paymentMethodId.required' => 'Pay via PayPal or Stripe.']);
        $errorMessages = array_merge($errorMessages, ['package_id.required' => 'Package is required.']);
        $errorMessages = array_merge($errorMessages, ['package_id.exists:registration_packages,id' => 'Package does not exist.']);
        $errorMessages = array_merge($errorMessages, ['price.required' => 'Price is required.']);
        $this->validate($request, $validationRule, $errorMessages);

        if ($request->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        }
        $paymentMethodId = $request->paymentMethodId;
        $user = auth()->guard('customers')->user();
        $package = getRegistrationPackage($request->package_id);
        try {
            if ($request->payment_method == 'paypal') {
                $paymentMethodId = $request->paymentMethodId;
            } else if ($request->payment_method == 'stripe') {
                $paymentIntent = PaymentIntent::create([
                    'amount' => $request->price,
                    'currency' => 'usd',
                    'payment_method' => $paymentMethodId,
                    'confirmation_method' => 'manual',
                ]);
                $paymentMethodId = $paymentIntent->id;
            }

            Customer::whereId($user->id)->update([
                'package_price' => $package->price,
                'registration_package_id' => $request->package_id,
                'free_subscription_days' => $package->free_subscription_days,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => date('Y-m-d', strtotime('+' . (isset($package) ? $package->package_validity_months : 0) . ' months')),
                'is_package_amount_paid' => 1,
            ]);

            Order::create([
                'registration_package_id' => $request->package_id,
                'customer_id' => $user->id,
                'type' => 'profile',
                'payment_method' => $request->payment_method,
                'transaction_id' => $paymentMethodId,
                'amount' => $package->price,
            ]);
            Session::put('inquiry_id', $request->package_id);
            return $this->successResponse([], 'Registration package has been updated successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paypalSuccessResponseCoffeeWall(Request $request)
    {
        $package = null;
        if (!isset($request->subscription_id)) {
            return false;
        }
        if (isset($_GET['package_id']) && $_GET['package_id'] != '') {
            $package = CoffeeWallPackage::whereId($_GET['package_id'])->first();
        }

        $name = isset($_GET['name']) ? $_GET['name'] : null;
        $email = isset($_GET['email']) ? $_GET['email'] : null;
        $phone = isset($_GET['phone']) ? $_GET['phone'] : null;
        $anonymous = isset($_GET['anonymous']) ? $_GET['anonymous'] : 0;
        $frequency = isset($_GET['frequency']) ? $_GET['frequency'] : null;
        $beneficiaryIds = collect(explode(',', $_GET['beneficiary_ids'] ?? ''))
            ->filter()
            ->map(function ($id) {
                return is_numeric($id) ? (int) $id : null;
            })
            ->filter()
            ->unique()
            ->values();

        $coffeeWallet = CoffeeWallet::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'anonymous' => $anonymous,
            'package_id' => $_GET['package_id'],
            'beneficiary_id' => $beneficiaryIds->first(),
            'frequency' => $frequency,
            'dr_amount' => $package->price,
            'paypal_id' => $request->subscription_id,
            'stripe_id' => null,
            'subscription_id' => null,
            'payment_method' => 'paypal',
            'status' => 'completed',
        ]);

        if ($beneficiaryIds->isNotEmpty()) {
            $coffeeWallet->beneficiaries()->sync($beneficiaryIds->all());
        }

        Session::flash('status', 'success');
        Session::flash('message', 'Payment successful');

        $defaultLang = getDefaultLanguage(1);
        $url = langBasedURL($defaultLang, route('front.index', $defaultLang->abbreviation));
        return Redirect::to($url);
    }

    public function paypalCancelResponseCoffeeWall(Request $request)
    {
        Session::flash('status', 'success');
        Session::flash('message', 'You have canceled the transaction');

        $defaultLang = getDefaultLanguage(1);
        $url = langBasedURL($defaultLang, route('front.index', $defaultLang->abbreviation));
        return Redirect::to($url);
    }

    public function paypalSuccessResponse(Request $request)
    {
        $user = null;
        $package = null;
        if (!isset($request->subscription_id)) {
            return false;
        }
        if (auth()->guard('customers')->check()) {
            $user = auth()->guard('customers')->user();
        }
        if (isset($_GET['package_id']) && $_GET['package_id'] != '') {
            $package = getRegistrationPackage($_GET['package_id']);
        }

        $defaultLang = getDefaultLanguage(1);

        // when new customer created and they make payment from paypal
        if (isset($_GET['type']) && $_GET['type'] == 'customer_signup') {
            $user = Customer::whereId($_GET['user_id'])->firstOrFail();
            $price = 0;
            $package_price = 0;
            $orderAmount = 0;
            $package_expiry_date = date('Y-m-d');
            if ($user->payment_frequency == 'monthly') {
                $price = $package->monthly_price;
                $package_price = $package->monthly_price;
                $orderAmount = $package->monthly_price;
                $packageValidity = '1 month';
                $package_expiry_date = date('Y-m-d', strtotime('+1 months'));
            } else if ($user->payment_frequency == 'quarterly') {
                $price = $package->quarterly_price;
                $package_price = $package->quarterly_price * 3;
                $orderAmount = $package->quarterly_price * 3;
                $packageValidity = '3 months';
                $package_expiry_date = date('Y-m-d', strtotime('+3 months'));
            } else if ($user->payment_frequency == 'semi_annually') {
                $price = $package->semi_annually_price;
                $package_price = $package->semi_annually_price * 6;
                $orderAmount = $package->semi_annually_price * 6;
                $packageValidity = '6 months';
                $package_expiry_date = date('Y-m-d', strtotime('+6 months'));
            } else if ($user->payment_frequency == 'annually') {
                $price = $package->annually_price;
                $package_price = $package->annually_price * 12;
                $orderAmount = $package->annually_price * 12;
                $packageValidity = '12 months';
                $package_expiry_date = date('Y-m-d', strtotime('+12 months'));
            }
            if ($package && $user) {
                Customer::whereId($user->id)->update([
                    'package_price' => $price,
                    'package_subscribed_date' => date('Y-m-d'),
                    'package_expiry_date' => $package_expiry_date,
                    'is_package_amount_paid' => 1,
                    'paypal_subscription_id' => $request->subscription_id,
                    'subscription_id' => null,
                    'registration_package_id' => $user->temp_registration_package_id,
                    'payment_frequency' => $user->temp_payment_frequency,
                    'is_auto_renew' => $user->temp_is_auto_renew,
                    'type' => $user->temp_type ?? $user->type,
                    'payment_method' => 'paypal',
                    'subscription_status' => 'ok'
                ]);

                $order = Order::create([
                    'registration_package_id' => $package->id,
                    'customer_id' => $user->id,
                    'type' => 'profile',
                    'payment_method' => 'paypal',
                    'transaction_id' => $request->subscription_id,
                    'stripe_item_id' => null,
                    'amount' => $orderAmount,
                ]);

                $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
                $order->update([
                    'invoice_no' => $invoiceNo
                ]);



                $customer = Customer::with(['registrationPackage.registrationPackageDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                }])->with('customerProfile')->where('id', $user->id)->first();


                $packageName = (isset($customer->registrationPackage->registrationPackageDetail[0]) ? $customer->registrationPackage->registrationPackageDetail[0]->name : '');

                $activeEmailUrl = Hash::make($request->email);
                Customer::whereId($customer->id)->update([
                    'active_email_url' => $activeEmailUrl,
                ]);
                $data = [
                    'user_id' => $activeEmailUrl,
                    'email' => $customer->email,
                ];

                Mail::to($customer->email)->send(new CustomerVerifyEmailMail($data));


                $data = ['package_name' => $packageName, 'package_price' => $package_price, 'package_validity' => $packageValidity, 'payment_frequency' => $user->payment_frequency, 'customer' => $customer, 'order' => $order, 'package_expiry_date' => $package_expiry_date];

                $PDFService = new PDFService();

                $PDFService->createRegistrationInvoicePDF(null, $data);

                Mail::to($customer->email)->send(new RegistrationInvoiceToCustomerMail($data));

                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_38']);
                $message_38 = isset($general_messages['message_38']) ? $general_messages['message_38'] : '';

                Session::flash('status', 'success');
                Session::flash('message', $message_38);
                $url = langBasedURL($defaultLang, route('front.index', $defaultLang->abbreviation));
                // Auth::guard('customers')->logout();
                return Redirect::to($url);
            } else {
                Session::flash('status', 'error');
                $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_1']);
                $message_1 = isset($general_messages['message_1']) ? $general_messages['message_1'] : '';
                Session::flash('message', $message_1);
                $url = route('user.payment.index', [$defaultLang->abbreviation]);
                return Redirect::to($url);
            }
        } else if (isset($_GET['type']) && $_GET['type'] == 'account_setting_upgrade') {
            $paypalService = new PaypalService;
            try {
                if ($user->payment_method == 'paypal' && $user->paypal_subscription_id) {
                    // $client = new Client();
                    // $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/cancel', [
                    //     'headers' => [
                    //         'Content-Type' => 'application/json',
                    //         'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                    //     ],
                    // ]);
                    $client = new Client();
                    $response = $client->get(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                        ],
                    ]);

                    $subscription = json_decode($response->getBody()->getContents(), true);
                    $status = $subscription['status'] ?? null;

                    if ($status === 'ACTIVE' || $status === 'SUSPENDED') {
                        $amount = 0;

                        // Get the previous package data
                        $prevPackagePrice = $user->package_price;
                        $prevPackageStartDate = new \DateTime($user->package_subscribed_date);
                        $prevPackageEndDate = new \DateTime($user->package_expiry_date);

                        // Calculate the per-day price of the previous package
                        $diffInTime = $prevPackageEndDate->getTimestamp() - $prevPackageStartDate->getTimestamp();
                        $totalDaysOfPrevPackage = $diffInTime / (60 * 60 * 24);
                        $prevPackagePerDayPrice = $prevPackagePrice / $totalDaysOfPrevPackage;

                        // Calculate the remaining days of the previous package
                        $today = new \DateTime();
                        $remainingDays = ($prevPackageEndDate->getTimestamp() - $today->getTimestamp()) / (60 * 60 * 24);

                        // Ensure remaining days are positive
                        if ($remainingDays > 0) {
                            // Calculate the price to be deducted based on remaining days
                            $amount = $prevPackagePerDayPrice * $remainingDays;
                        }

                        if ($amount > 0) {
                            Log::info('refund amount = ' . $amount);
                            // Get the sale ID for the subscription
                            $subscription = $client->get(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id, [
                                'headers' => [
                                    'Content-Type' => 'application/json',
                                    'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                                ],
                            ]);
                            $subscriptionBody = $subscription->getBody()->getContents();
                            $subscriptionData = json_decode($subscriptionBody, true);

                            $saleId = $subscriptionData['billing_info']['last_payment']['sale_id'] ?? null;
                            Log::info('Sale id = ' . $saleId);

                            if ($saleId) {
                                $paypalService = new PaypalService();
                                $refundPaypalResponse = $paypalService->refundPayPalSale($saleId, $amount);
                                Log::info('refund paypal response = ' . $refundPaypalResponse);
                            } else {
                                Log::info('No sale ID found for subscription');
                            }
                        }

                        // Proceed to cancel the subscription
                        $cancelResponse = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/cancel', [
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                            ],
                            'json' => [
                                'reason' => 'Customer requested cancellation.',
                            ],
                        ]);

                        if ($cancelResponse->getStatusCode() === 204) {
                            // Successfully canceled
                            Log::info('Subscription canceled successfully.');
                        } else {
                            Log::info('Failed to cancel subscription.');
                        }
                    } else {
                        Log::info('Subscription status is not valid for cancellation. Current status: ' . $status);
                    }
                } else if ($user->payment_method == 'stripe' && $user->subscription_id) {
                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

                    // Set your Stripe secret key
                    Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                    Log::info('Stripe API key set.');

                    // Get the user's subscription ID
                    $subscriptionId = $user->subscription_id;
                    Log::info('Subscription ID retrieved: ' . $subscriptionId);

                    $amount = 0;
                    $amountInCents = 0;

                    // Get the previous package data
                    $prevPackagePrice = $user->package_price;
                    $prevPackageStartDate = new \DateTime($user->package_subscribed_date);
                    $prevPackageEndDate = new \DateTime($user->package_expiry_date);

                    // Calculate the per-day price of the previous package
                    $diffInTime = $prevPackageEndDate->getTimestamp() - $prevPackageStartDate->getTimestamp();
                    $totalDaysOfPrevPackage = $diffInTime / (60 * 60 * 24);
                    $prevPackagePerDayPrice = $prevPackagePrice / $totalDaysOfPrevPackage;

                    // Calculate the remaining days of the previous package
                    $today = new \DateTime();
                    $remainingDays = ($prevPackageEndDate->getTimestamp() - $today->getTimestamp()) / (60 * 60 * 24);

                    // Ensure remaining days are positive
                    if ($remainingDays > 0) {
                        // Calculate the price to be deducted based on remaining days
                        $amount = $prevPackagePerDayPrice * $remainingDays;
                        // Convert the refund amount to cents and ensure it's an integer
                        $amountInCents = round($amount * 100);
                        Log::info('Refund amount: ' . $amountInCents);
                    }

                    if (str_starts_with($subscriptionId, 'sub_')) {
                        // Get the latest invoice for the subscription
                        $subscription = \Stripe\Subscription::retrieve($subscriptionId);
                        Log::info('Subscription retrieved: ' . json_encode($subscription));

                        // Get the latest charge from the latest invoice
                        $latestInvoice = \Stripe\Invoice::retrieve($subscription->latest_invoice);
                        Log::info('Latest invoice retrieved: ' . json_encode($latestInvoice));

                        $chargeId = $latestInvoice->charge;
                        Log::info('Charge ID: ' . $chargeId);

                        if ($amountInCents > 0) {
                            // Step 1: Create the refund for the charge
                            $refund = Refund::create([
                                'charge' => $chargeId,
                                'amount' => $amountInCents, // Refund amount in cents, leave it out for full refund
                                'reason' => 'requested_by_customer',
                            ]);
                            Log::info('Refund created: ' . json_encode($refund));
                        }

                        // Step 2: Cancel the subscription after refund
                        $stripe->subscriptions->cancel($user->subscription_id, []);
                        Log::info('Subscription canceled: ' . $subscriptionId);
                    } elseif (str_starts_with($subscriptionId, 'pi_')) {
                        $refund = Refund::create([
                            'payment_intent' => $subscriptionId,
                            'amount' => $amountInCents, // Refund amount in cents
                        ]);
                        Log::info('Refund created: ' . json_encode($refund));
                    }
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }


            $pkg = getRegistrationPackage($user->temp_registration_package_id);
            if ($pkg) {
                $package_price = 0;
                $orderAmount = 0;
                $package_expiry_date = date('Y-m-d');
                $eventsAllowed = 0;
                if ($user->payment_frequency == 'monthly') {
                    $price = $pkg->monthly_price;
                    $package_price = $pkg->monthly_price;
                    $orderAmount = $pkg->monthly_price;
                    $packageValidity = '1 months';
                    $package_expiry_date = date('Y-m-d', strtotime('+1 months'));
                    $eventsAllowed = $pkg->events_allowed;
                } else if ($user->payment_frequency == 'quarterly') {
                    $price = $pkg->quarterly_price;
                    $package_price = $pkg->quarterly_price * 3;
                    $orderAmount = $pkg->quarterly_price * 3;
                    $packageValidity = '3 months';
                    $package_expiry_date = date('Y-m-d', strtotime('+3 months'));
                    $eventsAllowed = $pkg->events_allowed * 3;
                } else if ($user->payment_frequency == 'semi_annually') {
                    $price = $pkg->semi_annually_price;
                    $package_price = $pkg->semi_annually_price * 6;
                    $orderAmount = $pkg->semi_annually_price * 6;
                    $packageValidity = '6 months';
                    $package_expiry_date = date('Y-m-d', strtotime('+6 months'));
                    $eventsAllowed = $pkg->events_allowed * 6;
                } else if ($user->payment_frequency == 'annually') {
                    $price = $pkg->annually_price;
                    $package_price = $pkg->annually_price * 12;
                    $orderAmount = $pkg->annually_price * 12;
                    $packageValidity = '12 months';
                    $package_expiry_date = date('Y-m-d', strtotime('+12 months'));
                    $eventsAllowed = $pkg->events_allowed * 12;
                }
                $events_created = Event::where('customer_id', $user->id)->count();
                $events_remaining = $eventsAllowed - $events_created < 0 ? 0 : $eventsAllowed - $events_created;
            }


            Customer::whereId($user->id)->update([
                'package_price' => $price,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_expiry_date,
                'is_package_amount_paid' => 1,
                'paypal_subscription_id' => $request->subscription_id,
                'subscription_id' => null,
                'registration_package_id' => $user->temp_registration_package_id,
                'payment_frequency' => $user->temp_payment_frequency,
                'is_auto_renew' => $user->temp_is_auto_renew,
                'type' => $user->temp_type ?? $user->type,
                'payment_method' => 'paypal',
                'subscription_status' => 'ok',
                'events_allowed' => isset($eventsAllowed) ? $eventsAllowed : $user->events_allowed,
                'events_remaining' => isset($events_remaining) ? $events_remaining : $user->events_remaining,
            ]);

            $order = Order::create([
                'registration_package_id' => $pkg->id,
                'customer_id' => $user->id,
                'type' => 'profile',
                'payment_method' => 'paypal',
                'transaction_id' => $request->subscription_id,
                'stripe_item_id' => null,
                'amount' => $orderAmount,
            ]);

            $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
            $order->update([
                'invoice_no' => $invoiceNo
            ]);

            $customer = Customer::with(['registrationPackage.registrationPackageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])->with('customerProfile')->where('id', $user->id)->first();


            $packageName = (isset($customer->registrationPackage->registrationPackageDetail[0]) ? $customer->registrationPackage->registrationPackageDetail[0]->name : '');

            $data = ['package_name' => $packageName, 'package_price' => $package_price, 'package_validity' => $packageValidity, 'payment_frequency' => $user->payment_frequency, 'customer' => $customer, 'order' => $order, 'package_expiry_date' => $package_expiry_date];

            $PDFService = new PDFService();

            $PDFService->createRegistrationInvoicePDF(null, $data);

            Mail::to($customer->email)->send(new RegistrationInvoiceToCustomerMail($data));

            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_15']);
            $message_15 = isset($general_messages['message_15']) ? $general_messages['message_15'] : '';

            Session::flash('status', 'success');
            Session::flash('message', $message_15);
            $url = langBasedURL($defaultLang, route('user.profile-settings.index'));
            return Redirect::to($url);
        } else if (isset($_GET['type']) && $_GET['type'] == 'customer_event_signup') {

            $price = 0;
            $totalAmount = 0;
            $eventsAllowed = 0;
            $price = $package->event_price ?? 0;
            $totalAmount = $package->event_price ?? 0;
            $package_expiry_date = date('Y-m-d', strtotime('+1 months'));
            $eventsAllowed = $package->events_allowed;

            Customer::where('email', $_GET['e'])->update([
                'name' => $_GET['n'] ?? '',
                'email' => $_GET['e'] ?? '',
                'business_name' => $_GET['bn'] ?? '',
                'registration_package_id' => $package->id ?? null,
                'package_price' => $price,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_expiry_date ?? date('Y-m-d'),
                'is_package_amount_paid' => 1,
                'events_allowed' => $eventsAllowed,
                'events_remaining' => $eventsAllowed,
                'images_allowed' => $package->images_allowed ?? 0,
                'subscription_id' => null,
                'payment_method' => 'paypal',
                'stripe_item_id' => null,
                'stripe_customer_id' => null,
                'paypal_subscription_id' => $request->subscription_id,
            ]);

            $customer = Customer::where('email', $_GET['e'])->first();
            $customer = $customer->loadMissing('customerProfile');

            $event = Event::where('customer_id', $customer->id)->with(['eventDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])->first();

            $data = ['customer' => $customer, 'event_name' => $event->eventDetail[0]->title, 'package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $price];
            if (isset($_GET['e'])) {
                Mail::to($_GET['e'])->send(new WelcomeEventMail($data));
            }

            $order = Order::create([
                'registration_package_id' => $package->id,
                'customer_id' => $customer->id,
                'type' => 'event',
                'payment_method' => 'paypal',
                'transaction_id' => $request->subscription_id,
                'stripe_item_id' => null,
                'amount' => $totalAmount,
            ]);

            $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
            $order->update([
                'invoice_no' => $invoiceNo
            ]);

            $data = ['package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $price, 'customer' => $customer, 'order' => $order, 'event_name' => $event->eventDetail[0]->title];

            $PDFService = new PDFService();

            $PDFService->createRegistrationInvoicePDF(null, $data);
            if (isset($_GET['e'])) {
                Mail::to($_GET['e'])->send(new RegistrationInvoiceToCustomerMail($data));
            }

            $general_setting = getSignleGeneralSettingByKey(['user_signin_page']);
            $url = isset($general_setting['user_signin_page']) ? url($general_setting['user_signin_page']) : '#';
            $url = langBasedURL($defaultLang, $url);
            return Redirect::to($url);
        } else if (isset($_GET['type']) && $_GET['type'] == 'customer_create_event') {
            $eventId = $user->temp_registration_package_id;
            Event::whereId($eventId)->whereCustomerId($user->id)->restore();
            $sql = Event::whereId($eventId)->whereCustomerId($user->id)->update([
                'payment_method_id' => $request->subscription_id,
            ]);

            if ($sql) {
                $event = Event::with('customer')->with(['eventDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                }])->whereId($eventId)->first();

                Order::create([
                    'registration_package_id' => $event->registration_package_id,
                    'customer_id' => $user->id,
                    'type' => 'event',
                    'payment_method' => 'paypal',
                    'transaction_id' => $request->subscription_id,
                    'stripe_item_id' => null,
                    'amount' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : $package->price,
                ]);

                Customer::whereId($user->id)->update([
                    'events_remaining' => $user->events_remaining - 1
                ]);

                Mail::to($user->email)->send(new EventCreationInvoiceMail($event, 'customer'));
                $general_setting = getGeneralSettingByKey();
                if (isset($general_setting['admin_email'])) {
                    $adminEmailsArr = explode(',', $general_setting['admin_email']);
                    $event->email_to = 'admin';
                }
                if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
                    $to_email = $adminEmailsArr[0];
                    unset($adminEmailsArr[0]);
                    Mail::to($to_email)->cc($adminEmailsArr)->send(new EventCreationInvoiceMail($event, 'admin'));
                } else {
                    $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
                    if ($to_email) {
                        Mail::to($to_email)->send(new EventCreationInvoiceMail($event, 'admin'));
                    }
                }

                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_39']);
                $message_39 = isset($general_messages['message_39']) ? $general_messages['message_39'] : '';

                Session::flash('status', 'success');
                Session::flash('message', $message_39);

                $general_setting = getSignleGeneralSettingByKey(['user_event_listing_page']);
                $url = isset($general_setting['user_event_listing_page']) ? url($general_setting['user_event_listing_page']) : '#';
                $url = langBasedURL($defaultLang, $url);
                return Redirect::to($url);
            }
        }
    }

    public function paypalCancelResponse(Request $request)
    {
        if (isset($_GET['type']) && $_GET['type'] == 'customer_signup') {
            $defaultLang = getDefaultLanguage(1);
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_40']);
            $message_40 = isset($general_messages['message_40']) ? $general_messages['message_40'] : '';

            Session::flash('status', 'error');
            Session::flash('message', $message_40);
            $url = route('user.payment.index', [$defaultLang->abbreviation]);
            return Redirect::to($url);
        } else if (isset($_GET['type']) && $_GET['type'] == 'account_setting_upgrade') {
            $defaultLang = getDefaultLanguage(1);
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_41']);
            $message_41 = isset($general_messages['message_41']) ? $general_messages['message_41'] : '';

            Session::flash('status', 'error');
            Session::flash('message', $message_41);
            $url = langBasedURL($defaultLang, route('user.profile-settings.index'));
            return Redirect::to($url);
        } else if (isset($_GET['type']) && $_GET['type'] == 'customer_event_signup') {
            $defaultLang = getDefaultLanguage(1);
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_42']);
            $message_42 = isset($general_messages['message_42']) ? $general_messages['message_42'] : '';

            Session::flash('status', 'error');
            Session::flash('message', $message_42);
            $general_setting = getSignleGeneralSettingByKey(['user_event_signup_page']);
            $url = isset($general_setting['user_event_signup_page']) ? url($general_setting['user_event_signup_page']) : '#';
            $url = langBasedURL($defaultLang, $url);
            return Redirect::to($url);
        } else if (isset($_GET['type']) && $_GET['type'] == 'customer_create_event') {
            if (auth()->guard('customers')->check()) {
                $user = auth()->guard('customers')->user();
                $eventId = $user->temp_registration_package_id;
                Event::whereId($eventId)->whereCustomerId($user->id)->forceDelete();
            }

            $defaultLang = getDefaultLanguage(1);
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_42']);
            $message_42 = isset($general_messages['message_42']) ? $general_messages['message_42'] : '';

            Session::flash('status', 'error');
            Session::flash('message', $message_42);
            $general_setting = getSignleGeneralSettingByKey(['user_event_create_page']);
            $url = isset($general_setting['user_event_create_page']) ? url($general_setting['user_event_create_page']) : '#';
            $url = langBasedURL($defaultLang, $url);
            return Redirect::to($url);
        } else if (isset($_GET['type']) && $_GET['type'] == 'customer_i2b_inquiry') {
            if (auth()->guard('customers')->check()) {
                $user = auth()->guard('customers')->user();
                $customerInquiryId = $user->temp_registration_package_id;
                CustomerInquiry::whereId($customerInquiryId)->whereCustomerId($user->id)->forceDelete();
            }

            $defaultLang = getDefaultLanguage(1);
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_42']);
            $message_42 = isset($general_messages['message_42']) ? $general_messages['message_42'] : '';

            Session::flash('status', 'error');
            Session::flash('message', $message_42);
            $url = route('front.index');
            $url = langBasedURL($defaultLang, $url);
            return Redirect::to($url);
        }
        return 'cancel';
    }

    /**
     * PayPal success callback for sponsor payment
     */
    public function paypalSuccessResponseSponsor(Request $request)
    {
        try {
            Log::info('===== PayPal Sponsor Payment Success Callback =====');
            Log::info('Request params', $request->all());

            $sponsorId = $request->query('sponsor_id');
            $token = $request->query('token'); // PayPal order token
            
            if (!$sponsorId || !$token) {
                Log::error('Missing sponsor_id or token in PayPal callback');
                Session::flash('status', 'error');
                Session::flash('message', 'Invalid payment callback parameters');
                return redirect()->route('front.index');
            }

            $sponsor = \App\Models\Sponsor::with('beneficiary')->findOrFail($sponsorId);
            
            // Capture the PayPal order
            $paypal = new \App\Services\PaypalService();
            $captureResult = $paypal->captureOrder($token);
            
            Log::info('PayPal capture result', ['result' => $captureResult]);
            
            if (isset($captureResult['status']) && $captureResult['status'] === 'COMPLETED') {
                // Payment successful - update sponsor
                $captureId = $captureResult['id'] ?? $token;
                $sponsor->update([
                    'payment_status' => 'paid',
                    'status' => 'active', // Auto-approve
                    'is_visible' => true,
                    'transaction_id' => $captureId,
                    'paypal_subscription_id' => $token,
                    'paid_at' => now(),
                ]);

                // Reload sponsor to get fresh data with relationships
                $sponsor->refresh();

                // Send admin notification
                $general_setting = getGeneralSettingByKey();
                if (isset($general_setting['admin_email'])) {
                    $adminEmailsArr = explode(',', $general_setting['admin_email']);
                    Mail::to($adminEmailsArr)->send(new \App\Mail\NewSponsorPaymentNotification($sponsor));
                }

                // Auto-login customer and send credentials if needed
                if ($sponsor->customer_id) {
                    $customer = $sponsor->customer;
                    
                    // Auto-login the customer
                    Auth::guard('customers')->loginUsingId($customer->id);
                    Log::info('Customer auto-logged in after PayPal payment', ['customer_id' => $customer->id]);
                }

                Log::info('Sponsor payment completed successfully', ['sponsor_id' => $sponsor->id]);

                Session::flash('status', 'success');
                Session::flash('message', 'Thank you for your sponsorship! Your profile is now live.');
            } else {
                Log::error('PayPal capture failed', ['result' => $captureResult]);
                $sponsor->update(['payment_status' => 'failed']);
                
                Session::flash('status', 'error');
                Session::flash('message', 'Payment capture failed. Please contact support.');
            }

        } catch (\Exception $e) {
            Log::error('PayPal sponsor payment callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            Session::flash('status', 'error');
            Session::flash('message', 'An error occurred processing your payment. Please contact support.');
        }

        $defaultLang = getDefaultLanguage(1);
        $url = langBasedURL($defaultLang, route('front.index', $defaultLang->abbreviation));
        return Redirect::to($url);
    }

    /**
     * PayPal cancel callback for sponsor payment
     */
    public function paypalCancelResponseSponsor(Request $request)
    {
        Log::info('===== PayPal Sponsor Payment Cancelled =====');
        Log::info('Request params', $request->all());

        $sponsorId = $request->query('sponsor_id');
        
        if ($sponsorId) {
            $sponsor = \App\Models\Sponsor::find($sponsorId);
            if ($sponsor) {
                // Mark as cancelled/failed
                $sponsor->update(['payment_status' => 'failed']);
            }
        }

        Session::flash('status', 'info');
        Session::flash('message', 'Payment cancelled. You can try again anytime.');

        $defaultLang = getDefaultLanguage(1);
        $url = langBasedURL($defaultLang, route('front.index', $defaultLang->abbreviation));
        return Redirect::to($url);
    }
}
