<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\BusinessDirectory;
use App\Models\BusinessDirectoryDetail;
use App\Models\CoffeeWallet;
use App\Models\CoffeeWallPackage;
use App\Services\PaypalService;
use App\Traits\StatusResponser;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use LVR\CreditCard\CardNumber;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use Stripe\Subscription;

class HomeController extends Controller
{
    use StatusResponser;

    public function index($slug = null)
    {
        $this->checkPageSlug($slug);
        return view('front.index', compact('slug'));
    }

    public function index_abbreviation($abbreviation, $slug = null)
    {
        updateLangByAbber($abbreviation);
        $response = $this->checkPageSlug($slug);
        if ($response) {
            return Redirect::to($response);
        }

        $lang = getDefaultLanguage(true);
        if (isset($slug)) {
            $page = getPageBySlug($slug, $lang);
        } else {
            $page = getFrontPage();
        }
        if (!$page) {
            abort(404);
        }
        return view('front.index', compact('slug', 'page', 'lang'));
    }

    public function coffeeOnWall($abbreviation)
    {
        updateLangByAbber($abbreviation);
        $lang = getDefaultLanguage(true);
        return view('front.coffee_wall', compact('lang'));
    }

    public function coffeeOnWallStore(Req $request)
    {
        Log::info('===== Coffee on Wall Form Submission Started =====');
        Log::info('Request Data:', $request->except(['card_holder_name', 'payment_method_id']));

        $validationRule = [
            'custom_amount' => $request->package == 'custom' ? 'required' : 'nullable',
            'name' => $request->anonymous ? 'nullable' : 'required',
            'email' => $request->anonymous ? 'nullable' : 'required',
            'payment_method' => 'required|in:stripe,paypal',
            'package_id' => $request->custom_amount ? 'nullable' : 'required|exists:coffee_wall_packages,id',
            'beneficiary_ids' => 'required|array|min:1',
            'beneficiary_ids.*' => 'distinct|exists:coffee_wall_beneficiaries,id',
            'agree_terms' => 'required',
            'non_refundable_agreement' => 'required|accepted',
            'terms_privacy_agreement' => 'required|accepted',
        ];
        
        Log::info('Validation Rules:', $validationRule);
        
        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);
        
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $coffee_wall_setting = getI2bModalSetting($defaultLang, ['coffee_wall_setting']);
            $payment_setting = getI2bModalSetting($defaultLang, ['payment_setting']);
            $niceNames = [
                'name' => isset($coffee_wall_setting['name_error']) ? $coffee_wall_setting['name_error'] : '',
                'email' => isset($coffee_wall_setting['email_error']) ? $coffee_wall_setting['email_error'] : '',
                'package_id' => isset($coffee_wall_setting['package_error']) ? $coffee_wall_setting['package_error'] : '',
                'beneficiary_ids' => isset($coffee_wall_setting['beneficiary_error']) ? $coffee_wall_setting['beneficiary_error'] : 'Please select at least one beneficiary',
                'agree_terms' => isset($coffee_wall_setting['agree_terms_error']) ? $coffee_wall_setting['agree_terms_error'] : '',
                'card_holder_name' => isset($payment_setting['cardholder_name_error']) ? $payment_setting['cardholder_name_error'] : '',
                'non_refundable_agreement' => 'You must agree that your contribution is non-refundable',
                'terms_privacy_agreement' => 'You must agree to the Terms and Conditions and Privacy Policy',
            ];
        }

        if (isset($request->payment_method) && $request->payment_method == 'stripe' && $request->order_amount > 0) {
            Log::info('Payment method is Stripe, validating payment method ID');
            $validationRule = array_merge($validationRule, [
                'card_holder_name' => ['required'],
                'payment_method_id' => ['required', 'string']
            ]);
            $niceNames = array_merge($niceNames, [
                'payment_method_id' => 'Card information is required'
            ]);
        }

        $messages = [];

        try {
            $this->validate(
                $request,
                $validationRule,
                $messages,
                $niceNames
            );
            Log::info('Validation passed successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', [
                'error' => $e->getMessage(),
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Validation failed:', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }

        $beneficiaryIds = collect($request->input('beneficiary_ids', []))
            ->filter()
            ->unique()
            ->values();

        if ($request->package_id) {
            $package = CoffeeWallPackage::whereId($request->package_id)->first();
        } else {
            $package = CoffeeWallPackage::where('price', $request->custom_amount)->first();
            if (!$package) {
                DB::beginTransaction();
                $package = CoffeeWallPackage::create([
                    'price' => $request->custom_amount ?? 0,
                    'custom' => 1,
                ]);

                $packageName = $request->name ?? env('APP_NAME');
                $packageDescription = 'custom' ?? env('APP_NAME');

                Stripe::setApiKey(env('STRIPE_SECRET'));

                if ($package->stripe_product_id) {
                    $product = Product::retrieve($package->stripe_product_id);
                    $product->name = $packageName;
                    $product->save();
                } else {
                    $product = Product::create([
                        'name' => $packageName,
                        'type' => 'service',
                    ]);
                    $package->update(['stripe_product_id' => $product->id]);
                }

                if ($package->price) {
                    $priceData = [
                        'product' => $product->id,
                        'unit_amount' => $package->price * 100,
                        'currency' => 'usd',
                        'recurring' => ['interval' => 'month', 'interval_count' => 1],
                    ];

                    $price = Price::create($priceData);
                }

                $package->update(['stripe_price_id' => $price->id ?? null]);

                $paypal_plan_id = null;

                $paypal = new PaypalService();

                if ($package->paypal_product_id) {
                    $product = $paypal->showProductDetails($package->paypal_product_id);
                    $paypal_plan_id = $product['id'] ?? null;
                }
                if (!$paypal_plan_id) {
                    $data = [
                        'name' => $packageName,
                        'type' => 'SERVICE',
                        'description' => $packageDescription,
                        'category' => 'SOFTWARE',
                    ];
                    $product = $paypal->createProduct($data);
                    $paypal_plan_id = $product ?? null;

                    $package->update(['paypal_product_id' => $paypal_plan_id]);
                }
                if ($paypal_plan_id && $package) {
                    if ($package->price > 0) {
                        $productId = $package->paypal_product_id;

                        $interval_count = 1;
                        $price = $package->price;

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

                        $plan = $paypal->create($data);

                        if ($package == null) {
                            $plan['id'] = null;
                        } else {
                            $package->update(['paypal_price_id' => $plan['id']]);
                        }
                    } else {
                        $package->update(['paypal_price_id' => null]);
                    }
                }

                DB::commit();
            }
        }

        $package_price = $package->price;
        
        Log::info('Package price determined', ['package_price' => $package_price]);
        Log::info('Payment method', ['payment_method' => $request->payment_method]);

        if ($request->payment_method == 'stripe') {
            Log::info('Setting up Stripe API');
            Stripe::setApiKey(env('STRIPE_SECRET'));
        }

        try {
            if ($request->payment_method == 'stripe' && $package_price > 0) {
                Log::info('Processing Stripe payment with payment method ID', [
                    'payment_method_id' => $request->payment_method_id
                ]);

                $interval = null;
                $interval_count = 1;

                if ($request->frequency == 'weekly') {
                    $interval = 'week';
                    $interval_count = 1; // Charge every 1 week
                } else if ($request->frequency == 'monthly') {
                    $interval = 'month';
                } else if ($request->frequency == 'quarterly') {
                    $interval = 'month';
                    $interval_count = 3;
                } else if ($request->frequency == 'semi_annually') {
                    $interval = 'month';
                    $interval_count = 6;
                } else if ($request->frequency == 'annually') {
                    $interval = 'year';
                }

                // Create Stripe Customer with payment method ID from Stripe Elements
                $stripeCustomer = Customer::create([
                    'name' => $request->card_holder_name ?? $request->name,
                    'email' => $request->email,
                    'payment_method' => $request->payment_method_id,
                    'invoice_settings' => [
                        'default_payment_method' => $request->payment_method_id
                    ]
                ]);

                $stripe_customer_id = $stripeCustomer->id;
                
                Log::info('Stripe customer created', [
                    'customer_id' => $stripe_customer_id
                ]);

                // Attach the payment method to customer
                $paymentMethod = PaymentMethod::retrieve($request->payment_method_id);
                $paymentMethod->attach(['customer' => $stripe_customer_id]);

                $subscription_items = [
                    ['price' => $package->stripe_price_id],
                ];

                $subscription_params = [
                    'customer' => $stripe_customer_id,
                    'items' => $subscription_items,
                    'default_payment_method' => $request->payment_method_id,
                    'cancel_at_period_end' => false,
                ];

                // Add the interval and interval_count if applicable
                if ($interval) {
                    $subscription_params['billing_cycle_anchor'] = now()->timestamp; // Anchor the subscription
                    $subscription_items[0]['plan'] = [
                        'interval' => $interval,
                    ];
                    if (isset($interval_count)) {
                        $subscription_items[0]['plan']['interval_count'] = $interval_count;
                    }
                }

                $subscription = Subscription::create($subscription_params);

                $subscription_id = $subscription->id;
                $stripe_item_id = isset($subscription->items->data[0]) ? $subscription->items->data[0]->id : null;
                
                Log::info('Stripe subscription created successfully', [
                    'subscription_id' => $subscription_id,
                    'stripe_item_id' => $stripe_item_id
                ]);
            } else if ($request->payment_method == 'paypal' && $package_price > 0) {
                Log::info('Processing PayPal payment for package price: ' . $package_price);
                $paypal = new PaypalService();

                if (!$package->paypal_price_id) {
                    $paypal_plan_id = null;
                    $packageName = $request->name ?? env('APP_NAME');
                    $packageDescription = 'custom' ?? env('APP_NAME');

                    if ($package->paypal_product_id) {
                        $product = $paypal->showProductDetails($package->paypal_product_id);
                        $paypal_plan_id = $product['id'] ?? null;
                    }
                    if (!$paypal_plan_id) {
                        $data = [
                            'name' => $packageName,
                            'type' => 'SERVICE',
                            'description' => $packageDescription,
                            'category' => 'SOFTWARE',
                        ];
                        $product = $paypal->createProduct($data);
                        $paypal_plan_id = $product ?? null;

                        $package->update(['paypal_product_id' => $paypal_plan_id]);
                    }
                    if ($paypal_plan_id && $package) {
                        if ($package->price > 0) {
                            $productId = $package->paypal_product_id;

                            $interval_count = 1;
                            $price = $package->price;

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

                            $plan = $paypal->create($data);

                            if ($package == null) {
                                $plan['id'] = null;
                            } else {
                                $package->update(['paypal_price_id' => $plan['id']]);
                            }
                        } else {
                            $package->update(['paypal_price_id' => null]);
                        }
                    }
                }

                $planId = $package->paypal_price_id;

                $interval_unit = null;
                $interval_count = 1;
                if ($request->frequency == 'weekly') {
                    $interval_unit = 'DAY';
                    $interval_count = 7; // Every 7 days
                } else if ($request->frequency == 'monthly') {
                    $interval_unit = 'MONTH';
                } else if ($request->frequency == 'quarterly') {
                    $interval_unit = 'MONTH';
                    $interval_count = 3;
                } else if ($request->frequency == 'semi_annually') {
                    $interval_unit = 'MONTH';
                    $interval_count = 6;
                } else if ($request->frequency == 'annually') {
                    $interval_unit = 'YEAR';
                }

                $data = [
                    'plan_id' => $planId, // Replace with your actual plan ID
                    'subscriber' => [
                        'name' => [
                            'given_name' => $request->name,
                            'surname' => '',
                        ],
                        'email_address' => $request->email,
                    ],
                    'application_context' => [
                'return_url' => route('paypal.subscription.success.coffee_wall', [
                            'name' => $request->name,
                            'email' => $request->email,
                            'package_id' => $package->id,
                            'phone' => $request->phone ?? null,
                            'anonymous' => $request->anonymous ?? null,
                            'frequency' => $request->frequency ?? null,
                            'beneficiary_ids' => $beneficiaryIds->implode(',')
                        ]),
                        'cancel_url' => route('paypal.cancel')
                    ],
                ];

                // Attach interval and count if applicable
                if ($interval_unit) {
                    $data['plan'] = [
                        'billing_cycles' => [
                            [
                                'frequency' => [
                                    'interval_unit' => $interval_unit,
                                    'interval_count' => $interval_count,
                                ],
                                'tenure_type' => 'REGULAR',
                                'sequence' => 1,
                                'total_cycles' => 0, // Ongoing subscription
                                'pricing_scheme' => [
                                    'fixed_price' => [
                                        'value' => $package_price,
                                        'currency_code' => 'USD',
                                    ],
                                ],
                            ],
                        ],
                    ];
                }

                $responseData = $paypal->subscription($data);
                
                Log::info('PayPal subscription response', [
                    'status' => $responseData['status'] ?? 'unknown',
                    'redirect_url' => $responseData['redirect_url'] ?? null
                ]);

                if ($responseData['status'] == 'Error') {
                    Log::error('PayPal subscription error', ['message' => $responseData['message']]);
                    return $this->errorResponse($responseData['message']);
                } else if ($responseData['status'] == 'Success') {
                    Log::info('PayPal subscription successful, redirecting user');
                    return $this->successResponse(
                        [
                            'type' => 'paypal',
                            'redirect_url' => $responseData['redirect_url'],
                        ],
                        'Success',
                    );
                }

                Log::error('PayPal subscription failed with unknown status');
                return $this->errorResponse();
            }
        Log::info('Creating CoffeeWallet record', [
            'name' => $request->name,
            'email' => $request->email,
            'package_id' => $package->id,
            'beneficiary_ids' => $beneficiaryIds->toArray(),
            'frequency' => $request->frequency,
            'dr_amount' => $package_price,
            'payment_method' => $package_price > 0 ? $request->payment_method : null,
        ]);

            $coffee_wallet = CoffeeWallet::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'anonymous' => $request->anonymous ? $request->anonymous : 0,
                'notify_when_used' => $request->notify_when_used ? $request->notify_when_used : 0,
                'package_id' => $package->id,
            'beneficiary_id' => $beneficiaryIds->first(),
                'frequency' => $request->frequency ? $request->frequency : null,
                'dr_amount' => $package_price,
                'paypal_id' => null,
                'stripe_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                'subscription_id' => $request->payment_method == 'stripe' && $package_price > 0 ? $subscription_id : null,
                'payment_method' => $package_price > 0 ? $request->payment_method : null,
                'status' => 'completed',
            ]);

        if ($beneficiaryIds->isNotEmpty()) {
            $coffee_wallet->beneficiaries()->sync($beneficiaryIds->all());
        }

            Log::info('CoffeeWallet created successfully', [
                'coffee_wallet_id' => $coffee_wallet->id,
                'dr_amount' => $coffee_wallet->dr_amount
            ]);

            $data['coffee_wallet'] = $coffee_wallet;
            
            Log::info('===== Coffee on Wall Form Submission Completed Successfully =====');
            
            return $this->successResponse($data, isset($coffee_wall_setting['coffee_on_wall_success_message']) ? $coffee_wall_setting['coffee_on_wall_success_message'] : 'Thank you for your generosity. Please accept our best wishes');
        } catch (\Exception $e) {
            Log::error('===== Coffee on Wall Form Submission Failed =====');
            Log::error('Exception occurred:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse($e->getMessage());
        }
    }

    // function checkPageSlug($slug)
    // {
    //     $general_setting = getGeneralSettingByKey();
    //     $lang = getDefaultLanguage(true);
    //     $currentUrl = langBasedURL($lang, Request::url());

    //     $user_event_create_page = isset($general_setting['user_event_create_page']) ? langBasedURL($lang, url($general_setting['user_event_create_page'])) : null;
    //     $user_event_listing_page = isset($general_setting['user_event_listing_page']) ? langBasedURL($lang, url($general_setting['user_event_listing_page'])) : null;

    //     if (!Auth::guard('customers')->check()) {
    //         if (isset($user_event_create_page) && ($user_event_create_page == $currentUrl || $user_event_listing_page == $currentUrl)) {
    //             $url = langBasedURL($lang, route('front.index', $general_setting['user_event_signup_page']));
    //             return $url;
    //         }
    //     } else if (Auth::guard('customers')->check()) {
    //         $customerType = Auth::guard('customers')->user()->type;
    //         $customer = Auth::guard('customers')->user();
    //         if ($customer->is_package_amount_paid == '0') {
    //             $defaultLang = getDefaultLanguage(1);
    //             $url = route('user.payment.index', [$defaultLang->abbreviation]);
    //             return $url;
    //         } else if ($customerType == 'customer') {
    //             if (isset($general_setting['user_signin_page'], $general_setting['user_signup_page']) && ($general_setting['user_signin_page'] == $slug || $general_setting['user_signup_page'] == $slug)) {
    //                 $url = langBasedURL($lang, route('user.profile-settings.index'));
    //                 return $url;
    //                 // return redirect()->route('user.profile-settings.index');
    //             }
    //         } else if ($customerType == 'event') {
    //             if (isset($general_setting['user_signin_page'], $general_setting['user_signup_page']) && ($general_setting['user_signin_page'] == $slug || $general_setting['user_signup_page'] == $slug)) {
    //                 $url = isset($general_setting['user_event_listing_page']) ? url($general_setting['user_event_listing_page']) : '#';
    //                 $url = langBasedURL($lang, $url);
    //                 return $url;
    //                 // return Redirect::to($general_setting['user_event_listing_page']);
    //             }
    //         }
    //     }
    //     return null;
    // }
    function checkPageSlug($slug)
    {
        $general_setting = getGeneralSettingByKey();
        $lang = getDefaultLanguage(true);
        $currentUrl = langBasedURL($lang, Request::url());

        $user_event_create_page = isset($general_setting['user_event_create_page']) ? langBasedURL($lang, url($general_setting['user_event_create_page'])) : null;
        $user_event_listing_page = isset($general_setting['user_event_listing_page']) ? langBasedURL($lang, url($general_setting['user_event_listing_page'])) : null;
        $user_sponser_listing_page = isset($general_setting['user_sponser_listing_page']) ? langBasedURL($lang, url($general_setting['user_sponser_listing_page'])) : null;

        if (!Auth::guard('customers')->check()) {
            if (isset($user_event_create_page) && ($user_event_create_page == $currentUrl || $user_event_listing_page == $currentUrl|| $user_sponser_listing_page == $currentUrl)) {
                $url = langBasedURL($lang, route('front.index', $general_setting['user_event_signup_page']));
                return $url;
            }
        } else if (Auth::guard('customers')->check()) {
            $customerType = Auth::guard('customers')->user()->type;
            $customer = Auth::guard('customers')->user();

            // List of restricted pages
            $restrictedPages = [
                $general_setting['user_signin_page'],
                $general_setting['user_signup_page'],
                // Add more restricted pages here
            ];

            if ($customer->is_package_amount_paid == '0' && in_array($slug, $restrictedPages)) {
                $defaultLang = getDefaultLanguage(1);
                $url = route('user.payment.index', [$defaultLang->abbreviation]);
                return $url;
            } else if ($customerType == 'customer') {
                if (isset($general_setting['user_signin_page'], $general_setting['user_signup_page']) && ($general_setting['user_signin_page'] == $slug || $general_setting['user_signup_page'] == $slug)) {
                    $url = langBasedURL($lang, route('user.profile-settings.index'));
                    return $url;
                }
                if (isset($general_setting['user_signin_page'], $general_setting['user_signup_page']) && ($general_setting['user_signin_page'] == $slug || $general_setting['user_signup_page'] == $slug)) {
                    $url = isset($general_setting['user_sponser_listing_page']) ? url($general_setting['user_sponser_listing_page']) : '#';
                    $url = langBasedURL($lang, $url);
                    return $url;
                }
            } else if ($customerType == 'event') {
                if (isset($general_setting['user_signin_page'], $general_setting['user_signup_page']) && ($general_setting['user_signin_page'] == $slug || $general_setting['user_signup_page'] == $slug)) {
                    $url = isset($general_setting['user_event_listing_page']) ? url($general_setting['user_event_listing_page']) : '#';
                    $url = langBasedURL($lang, $url);
                    return $url;
                }
            }
        }
        return null;
    }


    public function businessDirectorySearch(Req $request)
    {
        $businessDirectories = BusinessDirectory::query();
        if (isset($request->keyword) && !empty($request->keyword)) {
            $name = $request->keyword;
            $businessDirectories->whereHas('businessDirectoryDetail', function ($q) use ($name) {
                $q->where('name', 'LIKE', '%' . $name . '%');
            });
        }

        if (isset($request->city) && !empty($request->city)) {
            $businessDirectories->whereCity($request->city);
        }

        if (isset($request->province) && !empty($request->province)) {
            $businessDirectories->whereProvince($request->province);
        }

        if (isset($request->industry) && !empty($request->industry)) {
            $arrayResult = explode(',', $request->industry);

            $businessDirectories->whereIn('Industry', $arrayResult);
        }
        $defaultLang = getDefaultLanguage(1);
        $businessDirectories = $businessDirectories->with([
            'businessDirectoryDetail' => function ($q) use ($defaultLang) {
                $q = $q->where('language_id', $defaultLang->id);
            },
        ]);
        $businessDirectories = $businessDirectories
            ->addSelect([
                'name_order' => BusinessDirectoryDetail::whereColumn('business_directory_id', 'business_directories.id')
                    ->where('language_id', $defaultLang->id)
                    ->limit(1)
                    ->select('name'),
            ])
            ->orderBy('name_order')
            ->paginate(10);
        // $businessDirectorySearchTranslations = getStaticTranslation('business_directory_search');

        $lang = getDefaultLanguage(true);
        if (isset($slug)) {
            $page = getPageBySlug($slug, $lang);
        } else {
            $page = getFrontPage();
        }
        if (!$page) {
            abort(404);
        }


        // {!! $businessDirectories->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        $businessDirectorySearchTranslations = getStaticTranslationByKey($lang, 'online_business_directory_search', ['fax_label_text','address_label_text','phone_label_text','postal_code_label_text','industry_label_text','city_label_text','province_label_text','name_label_text','page_title']);
        return view('front.pages.online-business-directory-template.business-directory-search', compact('businessDirectories','businessDirectorySearchTranslations'));
    }
}
