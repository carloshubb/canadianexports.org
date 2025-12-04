<?php

namespace App\Services\Package;

use App\Models\Language;
use App\Models\PackageDetail;
use GuzzleHttp\Client;

class PaypalService
{
    public function paypalToken()
    {
        $client = new Client();

        $response = $client->post(env('PAYPAL_BASE_URL') . '/oauth2/token', [
            'auth' => [env('PAYPAL_CLIENT_ID'), env('PAYPAL_SECRET')],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        $tokenData = json_decode($response->getBody(), true);

        $accessToken = $tokenData['access_token'];
        return $accessToken;
    }

    public function createOrUpdatePackage($request, $package)
    {
        $paypal_plan_id = null;
        // GET package name
        $language = Language::where('is_default', '1')->first();
        $packageDetail = PackageDetail::wherePackageId($package->id);
        if ($language) {
            $packageDetail = $packageDetail->whereLanguageId($language->id);
        }
        $packageDetail = $packageDetail->first();
        $packageName = $packageDetail->name ?? env('APP_NAME');
        $packageDescription = $packageDetail->description ?? env('APP_NAME');

        if ($package->paypal_plan_id) {
            $paypal_plan_id = $this->checkProductExists($package->paypal_plan_id);
        }
        if (!$paypal_plan_id) {
            $paypal_plan_id = $this->createProduct([
                'name' => $packageName,
                'type' => 'SERVICE',
                'description' => $packageDescription,
                'category' => 'SOFTWARE',
            ]);

            $package->update(['paypal_plan_id' => $paypal_plan_id]);
        }
        if ($paypal_plan_id && $package) {
            $this->createPlan($request, $packageName, $package);
        }
    }

    public function createProduct($data)
    {
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/catalogs/products', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
        $product = json_decode($response->getBody(), true);
        return $product['id'] ?? null;
    }

    public function checkProductExists($product_id)
    {
        $client = new Client();
        $response = $client->get(env('PAYPAL_BASE_URL') . '/catalogs/products/' . $product_id, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
        ]);
        $product = json_decode($response->getBody(), true);
        return $product['id'] ?? null;
    }

    public function createPlan($request, $packageName, $package)
    {
        if ($package->monthly_price > 0) {
            if (
                $request->monthly_price != $package->monthly_price
                || is_null($package->par_monthly_id)
                || is_null($package->pnar_monthly_id)
                ) {
                    $this->createPayPalMonthly($packageName, $package);
            }
        } else {
            $package->update(['par_monthly_id' => null, 'pnar_monthly_id' => null]);
        }

        if ($package->quarterly_price > 0) {
            if (
                $request->quarterly_price != $package->quarterly_price
                || is_null($package->par_quaterly_id)
                || is_null($package->pnar_quaterly_id)
            ) {
                $this->createPayPalQuarterly($packageName, $package);
            }
        } else {
            $package->update(['par_quaterly_id' => null, 'pnar_quaterly_id' => null]);
        }

        if ($package->semi_annual_price > 0) {
            if (
                $request->semi_annual_price != $package->semi_annual_price
                || is_null($package->par_semi_annual_id)
                || is_null($package->pnar_semi_annual_id)
            ) {
                $this->createPayPalSemiAnnually($packageName, $package);
            }
        } else {
            $package->update(['par_semi_annual_id' => null, 'pnar_semi_annual_id' => null]);
        }

        if ($package->annual_price > 0) {
            if (
                $request->annual_price != $package->annual_price
                || is_null($package->par_annual_id)
                || is_null($package->pnar_annual_id)
            ) {
                $this->createPayPalAnnually($packageName, $package);
            }
        } else {
            $package->update(['par_annual_id' => null, 'pnar_annual_id' => null]);
        }
    }

    public function createPayPalMonthly($packageName, $package = null)
    {
        $productId = $package->paypal_plan_id;

        $interval_count = 1;
        $price = $package->monthly_price;

        $billing_detail = [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => $interval_count, // Interval count
                ],
                'tenure_type' => 'REGULAR', // Tenure type
                'sequence' => 1, // Cycle sequence number
                'total_cycles' => 0, // Total cycles
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $price, // Price value
                        'currency_code' => 'USD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for 1 month ', // Plan name
            'description' => $packageName . ' for 1 month plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan = json_decode($response->getBody(), true);


        if (isset($billing_detail[1]['total_cycles'])) {
            $billing_detail[1]['total_cycles'] = 1;
        }
        if (isset($billing_detail[0]['total_cycles'])) {
            $billing_detail[0]['total_cycles'] = 1;
        }

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for 1 month ', // Plan name
            'description' => $packageName . ' for 1 month plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($package == null) {
            return $plan['id'] ?? null;
        } else {
            $package->update(['par_monthly_id' => $plan['id'], 'pnar_monthly_id' => $plan_non_auto['id']]);
        }
    }

