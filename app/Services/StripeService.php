<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerPaymentMethod;
use App\Models\GeneralSetting;
use App\Models\Event;
use App\Models\Order;
use App\Models\RegistrationPackage;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Refund;
use Stripe\Stripe;

class StripeService
{
    protected function getOrCreateProductId($packageType, $fallbackName = 'Registration Package')
    {
        $keyMap = [
            'free' => 'stripe_free_product',
            'featured' => 'stripe_featured_product',
            'premium' => 'stripe_premium_product',
            'pay_to_go' => 'stripe_pay_to_go_product',
            'event_featured' => 'stripe_featured_product',
            'event_premium' => 'stripe_premium_product',
        ];

        $key = $keyMap[$packageType] ?? null;
        if (!$key) {
            return null;
        }

        $setting = getSignleGeneralSettingByKey([$key]);
        $productId = $setting[$key] ?? null;

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        if ($productId) {
            try {
                $stripe->products->retrieve($productId, []);
                return $productId; // valid
            } catch (\Exception $e) {
                // fall through to create
            }
        }

        // Create a new product and persist
        $name = $fallbackName ?: ucfirst($packageType) . ' Package';
        $product = $stripe->products->create([
            'name' => $name,
        ]);

        GeneralSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $product->id, 'type' => 'package']
        );

        return $product->id;
    }

    public function createPrices($request, $packageName, $registrationPackage, $source = 'store')
    {
        if ($request->package_type == 'free') {
            $productId = $this->getOrCreateProductId('free', $packageName ?: 'Free Package');
        } else if ($request->package_type == 'featured') {
            $productId = $this->getOrCreateProductId('featured', $packageName ?: 'Featured Package');
        } else if ($request->package_type == 'premium') {
            $productId = $this->getOrCreateProductId('premium', $packageName ?: 'Premium Package');
        } else if ($request->package_type == 'pay_to_go') {
            $productId = $this->getOrCreateProductId('pay_to_go', $packageName ?: 'Pay To Go Package');
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $price = [];
        $price['nickname'] = $packageName . ' for monthly';
        $price['unit_amount'] = ($request->monthly_price) * 100;
        $price['currency'] = 'CAD';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 1];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_monthly_id' => $prices->id]);


        $price['nickname'] = $packageName . ' for quarterly';
        $price['unit_amount'] = ($request->quarterly_price * 3) * 100;
        $price['currency'] = 'CAD';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 3];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_quarterly_id' => $prices->id]);


        $price['nickname'] = $packageName . ' for semi annually';
        $price['unit_amount'] = ($request->semi_annually_price * 6) * 100;
        $price['currency'] = 'CAD';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 6];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_semi_annually_id' => $prices->id]);


        $price['nickname'] = $packageName . ' for annually';
        $price['unit_amount'] = ($request->annually_price * 12) * 100;
        $price['currency'] = 'CAD';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 12];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_annually_id' => $prices->id]);
    }

    public function createMonthlyStripePrices($request, $packageName, $registrationPackage)
    {
        if ($request->package_type == 'free') {
            $productId = $this->getOrCreateProductId('free', $packageName ?: 'Free Package');
        } else if ($request->package_type == 'featured') {
            $productId = $this->getOrCreateProductId('featured', $packageName ?: 'Featured Package');
        } else if ($request->package_type == 'premium') {
            $productId = $this->getOrCreateProductId('premium', $packageName ?: 'Premium Package');
        } else if ($request->package_type == 'pay_to_go') {
            $productId = $this->getOrCreateProductId('pay_to_go', $packageName ?: 'Pay To Go Package');
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $price = [];
        $price['nickname'] = $packageName . ' for monthly';
        $price['unit_amount'] = ($request->monthly_price) * 100;
        $price['currency'] = 'CAD';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 1];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_monthly_id' => $prices->id]);
    }

    public function createQuarterlyStripePrices($request, $packageName, $registrationPackage)
    {
        if ($request->package_type == 'free') {
            $productId = $this->getOrCreateProductId('free', $packageName ?: 'Free Package');
        } else if ($request->package_type == 'featured') {
            $productId = $this->getOrCreateProductId('featured', $packageName ?: 'Featured Package');
        } else if ($request->package_type == 'premium') {
            $productId = $this->getOrCreateProductId('premium', $packageName ?: 'Premium Package');
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $price = [];
        $price['nickname'] = $packageName . ' for quarterly';
        $price['unit_amount'] = ($request->quarterly_price * 3) * 100;
        $price['currency'] = 'CAD';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 3];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_quarterly_id' => $prices->id]);
    }

    public function createSemiAnnuallyStripePrices($request, $packageName, $registrationPackage)
    {
        if ($request->package_type == 'free') {
            $productId = $this->getOrCreateProductId('free', $packageName ?: 'Free Package');
        } else if ($request->package_type == 'featured') {
            $productId = $this->getOrCreateProductId('featured', $packageName ?: 'Featured Package');
        } else if ($request->package_type == 'premium') {
            $productId = $this->getOrCreateProductId('premium', $packageName ?: 'Premium Package');
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $price = [];
        $price['nickname'] = $packageName . ' for semi annually';
        $price['unit_amount'] = ($request->semi_annually_price * 6) * 100;
        $price['currency'] = 'CAD';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 6];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_semi_annually_id' => $prices->id]);
    }

    public function createAnnuallyStripePrices($request, $packageName, $registrationPackage)
    {
        if ($request->package_type == 'free') {
            $productId = $this->getOrCreateProductId('free', $packageName ?: 'Free Package');
        } else if ($request->package_type == 'featured') {
            $productId = $this->getOrCreateProductId('featured', $packageName ?: 'Featured Package');
        } else if ($request->package_type == 'premium') {
            $productId = $this->getOrCreateProductId('premium', $packageName ?: 'Premium Package');
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $price = [];
        $price['nickname'] = $packageName . ' for annually';
        $price['unit_amount'] = ($request->annually_price * 12) * 100;
        $price['currency'] = 'CAD';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 12];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_annually_id' => $prices->id]);
    }


    public function registrationPayment($package, $user, $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $cancel_at_period_end = true;
        if (($request->is_auto_renew ?? $user->is_auto_renew) == '1' || ($request->is_auto_renew === true)) {
            $cancel_at_period_end = false;
        }

        // Expect a payment method created securely on the frontend via Stripe Elements
        $paymentMethodId = $request->payment_method_id ?? null;
        if (!$paymentMethodId) {
            throw new \Exception('Payment method ID is required.');
        }

        if ($user->stripe_customer_id == null) {
            $stripeCustomer = $stripe->customers->create([
                'name' => $user->name,
                'email' => $user->email,
            ]);

            Customer::whereId($user->id)->update(['stripe_customer_id' => $stripeCustomer->id]);

            $stripe_customer_id = $stripeCustomer->id;
        } else {
            $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $user->stripe_customer_id]
            );
            $stripe_customer_id = $user->stripe_customer_id;
        }

        // Attach a payment method to the customer
        $paymentMethod = $stripe->paymentMethods->attach(
            $paymentMethodId,
            ['customer' => $stripe_customer_id]
        );

        // Set the attached payment method as the default for the customer
        $stripe->customers->update(
            $stripe_customer_id,
            ['invoice_settings' => ['default_payment_method' => $paymentMethod->id]]
        );

        if ($request->payment_frequency == 'monthly') {
            $stripe_price_id = $package->stripe_monthly_id;
        } else if ($request->payment_frequency == 'quarterly') {
            $stripe_price_id = $package->stripe_quarterly_id;
        } else if ($request->payment_frequency == 'semi_annually') {
            $stripe_price_id = $package->stripe_semi_annually_id;
        } else if ($request->payment_frequency == 'annually') {
            $stripe_price_id = $package->stripe_annually_id;
        }

        $subscription = $stripe->subscriptions->create([
            'customer' => $stripe_customer_id,
            'items' => [
                ['price' => $stripe_price_id],
            ],
            'cancel_at_period_end' => $cancel_at_period_end
        ]);

        $customerPaymentMethod = CustomerPaymentMethod::create([
            'customer_id' => Auth::guard('customers')->user()->id,
            'payment_method' => 'stripe',
            'payment_method_id' => $paymentMethodId,
            'card_holder_name' => $request->card_holder_name,
            'card_no' => null,
            'exp_month' => null,
            'exp_year' => null,
            'cvc' => null,
            'is_default' => 1,
        ]);

        CustomerPaymentMethod::where('id', '!=', $customerPaymentMethod->id)->update([
            'is_default' => 0,
        ]);
        return ['subscription_id' => $subscription->id, 'stripe_item_id' => isset($subscription->items->data[0]) ? $subscription->items->data[0]->id : null];
    }

    public function upgradeUserAccount($request, $user, $package)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $customerPaymentMethod = CustomerPaymentMethod::whereCustomerId(Auth::guard('customers')->user()->id)->where('card_no', $request->card_no)->first();

        if ($customerPaymentMethod) {
            // $customerPaymentMethod = CustomerPaymentMethod::whereId($request->customer_payment_method_id)->first();
            $paymentMethodId = $customerPaymentMethod->payment_method_id;
        } else {
            $paymentMethods = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->card_no,
                    'exp_month' => $request->expiry_month,
                    'exp_year' => $request->expiry_year,
                    'cvc' => $request->cvc,
                ],
            ]);
            $paymentMethodId = $paymentMethods->id;
        }

        if ($user->stripe_customer_id != '' && $user->stripe_customer_id != null) {
            // Attach a payment method to the customer
            $checkCustomerPaymentMethod = $stripe->paymentMethods->retrieve(
                $paymentMethodId,
                []
            );
            // dd($checkCustomerPaymentMethod);

            if (!$checkCustomerPaymentMethod) {
                $stripe->paymentMethods->attach(
                    $paymentMethodId,
                    ['customer' => $user->stripe_customer_id]
                );
            }
            $stripe_customer_id = $user->stripe_customer_id;
        } else {
            $stripeCustomer = $stripe->customers->create([
                'name' => $user->name,
                'email' => $user->email,
            ]);
            $stripe_customer_id = $stripeCustomer->id;

            Customer::whereId($user->id)->update([
                'stripe_customer_id' => $stripeCustomer->id
            ]);

            // Attach a payment method to the customer
            $paymentMethod = $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $stripeCustomer->id]
            );

            // Set the attached payment method as the default for the customer
            $stripe->customers->update(
                $stripeCustomer->id,
                ['invoice_settings' => ['default_payment_method' => $paymentMethod->id]]
            );
        }
        $packagePrice = 0;
        $expiryDate = date('Y-m-d');
        $eventsAllowed = 0;
        if ($request->payment_frequency == 'monthly') {
            $stripe_price_id = $package->stripe_monthly_id;
            $packagePrice = $package->monthly_price;
            $expiryDate = date('Y-m-d', strtotime('+1 months'));
            $eventsAllowed = $package->events_allowed;
        } else if ($request->payment_frequency == 'quarterly') {
            $stripe_price_id = $package->stripe_quarterly_id;
            $packagePrice = $package->quarterly_price * 3;
            $expiryDate = date('Y-m-d', strtotime('+3 months'));
            $eventsAllowed = $package->events_allowed * 3;
        } else if ($request->payment_frequency == 'semi_annually') {
            $stripe_price_id = $package->stripe_semi_annually_id;
            $packagePrice = $package->semi_annually_price * 6;
            $expiryDate = date('Y-m-d', strtotime('+6 months'));
            $eventsAllowed = $package->events_allowed * 6;
        } else if ($request->payment_frequency == 'annually') {
            $stripe_price_id = $package->stripe_annually_id;
            $packagePrice = $package->annually_price * 12;
            $expiryDate = date('Y-m-d', strtotime('+12 months'));
            $eventsAllowed = $package->events_allowed * 12;
        }
        if ($stripe_price_id) {
            $stripePrice = $stripe->prices->retrieve(
                $stripe_price_id,
                []
            );
            if ($stripePrice->active != true) {
                return [
                    'status' => 'error',
                    'message' => 'We are having trouble while process, contact with admin.',
                ];
            }
        }

        if ($user->subscription_id != '' && $user->subscription_id != null) {
            // Update the subscription with the new payment method
            // $stripe->subscriptions->update(
            //     $user->subscription_id,
            //     ['default_payment_method' => $paymentMethodId]
            // );
            if($user->type == 'customer'){
                // Set your Stripe secret key
                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                Log::info('Stripe API key set.');

                // Get the user's subscription ID
                $subscriptionId = $user->subscription_id;
                Log::info('Subscription ID retrieved: ' . $subscriptionId);

                // Get the latest invoice for the subscription
                $subscription = \Stripe\Subscription::retrieve($subscriptionId);
                Log::info('Subscription retrieved: ' . json_encode($subscription));

                // Get the latest charge from the latest invoice
                $latestInvoice = \Stripe\Invoice::retrieve($subscription->latest_invoice);
                Log::info('Latest invoice retrieved: ' . json_encode($latestInvoice));

                $chargeId = $latestInvoice->charge;
                Log::info('Charge ID: ' . $chargeId);

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
            }

            // $subscriptions = $stripe->subscriptions->update(
            //     $user->subscription_id,
            //     [
            //         'items' => [
            //             [
            //                 'id' => $user->stripe_item_id,
            //                 'deleted' => true,
            //             ],
            //             ['price' => $stripe_price_id],
            //         ],
            //     ]
            // );
        }
        $cancel_at_period_end = true;
        if ($request->is_auto_renew == '1') {
            $cancel_at_period_end = false;
        }
        $subscriptions = $stripe->subscriptions->create([
            'customer' => $stripe_customer_id,
            'items' => [
                ['price' => $stripe_price_id],
            ],
            'cancel_at_period_end' => $cancel_at_period_end
        ]);


        $currentDate = date('Y-m-d');
        $oldExpiryDate = $user->package_subscribed_date;

        // Convert the dates to DateTime objects
        $date1 = new DateTime($currentDate);
        $date2 = new DateTime($oldExpiryDate);

        // Calculate the difference between the two dates
        $interval = $date1->diff($date2);

        // Get the difference in days
        $packageUsed = $interval->days;

        $pkg = RegistrationPackage::whereId($request->registration_package_id)->first();
        if ($pkg) {
            $days = $pkg->package_validity_months * 30;
            $remainingDays = $days - $packageUsed;
            // $expiryDate = date('Y-m-d', strtotime($remainingDays . ' days'));
            $events_created = Event::where('customer_id', $user->id)->count();
            $events_remaining = $eventsAllowed - $events_created < 0 ? 0 : $eventsAllowed - $events_created;
            $images_allowed = $pkg->images_allowed;
        }


        Customer::whereId($user->id)->update([
            'payment_method' => 'stripe',
            'package_price' => $packagePrice,
            'package_expiry_date' => $expiryDate,
            'registration_package_id' => $request->registration_package_id,
            'subscription_id' => $subscriptions->id,
            'stripe_item_id' => isset($subscriptions->items->data[0]) ? $subscriptions->items->data[0]->id : null,
            'events_allowed' => isset($eventsAllowed) ? $eventsAllowed : $user->events_allowed,
            'events_remaining' => isset($events_remaining) ? $events_remaining : $user->events_remaining,
            'images_allowed' => isset($images_allowed) ? $images_allowed : $user->images_allowed,
        ]);

        $customerPaymentMethod = CustomerPaymentMethod::where('payment_method_id', $paymentMethodId)->first();
        if (!$customerPaymentMethod) {
            $customerPaymentMethod = CustomerPaymentMethod::create([
                'customer_id' => Auth::guard('customers')->user()->id,
                'payment_method' => 'stripe',
                'payment_method_id' => $paymentMethodId,
                'card_holder_name' => $request->card_holder_name,
                'card_no' => $request->card_no,
                'exp_month' => $request->expiry_month,
                'exp_year' => $request->expiry_year,
                'cvc' => $request->cvc,
                'is_default' => 1,
            ]);

            CustomerPaymentMethod::where('id', '!=', $customerPaymentMethod->id)->update([
                'is_default' => 0,
            ]);
        }

        return [
            'status' => 'success',
            'message' => 'We are having trouble while process, contact with admin.',
        ];
    }


    public function eventSignup($package, $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        // Get payment method ID from request (created securely on frontend)
        $paymentMethodId = $request->payment_method_id ?? null;
        if (!$paymentMethodId) {
            throw new \Exception('Payment method ID is required.');
        }

        // Create a new customer
        $stripeCustomer = $stripe->customers->create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Attach the payment method to the customer
        $stripe->paymentMethods->attach($paymentMethodId, [
            'customer' => $stripeCustomer->id,
        ]);

        // Set the attached payment method as the default for the customer
        $stripe->customers->update($stripeCustomer->id, [
            'invoice_settings' => ['default_payment_method' => $paymentMethodId],
        ]);

        // Create a payment intent for a one-time payment
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $package->event_price * 100, // Amount in cents
            'currency' => 'CAD',
            'customer' => $stripeCustomer->id,
            'payment_method' => $paymentMethodId,
            'off_session' => true,
            'confirm' => true,
        ]);

        return [
            'subscription_id' => $paymentIntent->id,
            'stripe_item_id' => $stripeCustomer->id,
            'payment_intent_id' => $paymentIntent->id,
            'stripe_customer_id' => $stripeCustomer->id,
            'payment_method_id' => $paymentMethodId
        ];
    }

    public function eventPackagePayAsGo($request, $user, $package)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        if ($request->customer_payment_method_id == 'add_new_card') {
            $paymentMethods = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->card_no,
                    'exp_month' => $request->expiry_month,
                    'exp_year' => $request->expiry_year,
                    'cvc' => $request->cvc,
                ],
            ]);
            $paymentMethodId = $paymentMethods->id;
        } else {
            $customerPaymentMethod = CustomerPaymentMethod::whereId($request->customer_payment_method_id)->first();
            $paymentMethodId = $customerPaymentMethod->payment_method_id;
        }

        if ($user->stripe_customer_id != '' && $user->stripe_customer_id != null) {
            // Attach a payment method to the customer
            $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $user->stripe_customer_id]
            );
            $stripe_customer_id = $user->stripe_customer_id;
        } else {
            $stripeCustomer = $stripe->customers->create([
                'name' => $user->name,
                'email' => $user->email,
            ]);
            $stripe_customer_id = $stripeCustomer->id;

            Customer::whereId($user->id)->update([
                'stripe_customer_id' => $stripeCustomer->id
            ]);

            // Attach a payment method to the customer
            $paymentMethod = $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $stripeCustomer->id]
            );

            // Set the attached payment method as the default for the customer
            $stripe->customers->update(
                $stripeCustomer->id,
                ['invoice_settings' => ['default_payment_method' => $paymentMethod->id]]
            );
        }

        $cancel_at_period_end = true;

        $subscriptions = $stripe->subscriptions->create([
            'customer' => $stripe_customer_id,
            'items' => [
                ['price' => $package->stripe_price_id],
            ],
            'cancel_at_period_end' => $cancel_at_period_end
        ]);
        $customerPaymentMethod = CustomerPaymentMethod::where('payment_method_id', $paymentMethodId)->first();
        if (!$customerPaymentMethod) {
            $customerPaymentMethod = CustomerPaymentMethod::create([
                'customer_id' => Auth::guard('customers')->user()->id,
                'payment_method' => 'stripe',
                'payment_method_id' => $paymentMethodId,
                'card_holder_name' => $request->card_holder_name,
                'card_no' => $request->card_no,
                'exp_month' => $request->expiry_month,
                'exp_year' => $request->expiry_year,
                'cvc' => $request->cvc,
                'is_default' => 1,
            ]);

            CustomerPaymentMethod::where('id', '!=', $customerPaymentMethod->id)->update([
                'is_default' => 0,
            ]);
        }
        return ['subscription_id' => $subscriptions->id, 'stripe_item_id' => isset($subscriptions->items->data[0]) ? $subscriptions->items->data[0]->id : null];
    }

    public function i2bPackagePayAsGo($request, $user, $package)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        if ($request->customer_payment_method_id == 'add_new_card') {
            $paymentMethods = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->card_no,
                    'exp_month' => $request->expiry_month,
                    'exp_year' => $request->expiry_year,
                    'cvc' => $request->cvc,
                ],
            ]);
            $paymentMethodId = $paymentMethods->id;
        } else {
            $customerPaymentMethod = CustomerPaymentMethod::whereId($request->customer_payment_method_id)->first();
            $paymentMethodId = $customerPaymentMethod->payment_method_id;
        }

        if ($user->stripe_customer_id != '' && $user->stripe_customer_id != null) {
            // Attach a payment method to the customer
            $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $user->stripe_customer_id]
            );
            $stripe_customer_id = $user->stripe_customer_id;
        } else {
            $stripeCustomer = $stripe->customers->create([
                'name' => $user->name,
                'email' => $user->email,
            ]);
            $stripe_customer_id = $stripeCustomer->id;

            Customer::whereId($user->id)->update([
                'stripe_customer_id' => $stripeCustomer->id
            ]);

            // Attach a payment method to the customer
            $paymentMethod = $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $stripeCustomer->id]
            );

            // Set the attached payment method as the default for the customer
            $stripe->customers->update(
                $stripeCustomer->id,
                ['invoice_settings' => ['default_payment_method' => $paymentMethod->id]]
            );
        }

        $cancel_at_period_end = true;
        $subscriptions = $stripe->subscriptions->create([
            'customer' => $stripe_customer_id,
            'items' => [
                ['price' => $package->stripe_price_id],
            ],
            'cancel_at_period_end' => $cancel_at_period_end
        ]);

        $customerPaymentMethod = CustomerPaymentMethod::where('payment_method_id', $paymentMethodId)->first();

        if (!$customerPaymentMethod) {
            $customerPaymentMethod = CustomerPaymentMethod::create([
                'customer_id' => Auth::guard('customers')->user()->id,
                'payment_method' => 'stripe',
                'payment_method_id' => $paymentMethodId,
                'card_holder_name' => $request->card_holder_name,
                'card_no' => $request->card_no,
                'exp_month' => $request->expiry_month,
                'exp_year' => $request->expiry_year,
                'cvc' => $request->cvc,
                'is_default' => 1,
            ]);

            CustomerPaymentMethod::where('id', '!=', $customerPaymentMethod->id)->update([
                'is_default' => 0,
            ]);
        }
        return ['subscription_id' => $subscriptions->id, 'stripe_item_id' => isset($subscriptions->items->data[0]) ? $subscriptions->items->data[0]->id : null];
    }
    public function createEventPrices($request, $packageName, $registrationPackage, $source = 'store')
    {
        if ($request->package_type == 'featured') {
            $productId = $this->getOrCreateProductId('event_featured', $packageName ?: 'Featured Event');
        } else if ($request->package_type == 'premium') {
            $productId = $this->getOrCreateProductId('event_premium', $packageName ?: 'Premium Event');
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $price = [];
        $price['nickname'] = $packageName . ' for events';
        $price['unit_amount'] = ($request->event_price) * 100;
        $price['currency'] = 'CAD';
        // $price['recurring'] = ['interval' => 'month', "interval_count" => 1];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['event_stripe_id' => $prices->id]);
    }
}
