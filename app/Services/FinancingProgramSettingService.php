<?php

namespace App\Services;

use App\Models\FinancingProgramSettingDetail;

class FinancingProgramSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($financingProgramSetting, $language, $request)
    {
        return [
            'financing_program_id' => $financingProgramSetting->id,
            'language_id' => $language->id,
            'required_fields_text' => $request['required_fields_text']['required_fields_text_' . $language->id] ?? null,
            'zipcode_label' => $request['zipcode_label']['zipcode_label_' . $language->id] ?? null,
            'zipcode_placeholder' => $request['zipcode_placeholder']['zipcode_placeholder_' . $language->id] ?? null,
            'zipcode_error' => $request['zipcode_error']['zipcode_error_' . $language->id] ?? null,
            'business_name_label' => $request['business_name_label']['business_name_label_' . $language->id] ?? null,
            'business_name_placeholder' => $request['business_name_placeholder']['business_name_placeholder_' . $language->id] ?? null,
            'business_name_error' => $request['business_name_error']['business_name_error_' . $language->id] ?? null,
            'name_title_label' => $request['name_title_label']['name_title_label_' . $language->id] ?? null,
            'name_title_placeholder' => $request['name_title_placeholder']['name_title_placeholder_' . $language->id] ?? null,
            'name_title_error' => $request['name_title_error']['name_title_error_' . $language->id] ?? null,
            'email_label' => $request['email_label']['email_label_' . $language->id] ?? null,
            'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id] ?? null,
            'email_error' => $request['email_error']['email_error_' . $language->id] ?? null,
            'incorporation_label' => $request['incorporation_label']['incorporation_label_' . $language->id] ?? null,
            'incorporation_placeholder' => $request['incorporation_placeholder']['incorporation_placeholder_' . $language->id] ?? null,
            'incorporation_error' => $request['incorporation_error']['incorporation_error_' . $language->id] ?? null,
            'full_time_employees_label' => $request['full_time_employees_label']['full_time_employees_label_' . $language->id] ?? null,
            'full_time_employees_placeholder' => $request['full_time_employees_placeholder']['full_time_employees_placeholder_' . $language->id] ?? null,
            'full_time_employees_error' => $request['full_time_employees_error']['full_time_employees_error_' . $language->id] ?? null,
            'revenue_last_year_label' => $request['revenue_last_year_label']['revenue_last_year_label_' . $language->id] ?? null,
            'revenue_last_year_placeholder' => $request['revenue_last_year_placeholder']['revenue_last_year_placeholder_' . $language->id] ?? null,
            'revenue_last_year_error' => $request['revenue_last_year_error']['revenue_last_year_error_' . $language->id] ?? null,
            'company_ownership_label' => $request['company_ownership_label']['company_ownership_label_' . $language->id] ?? null,
            'company_ownership_placeholder' => $request['company_ownership_placeholder']['company_ownership_placeholder_' . $language->id] ?? null,
            'company_ownership_error' => $request['company_ownership_error']['company_ownership_error_' . $language->id] ?? null,
            'needs_intentions_label' => $request['needs_intentions_label']['needs_intentions_label_' . $language->id] ?? null,
            'needs_intentions_placeholder' => $request['needs_intentions_placeholder']['needs_intentions_placeholder_' . $language->id] ?? null,
            'needs_intentions_error' => $request['needs_intentions_error']['needs_intentions_error_' . $language->id] ?? null,
            'primary_industry_label' => $request['primary_industry_label']['primary_industry_label_' . $language->id] ?? null,
            'primary_industry_placeholder' => $request['primary_industry_placeholder']['primary_industry_placeholder_' . $language->id] ?? null,
            'primary_industry_error' => $request['primary_industry_error']['primary_industry_error_' . $language->id] ?? null,
            'submit_button_text' => $request['submit_button_text']['submit_button_text_' . $language->id] ?? null,
        ];
    }

    public function store($financingProgramSetting, $language, $request)
    {
        $fields = $this->fields($financingProgramSetting, $language, $request);
        FinancingProgramSettingDetail::create($fields);
        return true;
    }

    public function update($financingProgramSetting, $language, $request)
    {
        $fields = $this->fields($financingProgramSetting, $language, $request);
        FinancingProgramSettingDetail::whereFinancingProgramId($financingProgramSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
