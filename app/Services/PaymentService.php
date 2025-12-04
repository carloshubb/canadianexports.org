<?php

namespace App\Services;

use App\Http\Resources\Web\RegistrationPackageResource;
use App\Models\Customer;
use App\Models\Event;
use App\Traits\StatusResponser;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Refund;

class PaymentService
{
    use StatusResponser;

    public function paypalUpgradePackage($package, $user, $request, $type = 'account_setting_upgrade')
    {
        $paypalService = new PaypalService();
        // if user selects free package
        $packagePrice = isset($package, $package->discount_price) && $package->discount_price > 0 ? $package->discount_price : (isset($package) ? $package->price : 0);

        if ($packagePrice > 0) {
            $paypalResponse = $paypalService->createSubscription($request, $user, $package, $type);
            Customer::whereId($user->id)->update([
                'temp_registration_package_id' => $package->id,
            ]);

            return $paypalResponse;
        } else if ($packagePrice <= 0) {
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
                        Log::info('Subscription = ' . $subscription);
                        $saleId = $subscriptionData['billing_info']['last_payment']['sale_id'] ?? null;

                        Log::info('Sale id = ' . $saleId);

                        if ($saleId) {
                            $paypalService = new PaypalService();
                            $refundPaypalResponse = $paypalService->refundPayPalSale($user->paypal_subscription_id, $amount);
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

            $currentDate = date('Y-m-d');
            $oldExpiryDate = $user->package_subscribed_date;

            // Convert the dates to DateTime objects
            $date1 = new DateTime($currentDate);
            $date2 = new DateTime($oldExpiryDate);

            // Calculate the difference between the two dates
            $interval = $date1->diff($date2);

            // Get the difference in days
            $packageUsed = $interval->days;


            if ($package) {
                $days = $package->package_validity_months * 30;
                $remainingDays = $days - $packageUsed;
                $expiryDate = date('Y-m-d', strtotime($remainingDays . ' days'));
                $events_allowed = $package->events_allowed;
                $i2b_allowed = $package->i2b_allowed;
                $events_created = Event::where('customer_id', $user->id)->count();
                $events_remaining = $events_allowed - $events_created < 0 ? 0 : $events_allowed - $events_created;
                $i2b_remaining = $i2b_allowed - $user->i2b_allowed < 0 ? 0 : $i2b_allowed - $user->i2b_allowed;
                $images_allowed = $package->images_allowed;
            }

            Customer::whereId($user->id)->update([
                'package_price' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : $package->price,
                'registration_package_id' => $request->registration_package_id,
                'subscription_status' => 'ok',
                'payment_method' => 'paypal',
                'subscription_id' => null,
                'paypal_subscription_id' => null,
                'stripe_customer_id' => null,
                'stripe_item_id' => null,
                'package_expiry_date' => $expiryDate,
                'events_allowed' => isset($events_allowed) ? $events_allowed : $user->events_allowed,
                'events_remaining' => isset($events_remaining) ? $events_remaining : $user->events_remaining,
                // 'i2b_allowed' => isset($i2b_allowed) ? $i2b_allowed : $user->i2b_allowed,
                // 'i2b_remaining' => isset($i2b_remaining) ? $i2b_remaining : $user->i2b_remaining,
                'images_allowed' => isset($images_allowed) ? $images_allowed : $user->images_allowed,
            ]);
            return [
                'status' => 'Success',
                'type' => 'no_redirect',
                'message' => 'Package has been updated successfully.'
            ];
        }
    }

    function cancelPayPalSubscription($user)
    {
        $paypalService = new PaypalService;
        $client = new Client();
        $subscription = $client->get(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
            ],
        ]);


        if ($subscription) {
            $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/cancel', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                ],
            ]);
            Customer::whereId($user->id)->update([
                'paypal_subscription_id' => null,
            ]);
        }
    }
}
