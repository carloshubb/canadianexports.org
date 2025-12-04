<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Jobs\SendInquiryMailJob;
use App\Mail\InquiryMail;
use App\Models\Customer;
use App\Models\CustomerInquiry;
use App\Models\I2b;
use App\Models\Order;
use App\Services\EmailSettingService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use LVR\CreditCard\CardNumber;

class InquiryController extends Controller
{
    use StatusResponser;

    public function savePremiumInquiry(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            // $setting = getI2bModalSetting($defaultLang, ['i2b_modal']);
            // $niceNames['company_name'] = isset($setting['i2b_company_error']) ? $setting['i2b_company_error'] : '';
            // $niceNames['company_email'] = isset($setting['i2b_email_error']) ? $setting['i2b_email_error'] : '';
            // $niceNames['inquiry_detail'] = isset($setting['i2b_inquiry_error']) ? $setting['i2b_inquiry_error'] : '';
            // $niceNames['customer_payment_method_id'] = 'card';
            // $niceNames['package_id'] = 'package';
        }
        $validationRule = [
            'inquiry_id' => ['required', 'exists:i2b,id'],
            // 'company_name' => ['required'],
            // 'company_email' => ['required', 'email'],
            // 'inquiry_detail' => ['required'],
        ];
        if (!Auth::guard('customers')->check()) {
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_4']);
            $message_4 = isset($general_messages['message_4']) ? $general_messages['message_4'] : '';

            return $this->errorResponse($message_4);
        }

        // if (Auth::guard('customers')->user()->is_package_amount_paid == '0' && Auth::guard('customers')->user()->package_price > 0) {
        //     $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_5']);
        //     $message_5 = isset($general_messages['message_5']) ? $general_messages['message_5'] : '';

        //     return $this->errorResponse($message_5);
        // }
        if (Auth::guard('customers')->user()->is_package_amount_paid == '0' && Auth::guard('customers')->user()->package_price > 0) {
            return $this->errorResponse(); // Return an error response without a message
        }

        $emailService = new EmailSettingService();
        $result = $emailService->advertiserForm('advertiser');
        if ($result['status'] == 'Error') {
            return $result;
        }



        // if (Auth::guard('customers')->user()->i2b_remaining <= 0 || Auth::guard('customers')->user()->package_expiry_date < date('Y-m-d') || Auth::guard('customers')->user()->package_expiry_date == null) {
        //     $validationRule = array_merge($validationRule, [
        //         'package_id' => ['required', 'exists:App\Models\RegistrationPackage,id'],
        //         'payment_method' => ['required', 'in:stripe,paypal'],
        //     ]);
        //     if (isset($request->payment_method) && $request->payment_method == 'stripe') {
        //         $validationRule = array_merge($validationRule, [
        //             'customer_payment_method_id' => ['required'],
        //             'card_holder_name' => ['nullable', 'required_if:customer_payment_method_id,add_new_card'],
        //             'card_no' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', new CardNumber],
        //             'expiry_month' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'min:01', 'max:12'],
        //             'expiry_year' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'digits:4'],
        //             'cvc' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'min:3', 'max:4'],
        //         ]);

        //         $payment_setting = getI2bModalSetting($defaultLang, ['payment_setting']);

        //         $niceNames['card_holder_name'] = isset($payment_setting['cardholder_name_error']) ? $payment_setting['cardholder_name_error'] : '';
        //         $niceNames['card_no'] = isset($payment_setting['card_number_error']) ? $payment_setting['card_number_error'] : '';
        //         $niceNames['expiry_month'] = isset($payment_setting['expiry_month_error']) ? $payment_setting['expiry_month_error'] : '';
        //         $niceNames['expiry_year'] = isset($payment_setting['expiry_year_error']) ? $payment_setting['expiry_year_error'] : '';
        //         $niceNames['cvc'] = isset($payment_setting['cvv_error']) ? $payment_setting['cvv_error'] : '';
        //     }
        // }
        $data = $this->validate($request, $validationRule, [], $niceNames);

        $general_setting = getGeneralSettingByKey();
        if (isset($general_setting['admin_email'])) {
            $adminEmailsArr = explode(',', $general_setting['admin_email']);
        }
        $package = getRegistrationPackage($request->package_id);

        // if (isset($request->payment_method) && $request->payment_method == 'stripe' && Auth::guard('customers')->user()->i2b_remaining <= 0) {
        //     try {
        //         $stripeService = new StripeService();
        //         $stripeResponse = $stripeService->i2bPackagePayAsGo($request, Auth::guard('customers')->user(), $package);

        //         $subscription_id = $stripeResponse['subscription_id'];
        //         $stripe_item_id = $stripeResponse['stripe_item_id'];

        //         Order::create([
        //             'registration_package_id' => $package->id,
        //             'customer_id' => auth()->guard('customers')->user()->id,
        //             'type' => 'i2b',
        //             'payment_method' => $request->payment_method,
        //             'transaction_id' => isset($subscription_id) ? $subscription_id : null,
        //             'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
        //             'amount' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : $package->price,
        //         ]);
        //     } catch (\Exception $e) {
        //         return $this->errorResponse($e->getMessage());
        //     }
        // }
        $inquiry = getInquiryById($request->inquiry_id);
        $user = Auth::guard('customers')->user();
        $user = $user->loadMissing('customerProfile');


