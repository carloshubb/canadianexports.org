<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CustomerResource;
use App\Mail\CustomerWelcomeMail;
use App\Mail\CustomerResetPasswordMail;
use App\Models\Customer;
use App\Models\Event;
use App\Traits\StatusResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $customers = Customer::query();

        $customers = $this->whereClause($customers);
        $customers = $this->sortingAndLimit($customers);

        return $this->apiSuccessResponse(CustomerResource::collection($customers), 'Data Get Successfully!');
    }


    public function show($customerId)
    {
        $customer = Customer::whereId($customerId);
        $defaultLang = getDefaultLanguage();
        if (isset($_GET['getRegistrationPackage']) && $_GET['getRegistrationPackage'] == '1') {
            $customer = $customer->with('registrationPackage');
            $customer = $customer->with(['registrationPackage.registrationPackageDetail' => function ($q) use ($defaultLang) {
                $q->whereLanguageId($defaultLang->id);
            }]);
        }
        if (isset($_GET['getCustomerBusinessCategory']) && $_GET['getCustomerBusinessCategory'] == '1') {
            $customer = $customer->with('customerBusinessCategory');
            $customer = $customer->with(['customerBusinessCategory.businessCategory.businessCategoryDetail' => function ($q) use ($defaultLang) {
                $q->whereLanguageId($defaultLang->id);
            }]);
        }
        if (isset($_GET['getCustomerMedia']) && $_GET['getCustomerMedia'] == '1') {
            $customer = $customer->with(['customerMedia', 'customerMedia.customerGalleryImages.media']);
        }
        if (isset($_GET['getCustomerProfile']) && $_GET['getCustomerProfile'] == '1') {
            $customer = $customer->with('customerProfile');
        }
        if (isset($_GET['getCustomerSocialMedia']) && $_GET['getCustomerSocialMedia'] == '1') {
            $customer = $customer->with('customerSocialMedia');
        }
        $customer = $customer->firstOrFail();
        return $this->apiSuccessResponse(new CustomerResource($customer), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\Customer,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
            'package_id' => ['required', 'exists:App\Models\RegistrationPackage,id'],
            'payment_frequency' => ['required', 'in:monthly,quarterly,semi_annually,annually'],
        ];
        $this->validate(
            $request,
            $validationRule
        );

        $package = getRegistrationPackage($request->package_id ?? null);

        $eventsAllowed = 0;
        $packagePrice = 0;
        if ($request->payment_frequency == 'monthly') {
            $packagePrice = $package->monthly_price;
            $eventsAllowed = $package->events_allowed;
            $package_validity = date('Y-m-d', strtotime('+1 months'));
        } else if ($request->payment_frequency == 'quarterly') {
            $eventsAllowed = $package->events_allowed * 3;
            $packagePrice = $package->quarterly_price;
            $package_validity = date('Y-m-d', strtotime('+3 months'));
        } else if ($request->payment_frequency == 'semi_annually') {
            $eventsAllowed = $package->events_allowed * 6;
            $packagePrice = $package->semi_annually_price;
            $package_validity = date('Y-m-d', strtotime('+6 months'));
        } else if ($request->payment_frequency == 'annually') {
            $eventsAllowed = $package->events_allowed * 12;
            $packagePrice = $package->annually_price;
            $package_validity = date('Y-m-d', strtotime('+12 months'));
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => 1,
            'verify_customer_email' => 1,
            'password' => Hash::make($request->password),
            'type' => 'customer',
            'registration_package_id' => isset($package) ? $package->id : null,
            'is_package_amount_paid' => 1,
            'package_price' => $packagePrice,
            // 'free_subscription_days' => isset($package) ? $package->free_subscription_days : 0,
            'package_subscribed_date' => date('Y-m-d'),
            'package_expiry_date' => $package_validity,
            'events_allowed' => $eventsAllowed,
            'events_remaining' => $eventsAllowed,
            // 'i2b_allowed' => isset($package) ? $package->events_allowed : 0,
            // 'i2b_remaining' => isset($package) ? $package->events_allowed : 0,
            'images_allowed' => isset($package) ? $package->images_allowed : 0,
        ]);



        if ($customer) {
            return $this->apiSuccessResponse(new CustomerResource($customer), 'User account has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Customer $customer)
    {
        $validationRule = [
            'id' => ['required', 'exists:App\Models\Customer,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\Customer,email,' . $request->id],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
            'package_id' => ['required', 'exists:App\Models\RegistrationPackage,id'],
            'payment_frequency' => ['required', 'in:monthly,quarterly,semi_annually,annually'],
        ];
        $this->validate(
            $request,
            $validationRule
        );

        if ($request->package_id == $customer->registration_package_id) {
            $result = Customer::whereId($request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if ($request->payment_frequency != $customer->payment_frequency) {
                $package = getRegistrationPackage($request->package_id ?? null);

                $eventsAllowed = 0;
                if ($request->payment_frequency == 'monthly') {
                    $packagePrice = $package->monthly_price;
                    $eventsAllowed = $package->events_allowed;
                    $package_validity = date('Y-m-d', strtotime('+1 months'));
                } else if ($request->payment_frequency == 'quarterly') {
                    $eventsAllowed = $package->events_allowed * 3;
                    $packagePrice = $package->quarterly_price;
                    $package_validity = date('Y-m-d', strtotime('+3 months'));
                } else if ($request->payment_frequency == 'semi_annually') {
                    $eventsAllowed = $package->events_allowed * 6;
                    $packagePrice = $package->semi_annually_price;
                    $package_validity = date('Y-m-d', strtotime('+6 months'));
                } else if ($request->payment_frequency == 'annually') {
                    $eventsAllowed = $package->events_allowed * 12;
                    $packagePrice = $package->annually_price;
                    $package_validity = date('Y-m-d', strtotime('+12 months'));
                }

                $result = Customer::whereId($request->id)->update([
                    'package_subscribed_date' => date('Y-m-d'),
                    'package_expiry_date' => $package_validity,
                    'events_allowed' => $eventsAllowed,
                    'events_remaining' => $eventsAllowed,
                    'images_allowed' => isset($package) ? $package->images_allowed : 0,
                ]);
            }
        } else {
            $package = getRegistrationPackage($request->package_id ?? null);

            $eventsAllowed = 0;
            $packagePrice = 0;
            if ($request->payment_frequency == 'monthly') {
                $packagePrice = $package->monthly_price;
                $eventsAllowed = $package->events_allowed;
                $package_validity = date('Y-m-d', strtotime('+1 months'));
            } else if ($request->payment_frequency == 'quarterly') {
                $eventsAllowed = $package->events_allowed * 3;
                $packagePrice = $package->quarterly_price;
                $package_validity = date('Y-m-d', strtotime('+3 months'));
            } else if ($request->payment_frequency == 'semi_annually') {
                $eventsAllowed = $package->events_allowed * 6;
                $packagePrice = $package->semi_annually_price;
                $package_validity = date('Y-m-d', strtotime('+6 months'));
            } else if ($request->payment_frequency == 'annually') {
                $eventsAllowed = $package->events_allowed * 12;
                $packagePrice = $package->annually_price;
                $package_validity = date('Y-m-d', strtotime('+12 months'));
            }

            $result = Customer::whereId($request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'payment_frequency' => $request->payment_frequency,
                'is_active' => 1,
                'verify_customer_email' => 1,
                'password' => Hash::make($request->password),
                'type' => 'customer',
                'registration_package_id' => isset($package) ? $package->id : null,
                'is_package_amount_paid' => 1,
                'package_price' => $packagePrice,
                // 'free_subscription_days' => isset($package) ? $package->free_subscription_days : 0,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_validity,
                'events_allowed' => $eventsAllowed,
                'events_remaining' => $eventsAllowed,
                // 'i2b_allowed' => isset($package) ? $package->events_allowed : 0,
                // 'i2b_remaining' => isset($package) ? $package->events_allowed : 0,
                'images_allowed' => isset($package) ? $package->images_allowed : 0,
            ]);
        }

        if ($result) {
            return $this->apiSuccessResponse(new CustomerResource($customer), 'User account has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, $customerId)
    {
        $customer = Customer::whereId($customerId)->firstOrFail();
        if (isset($customer->customerMedia)) {
            $customer->customerMedia()->delete();
        }
        if (isset($customer->customerProfile)) {
            $customer->customerProfile()->delete();
        }
        if (isset($customer->customerSocialMedia)) {
            $customer->customerSocialMedia()->delete();
        }
        Event::whereCustomerId($customerId)->delete();
        if ($customer->delete()) {
            return $this->apiSuccessResponse(new CustomerResource($customer), 'User account has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function sortingAndLimit($customers)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $customers->orderBy('name', 'asc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'email'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $customers = $customers->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $customers->paginate($limit);
    }

    protected function whereClause($customers)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $customers = $customers->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $customers;
    }

    public function updateActivationStatus(Request $request)
    {
        $validationRule = [
            'user_id' => ['required', 'exists:customers,id'],
            'status' => ['required', 'boolean'],
        ];
        $this->validate(
            $request,
            $validationRule
        );

        $customer = Customer::whereId($request->user_id)->update([
            'is_active' => $request->status,
            'active_email_url' => null
        ]);

        if ($customer) {
            return $this->successResponse([], 'Customer status has been updated successfully.');
        }
        return $this->errorResponse();
    }

    function usersWithNoProfile()
    {
        $customers = Customer::select('id', 'name')->doesntHave('customerProfile')->get();

        return $this->successResponse($customers, 'Customers get successfully.');
    }

    function sendWelcomeEmail(Request $request)
    {
        $validationRule = [
            'id' => ['required', 'exists:App\Models\Customer,id'],
        ];
        $this->validate(
            $request,
            $validationRule
        );

        $customer = Customer::whereId($request->id)->firstOrFail();

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $customer->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $defaultLang = getDefaultLanguage(1);


        $data = ['token' => $token, 'lang' => $defaultLang, 'email' => $customer->email, 'name' => $customer->name, 'reset_password' => 1];

        Mail::to($customer->email)->send(new CustomerResetPasswordMail($data));

        return $this->successResponse([], 'Password reset email has been sent successfully.');
    }
}