    public function createPayPalQuarterly($packageName, $package = null)
    {

        $productId = $package->paypal_plan_id;

        $interval_count = 3;
        $price = number_format($package->quarterly_price * 3, 2, '.', '');

        $billing_detail = [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => $interval_count, // Interval count
                ],
                'tenure_type' => 'REGULAR', // Tenure type
                'sequence' => 1, // Cycle sequence number
                'total_cycles' => 0, // Total cycles
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $price, // Price value
                        'currency_code' => 'USD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for quarterly ', // Plan name
            'description' => $packageName . ' for quarterly plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan = json_decode($response->getBody(), true);


        if (isset($billing_detail[1]['total_cycles'])) {
            $billing_detail[1]['total_cycles'] = 1;
        }
        if (isset($billing_detail[0]['total_cycles'])) {
            $billing_detail[0]['total_cycles'] = 1;
        }

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for quarterly ', // Plan name
            'description' => $packageName . ' for quarterly plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($package == null) {
            return $plan['id'] ?? null;
        } else {
            $package->update(['par_quaterly_id' => $plan['id'], 'pnar_quaterly_id' => $plan_non_auto['id']]);
        }
    }

    public function createPayPalSemiAnnually($packageName, $package = null)
    {

        $productId = $package->paypal_plan_id;

        $interval_count = 6;
        $price = number_format($package->semi_annual_price * 6, 2, '.', '');

        $billing_detail = [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => $interval_count, // Interval count
                ],
                'tenure_type' => 'REGULAR', // Tenure type
                'sequence' => 1, // Cycle sequence number
                'total_cycles' => 0, // Total cycles
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $price, // Price value
                        'currency_code' => 'USD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for semi annual ', // Plan name
            'description' => $packageName . ' for semi annual plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan = json_decode($response->getBody(), true);


        if (isset($billing_detail[1]['total_cycles'])) {
            $billing_detail[1]['total_cycles'] = 1;
        }
        if (isset($billing_detail[0]['total_cycles'])) {
            $billing_detail[0]['total_cycles'] = 1;
        }

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for semi annual ', // Plan name
            'description' => $packageName . ' for semi annual plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($package == null) {
            return $plan['id'] ?? null;
        } else {
            $package->update(['par_semi_annual_id' => $plan['id'], 'pnar_semi_annual_id' => $plan_non_auto['id']]);
        }
    }

    public function createPayPalAnnually($packageName, $package = null)
    {
        $productId = $package->paypal_plan_id;

        $interval_count = 12;
        $price = number_format($package->annual_price * 12, 2, '.', '');

        $billing_detail = [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => $interval_count, // Interval count
                ],
                'tenure_type' => 'REGULAR', // Tenure type
                'sequence' => 1, // Cycle sequence number
                'total_cycles' => 0, // Total cycles
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $price, // Price value
                        'currency_code' => 'USD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for annual ', // Plan name
            'description' => $packageName . ' for annual plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan = json_decode($response->getBody(), true);


        if (isset($billing_detail[1]['total_cycles'])) {
            $billing_detail[1]['total_cycles'] = 1;
        }
        if (isset($billing_detail[0]['total_cycles'])) {
            $billing_detail[0]['total_cycles'] = 1;
        }

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for annual ', // Plan name
            'description' => $packageName . ' for annual plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($package == null) {
            return $plan['id'] ?? null;
        } else {
            $package->update(['par_annual_id' => $plan['id'], 'pnar_annual_id' => $plan_non_auto['id']]);
        }
    }

    public function deavtivePlan($planId)
    {
        $client = new Client();
        $client->post(env('PAYPAL_BASE_URL') . '/billing/plans/' . $planId . '/deactivate', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    public function createSubscription($request, $user, $packag, $type = 'customer_signup')
    {
        $client = new Client();
        if ($user->payment_frequency == 'monthly') {
            $planId = $packag->par_monthly_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->pnar_monthly_id;
            }
        } else if ($user->payment_frequency == 'quarterly') {
            $planId = $packag->par_quaterly_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->pnar_quaterly_id;
            }
        } else if ($user->payment_frequency == 'semi_annual') {
            $planId = $packag->par_semi_annual_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->pnar_semi_annual_id;
            }
        } else if ($user->payment_frequency == 'annual') {
            $planId = $packag->par_annual_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->pnar_annual_id;
            }
        }


        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(), // Replace with your actual access token
            ],
            'json' => [
                'plan_id' => $planId, // Replace with your actual plan ID
                'subscriber' => [
                    'name' => [
                        'given_name' => $user->name,
                        'surname' => '',
                    ],
                    'email_address' => $user->email,
                ],
                'application_context' => [
                    'return_url' => route('paypal.subscription.success', ['user_id' => $user->id, 'type' => $type, 'package_id' => $packag->id]),
                    'cancel_url' => route('paypal.subscription.cancel', ['user_id' => $user->id, 'type' => $type, 'package_id' => $packag->id])
                ],
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);
        if (isset($responseData['links'][0]['href'])) {
            return [
                'status' => 'Success',
                'redirect_url' => $responseData['links'][0]['href']
            ];
        } else {
            if (isset($responseData->details)) {
                $errorMessage = $responseData->details[0]->issue;
            } else {
                $errorMessage = "An unknown error occurred.";
            }

            return [
                'status' => 'Error',
                'message' => "Subscription creation failed. Error: $errorMessage"
            ];
        }
    }

    public function updateSubscriptionPlan($request, $user, $packag)
    {
        $client = new Client();
        $response = $client->get(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(),
            ],
        ]);
        $existingSubscription = json_decode($response->getBody(), true);

        // Step 3: Create a new subscription with the updated plan
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(),
            ],
            'json' => [
                'plan_id' => $packag->paypal_plan_id, // Replace with the new plan ID
                'subscriber' => [
                    'name' => $existingSubscription['subscriber']['name'],
                    'email_address' => $existingSubscription['subscriber']['email_address'],
                ],
                'application_context' => [
                    'return_url' => env('APP_URL') . '/subscription/success', // Replace with your success URL
                    'cancel_url' => env('APP_URL') . '/subscription/cancel', // Replace with your cancel URL
                ],
            ],
        ]);

        $newSubscription = json_decode($response->getBody(), true);
        return $newSubscription['links'][0]['href'];
    }

    public function cancelSubscriptionPlan($user)
    {
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/suspend', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(),
            ],
        ]);
        $user->update([
            'subscription_status' => 'cancel'
        ]);
    }

    public function activateSubscriptionPlan($user)
    {
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/activate', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(),
            ],
        ]);
        $user->update([
            'subscription_status' => 'ok'
        ]);
    }



    public function createEventSubscription($request, $user, $packag, $type = 'customer_event_signup')
    {
        $client = new Client();
        $planId = $packag->event_paypal_id;


        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(), // Replace with your actual access token
            ],
            'json' => [
                'plan_id' => $planId, // Replace with your actual plan ID
                'subscriber' => [
                    'name' => [
                        'given_name' => $user['name'],
                        'surname' => '',
                    ],
                    'email_address' => $user['email'],
                ],
                'application_context' => [
                    'return_url' => route('paypal.subscription.success', ['n' => $user['name'], 'e' => $user['email'], 'p' => $user['password'], 'type' => $type, 'package_id' => $packag->id, 'pf' => $request->payment_frequency]),
                    'cancel_url' => route('paypal.subscription.cancel', ['n' => $user['name'], 'e' => $user['email'], 'p' => $user['password'], 'type' => $type, 'package_id' => $packag->id, 'bn' => $user['business_name'], 'pf' => $request->payment_frequency])
                ],
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);
        if (isset($responseData['links'][0]['href'])) {
            return [
                'status' => 'Success',
                'redirect_url' => $responseData['links'][0]['href']
            ];
        } else {
            if (isset($responseData->details)) {
                $errorMessage = $responseData->details[0]->issue;
            } else {
                $errorMessage = "An unknown error occurred.";
            }

            return [
                'status' => 'Error',
                'message' => "Subscription creation failed. Error: $errorMessage"
            ];
        }
    }

    public function createEventPlan($request, $packageName, $package = null)
    {
        if ($request->event_price > 0) {
            $this->createEventPayPal($request, $packageName, $package);
        } else {
            $package->update(['event_paypal_id' => null]);
        }
    }

    public function createEventPayPal($request, $packageName, $package = null)
    {
        if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['paypal_featured_product']);
            $productId = $setting['paypal_featured_product'];
        } elseif ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['paypal_premium_product']);
            $productId = $setting['paypal_premium_product'];
        }

        $interval_count = 1;
        $price = $request->event_price;

        $billing_detail = [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => $interval_count, // Interval count
                ],
                'tenure_type' => 'REGULAR', // Tenure type
                'sequence' => 1, // Cycle sequence number
                'total_cycles' => 1, // Total cycles
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $price, // Price value
                        'currency_code' => 'USD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for event ', // Plan name
            'description' => $packageName . ' for event is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();

        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($package == null) {
            return $plan_non_auto['id'];
        } else {
            $package->update(['event_paypal_id' => $plan_non_auto['id']]);
        }
    }
}
