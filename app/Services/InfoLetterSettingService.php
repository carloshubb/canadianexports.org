<?php

namespace App\Services;

use App\Models\InfoLetterSettingDetail;

class InfoLetterSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['company_name_label.company_name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['company_name_label.company_name_label_' . $language->id . '.required' => 'Company name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['company_name_error.company_name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['company_name_error.company_name_error_' . $language->id . '.required' => 'Company name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'Name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'Email error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_label.country_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_label.country_label_' . $language->id . '.required' => 'Country in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_error.country_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_error.country_error_' . $language->id . '.required' => 'Country error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['widget_name.widget_name_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['widget_name.widget_name_' . $language->id . '.required' => 'Widget shortcode in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($infoLetterSetting, $language, $request)
    {
        return [
            'info_letter_setting_id' => $infoLetterSetting->id,
            'language_id' => $language->id,
            'company_name_label' => isset($request['company_name_label']['company_name_label_' . $language->id]) ? $request['company_name_label']['company_name_label_' . $language->id] : null,
            'company_name_error' => isset($request['company_name_error']['company_name_error_' . $language->id]) ? $request['company_name_error']['company_name_error_' . $language->id] : null,
            'name_label' => isset($request['name_label']['name_label_' . $language->id]) ? $request['name_label']['name_label_' . $language->id] : null,
            'name_error' => isset($request['name_error']['name_error_' . $language->id]) ? $request['name_error']['name_error_' . $language->id] : null,
            'email_label' => isset($request['email_label']['email_label_' . $language->id]) ? $request['email_label']['email_label_' . $language->id] : null,
            'email_error' => isset($request['email_error']['email_error_' . $language->id]) ? $request['email_error']['email_error_' . $language->id] : null,
            'country_label' => isset($request['country_label']['country_label_' . $language->id]) ? $request['country_label']['country_label_' . $language->id] : null,
            'country_error' => isset($request['country_error']['country_error_' . $language->id]) ? $request['country_error']['country_error_' . $language->id] : null,
            'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
            'widget_name' => isset($request['widget_name']['widget_name_' . $language->id]) ? $request['widget_name']['widget_name_' . $language->id] : null,
        ];
    }

    public function store($infoLetterSetting, $language, $request)
    {
        $fields = $this->fields($infoLetterSetting, $language, $request);
        InfoLetterSettingDetail::create($fields);
        return true;
    }

    public function update($infoLetterSetting, $language, $request)
    {
        $fields = $this->fields($infoLetterSetting, $language, $request);
        InfoLetterSettingDetail::whereInfoLetterSettingId($infoLetterSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
