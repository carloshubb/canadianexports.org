<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\CoffeeWallPackageResource;
use App\Models\CoffeeWallPackage;
use App\Models\CoffeeWallPackageDetail;
use App\Models\Language;
use App\Services\PaypalService;
use App\Traits\StatusResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;

class CoffeeWallPackageController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $registrationPackages = CoffeeWallPackage::query();

        $registrationPackages = $this->whereClause($registrationPackages);
        $registrationPackages = $this->loadRelations($registrationPackages);
        $registrationPackages = $this->sortingAndLimit($registrationPackages);

        return $this->apiSuccessResponse(CoffeeWallPackageResource::collection($registrationPackages), 'Data Get Successfully!');
    }

    public function show($id)
    {
        $registrationPackage = CoffeeWallPackage::with('coffeeWallPackageDetail')->find($id);

        if (isset($_GET['withRegistrationPackageDetail']) && $_GET['withRegistrationPackageDetail'] == '1') {
            $registrationPackage = $registrationPackage->loadMissing('coffeeWallPackageDetail');
        }

        return $this->apiSuccessResponse(new CoffeeWallPackageResource($registrationPackage), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == '1') {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->id => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required']);
                $validationRule = array_merge($validationRule, ['price' => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['price' . '.required' => 'Price is required']);
            }
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $isPackageExists = CoffeeWallPackage::where('price', $request->price)->exists();
        if ($isPackageExists) {
            return $this->errorResponse("Package has been already created.");
        }
        
        DB::beginTransaction();
        try {
            $is_default = 0;
            if ($request->is_default == true) {
                $packages = CoffeeWallPackage::get();
                foreach ($packages as $package) {
                    $package->update([
                        'is_default' => 0,
                    ]);
                }
                $is_default = 1;
            }

            $package = CoffeeWallPackage::create([
                'price' => $request->price ?? 0,
                'is_default' => $is_default,
            ]);

            foreach ($languages as $language) {
                $packageDetail = CoffeeWallPackageDetail::whereLanguageId($language->id)->wherePackageId($package['id'])->first();

                $packageData = [
                    'package_id' => $package['id'],
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                ];

                if ($packageDetail) {
                    $packageDetail->update($packageData);
                } else {
                    CoffeeWallPackageDetail::create($packageData);
                }
            }

            // GET package name
            $language = Language::whereIsDefault(1)->first();
            $packageDetail = CoffeeWallPackageDetail::wherePackageId($package->id);
            if ($language) {
                $packageDetail = $packageDetail->whereLanguageId($language->id);
            }
            $packageDetail = $packageDetail->first();
            $packageName = $packageDetail->name ?? env('APP_NAME');
            $packageDescription = $packageDetail->description ?? env('APP_NAME');

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

            return $this->apiSuccessResponse(new CoffeeWallPackageResource($package), 'Package has been added successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            $exceptionMessage = $e->getMessage() ?? null;
            if ($exceptionMessage) {
                return $this->errorResponse($e->getMessage());
            }
        }

        return $this->errorResponse();
    }

    public function update(Request $request, $id)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == '1') {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->id => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required']);
                $validationRule = array_merge($validationRule, ['price' => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['price' . '.required' => 'Price is required']);
            }
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $package = CoffeeWallPackage::with('coffeeWallPackageDetail')->find($id);
        
        $isPackageExists = CoffeeWallPackage::where('id', '!=', $package->id)->where('price', $request->price)->exists();
        if ($isPackageExists) {
            return $this->errorResponse("Package has been already created.");
        }
        
        $is_default = 0;
        if ($request->is_default == true) {
            $packages = CoffeeWallPackage::get();
            foreach ($packages as $pkg) {
                $pkg->update([
                    'is_default' => 0,
                ]);
            }
            $is_default = 1;
        }
        $package->update([
            'is_default' => $is_default,
        ]);

        foreach ($languages as $language) {
            $packageDetail = CoffeeWallPackageDetail::whereLanguageId($language->id)->wherePackageId($package->id)->first();

            $packageData = [
                'package_id' => $package->id,
                'language_id' => $language->id,
                'name' => $request['name']['name_' . $language->id] ?? null,
                'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
            ];

            if ($packageDetail) {
                $packageDetail->update($packageData);
            } else {
                CoffeeWallPackageDetail::create($packageData);
            }
        }

        // GET package name first (needed for both Stripe and PayPal)
        $language = Language::whereIsDefault(1)->first();
        $packageDetail = CoffeeWallPackageDetail::wherePackageId($package->id);
        if ($language) {
            $packageDetail = $packageDetail->whereLanguageId($language->id);
        }
        $packageDetail = $packageDetail->first();
        $packageName = $packageDetail->name ?? env('APP_NAME');
        $packageDescription = $packageDetail->description ?? env('APP_NAME');

        $old_price = $package->price;
        $new_price = $request->price;

        // Always run Stripe and PayPal updates in transaction
        DB::beginTransaction();
        try {
            // Update price if changed
            if ($old_price != $new_price) {
                $package->update([
                    'price' => $new_price ?? 0,
                ]);
            }

            // Handle Stripe - recreate if price changed or if stripe_product_id is missing
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            if ($old_price != $new_price || !$package->stripe_product_id) {
                if ($package->stripe_product_id) {
                    try {
                        $product = Product::retrieve($package->stripe_product_id);
                        $product->name = $packageName;
                        $product->save();
                    } catch (\Exception $e) {
                        // If Stripe product id is invalid, create new one
                        Log::warning('Stripe product not found, creating new one', ['error' => $e->getMessage()]);
                        $package->update(['stripe_product_id' => null]);
                        $product = Product::create([
                            'name' => $packageName,
                            'type' => 'service',
                        ]);
                        $package->update(['stripe_product_id' => $product->id]);
                    }
                } else {
                    $product = Product::create([
                        'name' => $packageName,
                        'type' => 'service',
                    ]);
                    $package->update(['stripe_product_id' => $product->id]);
                }

                if ($package->price > 0) {
                    $priceData = [
                        'product' => $product->id,
                        'unit_amount' => $package->price * 100,
                        'currency' => 'usd',
                        'recurring' => ['interval' => 'month', 'interval_count' => 1],
                    ];
        
                    $price = Price::create($priceData);
                    $package->update(['stripe_price_id' => $price->id ?? null]);
                }
            }

            // Handle PayPal - recreate if price changed OR if plan doesn't exist or is invalid
            if ($new_price > 0) {
                $paypalService = new PaypalService();
                
                // Check if we need to recreate PayPal plan
                $needsRecreation = false;
                
                // If paypal_price_id exists and is not empty
                if (isset($package->paypal_price_id) && !empty($package->paypal_price_id)) {
                    // Recreate if price changed
                    if ($old_price != $new_price) {
                        Log::info('PayPal plan recreation: price changed', [
                            'old_price' => $old_price,
                            'new_price' => $new_price
                        ]);
                        $needsRecreation = true;
                    }
                } else {
                    // If paypal_price_id doesn't exist or is empty, create it
                    Log::info('PayPal plan recreation: plan ID missing');
                    $needsRecreation = true;
                }
                
                if ($needsRecreation) {
                    Log::info('Creating new PayPal plan for Coffee Wall package', [
                        'package_id' => $package->id,
                        'price' => $package->price
                    ]);
                    
                    // Get or create PayPal product
                    $paypal_plan_id = null;
                    if ($package->paypal_product_id) {
                        try {
                            $product = $paypalService->showProductDetails($package->paypal_product_id);
                            $paypal_plan_id = $product['id'] ?? null;
                        } catch (\Exception $e) {
                            Log::warning('PayPal product not found, will create new one', ['error' => $e->getMessage()]);
                            $package->update(['paypal_product_id' => null]);
                        }
                    }
                    
                    if (!$paypal_plan_id) {
                        $data = [
                            'name' => $packageName,
                            'type' => 'SERVICE',
                            'description' => $packageDescription,
                            'category' => 'SOFTWARE',
                        ];
                        $product = $paypalService->createProduct($data);
                        $paypal_plan_id = $product ?? null;
                        $package->update(['paypal_product_id' => $paypal_plan_id]);
                    }
                    
                    // Create PayPal plan
                    if ($paypal_plan_id) {
                        $productId = $package->paypal_product_id;
                        $interval_count = 1;
                        $price = $package->price;

                        $billing_detail = [
                            [
                                'frequency' => [
                                    'interval_unit' => 'MONTH',
                                    'interval_count' => $interval_count,
                                ],
                                'tenure_type' => 'REGULAR',
                                'sequence' => 1,
                                'total_cycles' => 0,
                                'pricing_scheme' => [
                                    'fixed_price' => [
                                        'value' => $price,
                                        'currency_code' => 'USD',
                                    ],
                                ],
                            ]
                        ];

                        $data = [
                            'product_id' => $productId,
                            'name' => $packageName . ' for 1 month',
                            'description' => $packageName . ' for 1 month plan is auto renewal',
                            'status' => 'ACTIVE',
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

                        $plan = $paypalService->create($data);
                        
                        if ($plan && isset($plan['id'])) {
                            $package->update(['paypal_price_id' => $plan['id']]);
                            Log::info('PayPal plan created successfully', ['plan_id' => $plan['id']]);
                        } else {
                            Log::error('PayPal plan creation failed', ['response' => $plan]);
                        }
                    }
                }
            } else {
                // If price is 0, clear PayPal IDs
                $package->update(['paypal_price_id' => null]);
            }

            DB::commit();
            Log::info('Coffee Wall package updated successfully', ['package_id' => $package->id]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update Coffee Wall package', [
                'error' => $e->getMessage(),
                'package_id' => $package->id
            ]);
            $exceptionMessage = $e->getMessage() ?? null;
            if ($exceptionMessage) {
                return $this->errorResponse($e->getMessage());
            }
        }

        return $this->apiSuccessResponse(new CoffeeWallPackageResource($package), 'Package has been updated successfully.');
    }

    public function destroy($id)
    {
        // $customerExists = Customer::whereRegistrationPackageId($registrationPackage->id)->exists();
        // if ($customerExists) {
        //     return $this->errorResponse('Sorry, you can not delete this because its already used in customer.');
        // }
        $registrationPackage = CoffeeWallPackage::with('coffeeWallPackageDetail')->find($id);

        if ($registrationPackage->coffeeWallPackageDetail()->delete() && $registrationPackage->delete()) {
            return $this->apiSuccessResponse(new CoffeeWallPackageResource($registrationPackage), 'Package has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($registrationPackages)
    {
        $defaultLang = getDefaultLanguage(0);
        $registrationPackages = $registrationPackages->with(['coffeeWallPackageDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withCoffeeWallPackageDetail']) && $_GET['withCoffeeWallPackageDetail'] == '1') {
            $registrationPackages = $registrationPackages->with('coffeeWallPackageDetail');
        }
        return $registrationPackages;
    }

    protected function sortingAndLimit($registrationPackages)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'price', 'is_default', 'package_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $registrationPackages = $registrationPackages->addSelect(['package_name' => CoffeeWallPackageDetail::whereColumn('coffee_wall_packages.id', 'coffee_wall_package_details.package_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $registrationPackages = $registrationPackages->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $registrationPackages->get();
        }

        return $registrationPackages->paginate($limit);
    }

    protected function whereClause($registrationPackages)
    {
        $registrationPackages = $registrationPackages->where('custom', '0');
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $registrationPackages = $registrationPackages->whereHas('coffeeWallPackageDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $registrationPackages;
    }
}
