<?php

namespace App\Services;

use App\Models\SuccessStoriesSettingDetail;

class SuccessStoriesSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($successStoriesSetting, $language, $request)
    {
        return [
            'success_stories_setting_id' => $successStoriesSetting->id,
            'language_id' => $language->id,
            'required_fields_text' => $request['required_fields_text']['required_fields_text_' . $language->id] ?? null,
            'name_label' => $request['name_label']['name_label_' . $language->id] ?? null,
            'page_heading' => $request['page_heading']['page_heading_' . $language->id] ?? null,
            'name_placeholder' => $request['name_placeholder']['name_placeholder_' . $language->id] ?? null,
            'company_name_error' => $request['company_name_error']['company_name_error_' . $language->id] ?? null,
            'company_name_label' => $request['company_name_label']['company_name_label_' . $language->id] ?? null,
            'company_name_placeholder' => $request['company_name_placeholder']['company_name_placeholder_' . $language->id] ?? null,
            'name_error' => $request['name_error']['name_error_' . $language->id] ?? null,
            'email_label' => $request['email_label']['email_label_' . $language->id] ?? null,
            'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id] ?? null,
            'email_error' => $request['email_error']['email_error_' . $language->id] ?? null,
            'business_categories_label' => $request['business_categories_label']['business_categories_label_' . $language->id] ?? null,
            'business_categories_placeholder' => $request['business_categories_placeholder']['business_categories_placeholder_' . $language->id] ?? null,
            'business_categories_error' => $request['business_categories_error']['business_categories_error_' . $language->id] ?? null,
            'message_label' => $request['message_label']['message_label_' . $language->id] ?? null,
            'message_placeholder' => $request['message_placeholder']['message_placeholder_' . $language->id] ?? null,
            'message_error' => $request['message_error']['message_error_' . $language->id] ?? null,
            'button_text' => $request['button_text']['button_text_' . $language->id] ?? null,
        ];
    }

    public function store($successStoriesSetting, $language, $request)
    {
        $fields = $this->fields($successStoriesSetting, $language, $request);
        SuccessStoriesSettingDetail::create($fields);
        return true;
    }

    public function update($successStoriesSetting, $language, $request)
    {
        $fields = $this->fields($successStoriesSetting, $language, $request);
        SuccessStoriesSettingDetail::whereSuccessStoriesSettingId($successStoriesSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
