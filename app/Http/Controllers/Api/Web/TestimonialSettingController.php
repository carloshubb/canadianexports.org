<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AutoResponseToCustomerMail;
use App\Mail\TestimonialMail;
use App\Models\Testimonial;
use App\Models\TestimonialDetail;
use App\Services\EmailSettingService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use App\Models\Customer;

class TestimonialSettingController extends Controller
{
    use StatusResponser;

    public function getCustomerDetails(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $customer = Customer::with('customerProfile', 'customerBusinessCategory.businessCategory.businessCategoryDetail')
            ->where('email', $request->email)
            ->first();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email. No user found.',
            ], 404);
        }

        // Check if the account is closed
        if ($customer->is_account_closed == '1') {
            // Fetch the dynamic message for closed accounts
            $defaultLang = getDefaultLanguage(1);
            $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_43']);
            $message_43 = $general_messages['message_43'] ?? 'This account is closed. Please contact support.';

            return response()->json([
                'status' => 'error',
                'message' => $message_43,
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'customer' => $customer,
        ]);
    }

    public function sendMessage(Request $request)
{
    $defaultLang = getDefaultLanguage(1);
    $niceNames = [];
    if ($defaultLang) {
        App::setLocale($defaultLang->abbreviation);
        $setting = getTestimonialPageSetting($defaultLang, $request->page_id);
        $niceNames = [
            'name' => $setting->testimonialSettingDetail[0]->name_error ?? '',
            'company_name' => $setting->testimonialSettingDetail[0]->company_name_error ?? '',
            'business_categories' => $setting->testimonialSettingDetail[0]->business_categories_error ?? '',
            'email' => $setting->testimonialSettingDetail[0]->email_error ?? '',
            'message' => $setting->testimonialSettingDetail[0]->message_error ?? '',
        ];
    }

    // Validate the request data
    $data = $this->validate($request, [
        "name" => "required",
        "company_name" => "required",
        "business_categories" => "required|array",
        "email" => "required|email",
        "message" => "required",
    ], [], $niceNames);

    // Check if the customer exists
    $customer = Customer::where('email', $request->email)->first();
    if (!$customer) {
        // Fetch the dynamic message for "no user found"
        $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_61']);
        $message_61 = $general_messages['message_61'];

        return response()->json([
            'status' => 'error',
            'message' => $message_61,
        ], 404);
    }

    // Check if the account is closed
    if ($customer->is_account_closed == '1') {
        $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_43']);
        $message_43 = $general_messages['message_43'] ?? 'This account is closed. Please contact support.';

        return response()->json([
            'status' => 'error',
            'message' => $message_43,
        ], 403);
    }

    // Save the testimonial to the database
    $testimonial = Testimonial::create([
        'business_category_id' => null, // Update this if you have a business category ID
    ]);

    // Save the testimonial details
    TestimonialDetail::create([
        'testimonial_id' => $testimonial->id,
        'language_id' => $defaultLang->id, // Use the default language ID
        'name' => $data['name'],
        'place' => $data['company_name'], // Assuming 'place' is the company name
        'comment' => $data['message'],
        'email' => $data['email'],
        'primary_industry' => json_encode($data['business_categories']), // Store as JSON
    ]);

    // Convert business_categories array to a string
    $businessCategories = array_map(function($cat) {
        return $cat['category_name'];
    }, $request->business_categories);

    $data['business_category'] = implode(', ', $businessCategories); // This is now a string

    // Initialize email service
    $emailService = new EmailSettingService();
    $result = $emailService->canadianExportersForm();
    if ($result['status'] == 'Error') {
        return $result;
    }

    // Get admin emails from general settings
    $general_setting = getGeneralSettingByKey();
    if (isset($general_setting['admin_email'])) {
        $adminEmailsArr = explode(',', $general_setting['admin_email']);
    }

    // Send email to admin(s)
    if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
        $to_email = $adminEmailsArr[0];
        unset($adminEmailsArr[0]);
        Mail::to($to_email)->cc($adminEmailsArr)->send(new TestimonialMail($data));
    } else {
        $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
        if ($to_email) {
            Mail::to($to_email)->send(new TestimonialMail($data));
        }
    }

    // Send auto-response to the customer
    Mail::to($request->email)->send(new AutoResponseToCustomerMail([]));

    // Get success message from translations
    $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_59']);
    $message_59 = $general_messages['message_59'] ?? '';

    return $this->successResponse([], $message_59);
}
}