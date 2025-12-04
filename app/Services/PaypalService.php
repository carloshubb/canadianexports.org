<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\GeneralSetting;

class PaypalService
{
    protected function getOrCreatePaypalProductId($packageType, $fallbackName = 'Registration Package')
    {
        $keyMap = [
            'free' => 'paypal_free_product',
            'featured' => 'paypal_featured_product',
            'premium' => 'paypal_premium_product',
            'event_featured' => 'paypal_featured_product',
            'event_premium' => 'paypal_premium_product',
        ];

        $key = $keyMap[$packageType] ?? null;
        if (!$key) {
            return null;
        }

        $setting = getSignleGeneralSettingByKey([$key]);
        $productId = $setting[$key] ?? null;

        if ($productId) {
            try {
                $this->showProductDetails($productId);
                return $productId;
            } catch (\Exception $e) {
                // fall through to create
            }
        }

        $newProductId = $this->createProduct([
            'name' => $fallbackName ?: ucfirst($packageType) . ' Package',
            'type' => 'SERVICE',
            'category' => 'SOFTWARE',
        ]);

        GeneralSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $newProductId, 'type' => 'package']
        );

        return $newProductId;
    }
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
        return $product['id'];
    }

    public function showProductDetails($productId)
    {
        $client = new Client();
        $response = $client->request('GET', env('PAYPAL_BASE_URL') . "/catalogs/products/{$productId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function create(array $data)
    {
        $client = new Client();
        $response = $client->request('POST', env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function createPlan($request, $packageName, $registrationPackage = null)
    {
        if ($request->monthly_price > 0) {
            $this->createPayPalMonthly($request, $packageName, $registrationPackage);
        } else {
            $registrationPackage->update(['paypal_auto_renew_monthly_id' => null, 'paypal_non_auto_renew_monthly_id' => null]);
        }

        if ($request->quarterly_price > 0) {
            $this->createPayPalQuarterly($request, $packageName, $registrationPackage);
        } else {
            $registrationPackage->update(['paypal_auto_renew_quarterly_id' => null, 'paypal_non_auto_renew_quarterly_id' => null]);
        }

        if ($request->semi_annually_price > 0) {
            $this->createPayPalSemiAnnually($request, $packageName, $registrationPackage);
        } else {
            $registrationPackage->update(['paypal_auto_renew_semi_annually_id' => null, 'paypal_non_auto_renew_semi_annually_id' => null]);
        }

        if ($request->annually_price > 0) {
            $this->createPayPalAnnually($request, $packageName, $registrationPackage);
        } else {
            $registrationPackage->update(['paypal_auto_renew_annually_id' => null, 'paypal_non_auto_renew_annually_id' => null]);
        }
    }

    public function createPayPalMonthly($request, $packageName, $registrationPackage = null)
    {
        if ($request->package_type == 'featured') {
            $productId = $this->getOrCreatePaypalProductId('featured', $packageName ?: 'Featured Package');
        } elseif ($request->package_type == 'premium') {
            $productId = $this->getOrCreatePaypalProductId('premium', $packageName ?: 'Premium Package');
        } elseif ($request->package_type == 'free') {
            $productId = $this->getOrCreatePaypalProductId('free', $packageName ?: 'Free Package');
        }

        $interval_count = 1;
        $price = $request->monthly_price;

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
                        'currency_code' => 'CAD',
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
                    'currency_code' => 'CAD',
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
                    'currency_code' => 'CAD',
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
        if ($registrationPackage == null) {
            return $plan['id'];
        } else {
            $registrationPackage->update(['paypal_auto_renew_monthly_id' => $plan['id'], 'paypal_non_auto_renew_monthly_id' => $plan_non_auto['id']]);
        }
    }

    public function createPayPalQuarterly($request, $packageName, $registrationPackage = null)
    {

        if ($request->package_type == 'featured') {
            $productId = $this->getOrCreatePaypalProductId('featured', $packageName ?: 'Featured Package');
        } elseif ($request->package_type == 'premium') {
            $productId = $this->getOrCreatePaypalProductId('premium', $packageName ?: 'Premium Package');
        } elseif ($request->package_type == 'free') {
            $productId = $this->getOrCreatePaypalProductId('free', $packageName ?: 'Free Package');
        }

        $interval_count = 3;
        $price = number_format($request->quarterly_price * 3, 2, '.', '');

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
                        'currency_code' => 'CAD',
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
                    'currency_code' => 'CAD',
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
                    'currency_code' => 'CAD',
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
        if ($registrationPackage == null) {
            return $plan['id'];
        } else {
            $registrationPackage->update(['paypal_auto_renew_quarterly_id' => $plan['id'], 'paypal_non_auto_renew_quarterly_id' => $plan_non_auto['id']]);
        }
    }

    public function createPayPalSemiAnnually($request, $packageName, $registrationPackage = null)
    {

        if ($request->package_type == 'featured') {
            $productId = $this->getOrCreatePaypalProductId('featured', $packageName ?: 'Featured Package');
        } elseif ($request->package_type == 'premium') {
            $productId = $this->getOrCreatePaypalProductId('premium', $packageName ?: 'Premium Package');
        } elseif ($request->package_type == 'free') {
            $productId = $this->getOrCreatePaypalProductId('free', $packageName ?: 'Free Package');
        }


        $interval_count = 6;
        $price = number_format($request->semi_annually_price * 6, 2, '.', '');

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
                        'currency_code' => 'CAD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for semi annually ', // Plan name
            'description' => $packageName . ' for semi annually plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'CAD',
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
            'name' => $packageName . ' for semi annually ', // Plan name
            'description' => $packageName . ' for semi annually plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'CAD',
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
        if ($registrationPackage == null) {
            return $plan['id'];
        } else {
            $registrationPackage->update(['paypal_auto_renew_semi_annually_id' => $plan['id'], 'paypal_non_auto_renew_semi_annually_id' => $plan_non_auto['id']]);
        }
    }

    public function createPayPalAnnually($request, $packageName, $registrationPackage = null)
    {
        if ($request->package_type == 'featured') {
            $productId = $this->getOrCreatePaypalProductId('featured', $packageName ?: 'Featured Package');
        } elseif ($request->package_type == 'premium') {
            $productId = $this->getOrCreatePaypalProductId('premium', $packageName ?: 'Premium Package');
        } elseif ($request->package_type == 'free') {
            $productId = $this->getOrCreatePaypalProductId('free', $packageName ?: 'Free Package');
        }

        $interval_count = 12;
        $price = number_format($request->annually_price * 12, 2, '.', '');

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
                        'currency_code' => 'CAD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for annually ', // Plan name
            'description' => $packageName . ' for annually plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'CAD',
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
            'name' => $packageName . ' for annually ', // Plan name
            'description' => $packageName . ' for annually plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'CAD',
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
        if ($registrationPackage == null) {
            return $plan['id'];
        } else {
            $registrationPackage->update(['paypal_auto_renew_annually_id' => $plan['id'], 'paypal_non_auto_renew_annually_id' => $plan_non_auto['id']]);
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

    public function refundPayPalSale($saleId, $amount)
    {
        $client = new Client();
        $url = env('PAYPAL_BASE_URL') . "/payments/sale/{$saleId}/refund";

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->paypalToken(),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'amount' => [
                        'total' => $amount,
                        'currency' => 'USD'
                    ]
                ]
            ]);

            if ($response->getStatusCode() == 201) {
                return true;
            }
        } catch (\Exception $e) {
            // Handle refund error
            return response()->json(['error' => 'Error processing refund: ' . $e->getMessage()]);
        }
    }

    public function subscription($data)
    {
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . "/billing/subscriptions", [
            'headers' => [
                'Authorization' => "Bearer " . $this->paypalToken(),
                'Content-Type' => 'application/json'
            ],
            'json' => $data
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

    private function validateAndRecreatePlanIfNeeded($planId, $packag, $frequency, $isAutoRenew)
    {
        // If plan ID is missing, recreate it
        if (!$planId) {
            return $this->recreatePlansForFrequency($packag, $frequency, $isAutoRenew);
        }

        // Validate the plan ID exists in current PayPal account
        try {
            $client = new Client();
            $response = $client->get(env('PAYPAL_BASE_URL') . '/billing/plans/' . $planId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->paypalToken(),
                    'Content-Type' => 'application/json',
                ],
            ]);

            $planData = json_decode($response->getBody(), true);
            // If plan exists and is active, return it
            if (isset($planData['id'])) {
                return $planId;
            }
        } catch (\Exception $e) {
            // Plan doesn't exist or error occurred, recreate it
        }

        // Recreate the plan
        return $this->recreatePlansForFrequency($packag, $frequency, $isAutoRenew);
    }

    private function recreatePlansForFrequency($packag, $frequency, $isAutoRenew)
    {
        $packageName = isset($packag->registrationPackageDetail[0]) ? $packag->registrationPackageDetail[0]->name : 'Package';
        
        // Recreate plans based on frequency
        if ($frequency == 'monthly') {
            $mockRequest = (object)[
                'package_type' => $packag->package_type,
                'monthly_price' => $packag->monthly_price
            ];
            $this->createPayPalMonthly($mockRequest, $packageName, $packag);
            $packag = $packag->fresh(); // Reload package with new plan IDs
            return $isAutoRenew == '1' ? $packag->paypal_auto_renew_monthly_id : $packag->paypal_non_auto_renew_monthly_id;
        } else if ($frequency == 'quarterly') {
            $mockRequest = (object)[
                'package_type' => $packag->package_type,
                'quarterly_price' => $packag->quarterly_price
            ];
            $this->createPayPalQuarterly($mockRequest, $packageName, $packag);
            $packag = $packag->fresh();
            return $isAutoRenew == '1' ? $packag->paypal_auto_renew_quarterly_id : $packag->paypal_non_auto_renew_quarterly_id;
        } else if ($frequency == 'semi_annually') {
            $mockRequest = (object)[
                'package_type' => $packag->package_type,
                'semi_annually_price' => $packag->semi_annually_price
            ];
            $this->createPayPalSemiAnnually($mockRequest, $packageName, $packag);
            $packag = $packag->fresh();
            return $isAutoRenew == '1' ? $packag->paypal_auto_renew_semi_annually_id : $packag->paypal_non_auto_renew_semi_annually_id;
        } else if ($frequency == 'annually') {
            $mockRequest = (object)[
                'package_type' => $packag->package_type,
                'annually_price' => $packag->annually_price
            ];
            $this->createPayPalAnnually($mockRequest, $packageName, $packag);
            $packag = $packag->fresh();
            return $isAutoRenew == '1' ? $packag->paypal_auto_renew_annually_id : $packag->paypal_non_auto_renew_annually_id;
        }

        return null;
    }

    private function validateAndRecreateEventPlanIfNeeded($planId, $packag)
    {
        // If plan ID is missing, recreate it
        if (!$planId) {
            return $this->recreateEventPlan($packag);
        }

        // Validate the plan ID exists in current PayPal account
        try {
            $client = new Client();
            $response = $client->get(env('PAYPAL_BASE_URL') . '/billing/plans/' . $planId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->paypalToken(),
                    'Content-Type' => 'application/json',
                ],
            ]);

            $planData = json_decode($response->getBody(), true);
            // If plan exists and is active, return it
            if (isset($planData['id'])) {
                return $planId;
            }
        } catch (\Exception $e) {
            // Plan doesn't exist or error occurred, recreate it
        }

        // Recreate the plan
        return $this->recreateEventPlan($packag);
    }

    private function recreateEventPlan($packag)
    {
        $packageName = isset($packag->registrationPackageDetail[0]) ? $packag->registrationPackageDetail[0]->name : 'Package';
        
        // Create a mock request object with the necessary data
        $mockRequest = (object)[
            'event_price' => $packag->event_price,
            'package_type' => $packag->package_type
        ];
        
        try {
            $this->createEventPlan($mockRequest, $packageName, $packag);
            $packag = $packag->fresh(); // Reload package with new plan ID
            return $packag->event_paypal_id;
        } catch (\Exception $e) {
            // Log the error for debugging
            \Illuminate\Support\Facades\Log::error('Failed to create PayPal event plan: ' . $e->getMessage());
            return null;
        }
    }

    public function createSubscription($request, $user, $packag, $type = 'customer_signup')
    {
        $client = new Client();
        $planId = null;
        
        // Get the initial plan ID based on frequency and auto-renew
        if ($user->temp_payment_frequency == 'monthly') {
            $planId = $packag->paypal_auto_renew_monthly_id;
            if ($user->temp_is_auto_renew == '1') {
                $planId = $packag->paypal_auto_renew_monthly_id;
            } else {
                $planId = $packag->paypal_non_auto_renew_monthly_id;
            }
        } else if ($user->temp_payment_frequency == 'quarterly') {
            $planId = $packag->paypal_auto_renew_quarterly_id;
            if ($user->temp_is_auto_renew == '1') {
                $planId = $packag->paypal_auto_renew_quarterly_id;
            } else {
                $planId = $packag->paypal_non_auto_renew_quarterly_id;
            }
        } else if ($user->temp_payment_frequency == 'semi_annually') {
            $planId = $packag->paypal_auto_renew_semi_annually_id;
            if ($user->temp_is_auto_renew == '1') {
                $planId = $packag->paypal_auto_renew_semi_annually_id;
            } else {
                $planId = $packag->paypal_non_auto_renew_semi_annually_id;
            }
        } else if ($user->temp_payment_frequency == 'annually') {
            $planId = $packag->paypal_auto_renew_annually_id;
            if ($user->temp_is_auto_renew == '1') {
                $planId = $packag->paypal_auto_renew_annually_id;
            } else {
                $planId = $packag->paypal_non_auto_renew_annually_id;
            }
        }

        // Validate and recreate plan if needed
        $planId = $this->validateAndRecreatePlanIfNeeded($planId, $packag, $user->temp_payment_frequency, $user->temp_is_auto_renew);

        if (!$planId) {
            return [
                'status' => 'Error',
                'message' => "Failed to create or retrieve PayPal plan. Please try again."
            ];
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

        // Validate and create plan if needed
        $planId = $this->validateAndRecreateEventPlanIfNeeded($planId, $packag);

        if (!$planId) {
            return [
                'status' => 'Error',
                'message' => "Failed to create or retrieve PayPal event plan. Please try again."
            ];
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
                        'given_name' => $user['name'],
                        'surname' => '',
                    ],
                    'email_address' => $user['email'],
                ],
                'application_context' => [
                    'return_url' => route('paypal.subscription.success', ['n' => $user['name'], 'e' => $user['email'], 'type' => $type, 'package_id' => $packag->id, 'bn' => $user['business_name'], 'pf' => $request->payment_frequency]),
                    'cancel_url' => route('paypal.subscription.cancel', ['n' => $user['name'], 'e' => $user['email'], 'type' => $type, 'package_id' => $packag->id, 'bn' => $user['business_name'], 'pf' => $request->payment_frequency])
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

    public function createEventPlan($request, $packageName, $registrationPackage = null)
    {
        if ($request->event_price > 0) {
            $this->createEventPayPal($request, $packageName, $registrationPackage);
        } else {
            $registrationPackage->update(['event_paypal_id' => null]);
        }
    }

    public function createEventPayPal($request, $packageName, $registrationPackage = null)
    {
        if ($request->package_type == 'featured') {
            $productId = $this->getOrCreatePaypalProductId('event_featured', $packageName ?: 'Featured Event');
        } elseif ($request->package_type == 'premium') {
            $productId = $this->getOrCreatePaypalProductId('event_premium', $packageName ?: 'Premium Event');
        } elseif ($request->package_type == 'free') {
            $productId = $this->getOrCreatePaypalProductId('free', $packageName ?: 'Free Event');
        }

        // If no product ID is found, return null
        if (!isset($productId) || empty($productId)) {
            return null;
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
                        'currency_code' => 'CAD',
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
                    'currency_code' => 'CAD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();

        try {
            $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->paypalToken(),
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);
        } catch (\Exception $e) {
            // Retry once with a fresh product
            if ($request->package_type == 'featured') {
                $productId = $this->getOrCreatePaypalProductId('event_featured', $packageName ?: 'Featured Event');
            } elseif ($request->package_type == 'premium') {
                $productId = $this->getOrCreatePaypalProductId('event_premium', $packageName ?: 'Premium Event');
            } elseif ($request->package_type == 'free') {
                $productId = $this->getOrCreatePaypalProductId('free', $packageName ?: 'Free Event');
            }
            $data['product_id'] = $productId;
            $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->paypalToken(),
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);
        }

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($registrationPackage == null) {
            return $plan_non_auto['id'];
        } else {
            $registrationPackage->update(['event_paypal_id' => $plan_non_auto['id']]);
        }
    }

    /**
     * Create PayPal order for one-time payment (not subscription)
     */
    public function createOrder($data)
    {
        $client = new Client();
        
        try {
            // Use v2 endpoint - replace /v1 with /v2 if present in base URL
            $baseUrl = str_replace('/v1', '', env('PAYPAL_BASE_URL'));
            
            $response = $client->post($baseUrl . '/v2/checkout/orders', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->paypalToken(),
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return [
                'status' => 'Error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Capture PayPal order payment
     */
    public function captureOrder($orderId)
    {
        $client = new Client();
        
        try {
            // Use v2 endpoint - replace /v1 with /v2 if present in base URL
            $baseUrl = str_replace('/v1', '', env('PAYPAL_BASE_URL'));
            
            $response = $client->post($baseUrl . "/v2/checkout/orders/{$orderId}/capture", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->paypalToken(),
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return [
                'status' => 'Error',
                'message' => $e->getMessage()
            ];
        }
    }
}