        $customerInquiry = CustomerInquiry::create([
            'i2b_id' => $request->inquiry_id,
            'registration_package_id' => $request->package_id,
            'customer_id' => Auth::guard('customers')->user()->id,
            'company_name' => isset($user->customerProfile->company_name) ? $user->customerProfile->company_name : null,
            'company_email' => isset($user->customerProfile->company_email) ? $user->customerProfile->company_email : null,
            'inquiry_detail' => isset($inquiry->i2bDetail[0]) ? $inquiry->i2bDetail[0]->name : null,
        ]);

        $data['name'] = $user->name;
        $data['company_name'] = isset($user->customerProfile->company_name) ? $user->customerProfile->company_name : null;
        $data['company_email'] = isset($user->customerProfile->company_email) ? $user->customerProfile->company_email : null;
        $data['inquiry_detail'] = isset($inquiry->i2bDetail[0]) ? $inquiry->i2bDetail[0]->name : null;



        // if (isset($request->payment_method) && $request->payment_method == 'paypal' && Auth::guard('customers')->user()->i2b_remaining <= 0) {
        //     $customerInquiry->delete();
        //     $user = Auth::guard('customers')->user();
        //     $paypalService = new PaypalService();
        //     $paypalResponse = $paypalService->createSubscription($request, $user, $package, 'customer_i2b_inquiry');

        //     Customer::whereId($user->id)->update([
        //         'temp_registration_package_id' => $customerInquiry->id,
        //     ]);

        //     if ($paypalResponse['status'] == 'Error') {
        //         return $this->errorResponse($paypalResponse['message']);
        //     } else if ($paypalResponse['status'] == 'Success') {
        //         $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_19']);
        //         $message_19 = isset($general_messages['message_19']) ? $general_messages['message_19'] : '';

        //         return $this->successResponse(
        //             [
        //                 'type' => 'paypal',
        //                 'redirect_url' => $paypalResponse['redirect_url'],
        //             ],
        //             $message_19,
        //         );
        //     }
        //     return $this->errorResponse();
        // }

        // $i2b = I2b::whereId($request->inquiry_id)->first();


        // purana mail ka code
        // $to_email = isset($user->email) ? $user->email : null;
        // if (isset($to_email)) {
        //     Mail::to($to_email)->cc($adminEmailsArr)->send(new InquiryMail($data));
        // } else {
        //     if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
        //         $to_email = $adminEmailsArr[0];
        //         unset($adminEmailsArr[0]);
        //         Mail::to($to_email)->cc($adminEmailsArr)->send(new InquiryMail($data));
        //     } else {
        //         $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
        //         if ($to_email) {
        //             Mail::to($to_email)->send(new InquiryMail($data));
        //         }
        //     }
        // }

        //job mail
        $to_email = isset($user->email) ? $user->email : null;

if (isset($to_email)) {
    SendInquiryMailJob::dispatch($data, $to_email, $adminEmailsArr);
} else {
    if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
        $to_email = $adminEmailsArr[0];
        unset($adminEmailsArr[0]);
        SendInquiryMailJob::dispatch($data, $to_email, $adminEmailsArr);
    } else {
        $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
        if ($to_email) {
            SendInquiryMailJob::dispatch($data, $to_email, []);
        }
    }
}



        // Customer::whereId(Auth::guard('customers')->user()->id)->update([
        //     'i2b_remaining' => Auth::guard('customers')->user()->i2b_remaining - 1
        // ]);

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_22']);
        $message_22 = isset($general_messages['message_22']) ? $general_messages['message_22'] : '';

        return $this->successResponse([], $message_22);
    }

    public function savePackageInquiry(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $setting = getI2bModalSetting($defaultLang, ['i2b_modal']);
            $niceNames['company_name'] = isset($setting['i2b_company_error']) ? $setting['i2b_company_error'] : '';
            $niceNames['company_email'] = isset($setting['i2b_email_error']) ? $setting['i2b_email_error'] : '';
            $niceNames['inquiry_detail'] = isset($setting['i2b_inquiry_error']) ? $setting['i2b_inquiry_error'] : '';
        }

        $validationRule = [
            'company_name' => ['required'],
            'company_email' => ['required', 'email'],
            'inquiry_detail' => ['required'],
            'inquiry_id' => ['required', 'exists:i2b,id'],
            'package_id' => ['required', 'exists:registration_packages,id'],
        ];
        $data = $this->validate($request, $validationRule, [], $niceNames);

        if (!Auth::guard('customers')->check()) {
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_4']);
            $message_4 = isset($general_messages['message_4']) ? $general_messages['message_4'] : '';

            return $this->errorResponse($message_4);
        }

        $customerInquiry = CustomerInquiry::create([
            'i2b_id' => $request->inquiry_id,
            'registration_package_id' => $request->package_id,
            'customer_id' => Auth::guard('customers')->user()->id,
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'inquiry_detail' => $request->inquiry_detail,
        ]);

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_22']);
        $message_22 = isset($general_messages['message_22']) ? $general_messages['message_22'] : '';

        return $this->successResponse($customerInquiry, $message_22);
    }
}
