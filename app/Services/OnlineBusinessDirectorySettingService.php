<?php

namespace App\Services;

use App\Models\onlineBusinessDirectorySettingDetail;
use App\Models\OnlineBusinessDirectorySetting;

class OnlineBusinessDirectorySettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['keyword_label.keyword_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['keyword_label.keyword_label_' . $language->id . '.required' => 'Company name label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['keyword_placeholder.keyword_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['keyword_placeholder.keyword_placeholder_' . $language->id . '.required' => 'Company name placeholder in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['keyword_error.keyword_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['keyword_error.keyword_error_' . $language->id . '.required' => 'Company name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['city_label.city_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_label.city_label_' . $language->id . '.required' => 'City in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['city_placeholder.city_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_placeholder.city_placeholder_' . $language->id . '.required' => 'City error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['city_error.city_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_error.city_error_' . $language->id . '.required' => 'City error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['province_label.province_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['province_label.province_label_' . $language->id . '.required' => 'Province label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['province_placeholder.province_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['province_placeholder.province_placeholder_' . $language->id . '.required' => 'Province placeholder in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['province_error.province_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['province_error.province_error_' . $language->id . '.required' => 'Province error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['industry_label.industry_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['industry_label.industry_label_' . $language->id . '.required' => 'Industry in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['industry_placeholder.industry_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['industry_placeholder.industry_placeholder_' . $language->id . '.required' => 'Industry placeholder in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['industry_error.industry_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['industry_error.industry_error_' . $language->id . '.required' => 'Industry error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button Text in ' . $language->name . ' is required.']);

        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($onlineBusinessDirectorySetting, $language, $request)
    {
        return [
            'online_business_directory_setting_id' => $onlineBusinessDirectorySetting->id,
            'language_id' => $language->id,
            'keyword_label' => $request['keyword_label']['keyword_label_' . $language->id] ?? null,
            'keyword_error' => $request['keyword_error']['keyword_error_' . $language->id] ?? null,
            'keyword_placeholder' => $request['keyword_placeholder']['keyword_placeholder_' . $language->id] ?? null,
            'city_label' => $request['city_label']['city_label_' . $language->id] ?? null,
            'city_error' => $request['city_error']['city_error_' . $language->id] ?? null,
            'city_placeholder' => $request['city_placeholder']['city_placeholder_' . $language->id] ?? null,
            'province_label' => $request['province_label']['province_label_' . $language->id] ?? null,
            'province_error' => $request['province_error']['province_error_' . $language->id] ?? null,
            'province_placeholder' => $request['province_placeholder']['province_placeholder_' . $language->id] ?? null,
            'industry_label' => $request['industry_label']['industry_label_' . $language->id] ?? null,
            'industry_error' => $request['industry_error']['industry_error_' . $language->id] ?? null,
            'industry_placeholder' => $request['industry_placeholder']['industry_placeholder_' . $language->id] ?? null,
            'button_text' => $request['button_text']['button_text_' . $language->id] ?? null,
        ];
    }

    public function store($onlineBusinessDirectorySetting, $language, $request)
    {
        $fields = $this->fields($onlineBusinessDirectorySetting, $language, $request);
        OnlineBusinessDirectorySettingDetail::create($fields);
        return true;
    }

    public function update($onlineBusinessDirectorySetting, $language, $request)
    {
        $fields = $this->fields($onlineBusinessDirectorySetting, $language, $request);
        OnlineBusinessDirectorySettingDetail::whereOnlineBusinessDirectorySettingId($onlineBusinessDirectorySetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
