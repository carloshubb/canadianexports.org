<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AutoResponseToCustomerMail;
use App\Mail\SuccessStoriesMail;
use App\Models\SuccessStories;
use App\Models\SuccessStoriesDetail;
use App\Services\EmailSettingService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\CustomerBusinessCategory;

class SuccessStoriesSettingController extends Controller
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
            // Fetch dynamic message for "no user found"
            $defaultLang = getDefaultLanguage(1);
            $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_61']);
            $message_61 = $general_messages['message_61'] ?? 'No user found with this email.';

            return response()->json([
                'status' => 'error',
                'message' => $message_61,
            ], 404);
        }

        // Check if the account is closed
        if ($customer->is_account_closed == '1') {
            // Fetch dynamic message for closed accounts
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
            $setting = getSuccessStoriesPageSetting($defaultLang, $request->page_id);
            $niceNames = [
                'name' => $setting->successStoriesSettingDetail[0]->name_error ?? '',
                'company_name' => $setting->successStoriesSettingDetail[0]->company_name_error ?? '',
                'business_categories' => $setting->successStoriesSettingDetail[0]->business_categories_error ?? '',
                'email' => $setting->successStoriesSettingDetail[0]->email_error ?? '',
                'message' => $setting->successStoriesSettingDetail[0]->message_error ?? '',
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
            // Fetch dynamic message for "no user found"
            $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_61']);
            $message_61 = $general_messages['message_61'];

            return response()->json([
                'status' => 'error',
                'message' => $message_61,
            ], 404);
        }

        // Check if the account is closed
        if ($customer->is_account_closed == '1') {
            // Fetch dynamic message for closed accounts
            $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_43']);
            $message_43 = $general_messages['message_43'] ?? 'This account is closed. Please contact support.';

            return response()->json([
                'status' => 'error',
                'message' => $message_43,
            ], 403);
        }

        // Save the success story to the database
        $successStory = SuccessStories::create([
            'business_category_id' => null, // Update this if you have a business category ID
        ]);

        // Save the success story details
        SuccessStoriesDetail::create([
            'success_stories_id' => $successStory->id,
            'language_id' => $defaultLang->id, // Use the default language ID
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'company_name' => $data['company_name'],
            'primary_industry' => json_encode($data['business_categories']) // Store as JSON
        ]);

        // Convert business_categories array to a string
        $businessCategories = array_map(function($cat) {
            return $cat['category_name']; // Assuming each category has a 'category_name' key
        }, $request->business_categories);

        $data['business_category'] = implode(', ', $businessCategories); // Convert array to string

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
            Mail::to($to_email)->cc($adminEmailsArr)->send(new SuccessStoriesMail($data));
        } else {
            $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
            if ($to_email) {
                Mail::to($to_email)->send(new SuccessStoriesMail($data));
            }
        }

    // Send auto-response to the customer
    Mail::to($request->email)->send(new AutoResponseToCustomerMail([]));

        // Get success message from translations
        $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_58']);
        $message_58 = $general_messages['message_58'] ?? '';

        return $this->successResponse([], $message_58);
    }
}
