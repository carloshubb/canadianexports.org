<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AutoResponseToCustomerMail;
use App\Mail\FinancingProgramMail;
use App\Mail\FinancingProgramResponseMail;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryDetail;
use App\Models\FinancingProgram;
use App\Models\FinancingProgramDetail;
use App\Rules\MaxWordCount;
use App\Services\EmailSettingService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class FinancingProgramController extends Controller
{
    use StatusResponser;

    public function getBusinessCategories()
{
    // Get the default language ID
    $defaultLang = getDefaultLanguage(1);

    // Fetch business categories with the related name for the default language
    $categories = BusinessCategory::select('id')
        ->addSelect([
            'category_name' => BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')
                ->where('business_category_detail.language_id', $defaultLang->id)
                ->select('name')
                ->limit(1)  // Assuming each category has only one name in each language
        ])
        ->orderBy('category_name', 'asc')  // Order categories alphabetically
        ->get();

    // Return the fetched categories as a successful response
    return response()->json($categories);
}

public function sendMessage(Request $request)
{
    // Get the default language
    $defaultLang = getDefaultLanguage(1);
    $niceNames = [];

    // Set validation error messages based on the default language
    if ($defaultLang) {
        App::setLocale($defaultLang->abbreviation);
        $setting = getFinancingPageSetting($defaultLang, $request->page_id);
        $niceNames = [
            'name_title' => isset($setting->financingProgramSettingDetail[0]->name_title_error) ? $setting->financingProgramSettingDetail[0]->name_title_error : '',
            'email' => isset($setting->financingProgramSettingDetail[0]->email_error) ? $setting->financingProgramSettingDetail[0]->email_error : '',
            'business_name' => isset($setting->financingProgramSettingDetail[0]->business_name_error) ? $setting->financingProgramSettingDetail[0]->business_name_error : '',
            'zipcode' => isset($setting->financingProgramSettingDetail[0]->zipcode_error) ? $setting->financingProgramSettingDetail[0]->zipcode_error : '',
            'incorporation' => isset($setting->financingProgramSettingDetail[0]->incorporation_error) ? $setting->financingProgramSettingDetail[0]->incorporation_error : '',
            'full_time_employees' => isset($setting->financingProgramSettingDetail[0]->full_time_employees_error) ? $setting->financingProgramSettingDetail[0]->full_time_employees_error : '',
            'revenue_last_year' => isset($setting->financingProgramSettingDetail[0]->revenue_last_year_error) ? $setting->financingProgramSettingDetail[0]->revenue_last_year_error : '',
            'company_ownership' => isset($setting->financingProgramSettingDetail[0]->company_ownership_error) ? $setting->financingProgramSettingDetail[0]->company_ownership_error : '',
            'needs_intentions' => isset($setting->financingProgramSettingDetail[0]->needs_intentions_error) ? $setting->financingProgramSettingDetail[0]->needs_intentions_error : '',
            'primary_industry' => isset($setting->financingProgramSettingDetail[0]->primary_industry_error) ? $setting->financingProgramSettingDetail[0]->primary_industry_error : '',
            'business_categories' => isset($setting->financingProgramSettingDetail[0]->business_categories_error) ? $setting->financingProgramSettingDetail[0]->business_categories_error : '',
        ];
    }

    // Validate the request data
    $data = $this->validate($request, [
        "name_title" => "required",
        "email" => "required|email",
        "business_name" => "required",
        "zipcode" => "required",
        "incorporation" => "required",
        "full_time_employees" => "required",
        "revenue_last_year" => "required",
        "company_ownership" => "required",
        "needs_intentions" => ["required", new MaxWordCount(100)],
        "primary_industry" => "required|array|min:1|max:3",
        "primary_industry.*.id" => "required|integer",
        "primary_industry.*.category_name" => "required|string",
    ], [], $niceNames);

    // Save the form data to the database
    $financingProgram = FinancingProgram::create([
        'business_category_id' => $data['primary_industry'][0]['id'], // Save the first selected industry
    ]);

    // Save the financing program details
    FinancingProgramDetail::create([
        'financing_program_id' => $financingProgram->id,
        'language_id' => $defaultLang->id,
        'name_title' => $data['name_title'],
        'email' => $data['email'],
        'business_name' => $data['business_name'],
        'zipcode' => $data['zipcode'],
        'incorporation' => $data['incorporation'],
        'full_time_employees' => $data['full_time_employees'],
        'revenue_last_year' => $data['revenue_last_year'],
        'company_ownership' => $data['company_ownership'],
        'needs_intentions' => $data['needs_intentions'],
        'primary_industry' => json_encode($data['primary_industry']), // Save primary industry as JSON
    ]);

    // Send email to admin
    $emailService = new EmailSettingService();
    $result = $emailService->canadianExportersForm();
    if ($result['status'] == 'Error') {
        return $result;
    }

    $general_setting = getGeneralSettingByKey();
    if (isset($general_setting['admin_email'])) {
        $adminEmailsArr = explode(',', $general_setting['admin_email']);
    }

    if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
        $to_email = $adminEmailsArr[0];
        unset($adminEmailsArr[0]);
        Mail::to($to_email)->cc($adminEmailsArr)->send(new FinancingProgramMail($data, $data['primary_industry']));
    } else {
        $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
        if ($to_email) {
            Mail::to($to_email)->send(new FinancingProgramMail($data, $data['primary_industry']));
        }
    }

    // Send auto-response email to the customer
    Mail::to($request->email)->send(new FinancingProgramResponseMail([]));

    // Get the success message from translations
    $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_49']);
    $message_49 = isset($general_messages['message_49']) ? $general_messages['message_49'] : '';

    return $this->successResponse([], $message_49);
}
}
