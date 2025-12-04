<?php

namespace App\Services;

use App\Models\RatesSettingDetail;

class RatesSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['price_table_pre_text.price_table_pre_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['price_table_pre_text.price_table_pre_text_' . $language->id . '.required' => 'This field in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['price_table_post_text.price_table_post_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['price_table_post_text.price_table_post_text_' . $language->id . '.required' => 'This field in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($ratesSetting, $language, $request)
    {
        return [
            'rates_setting_id' => $ratesSetting->id,
            'language_id' => $language->id,
            'price_table_pre_text' => $request['price_table_pre_text']['price_table_pre_text_' . $language->id] ?? null,
            'price_table_post_text' => $request['price_table_post_text']['price_table_post_text_' . $language->id] ?? null,
            'required_fields_text' => $request['required_fields_text']['required_fields_text_' . $language->id] ?? null,
            'name_label' => $request['name_label']['name_label_' . $language->id] ?? null,
            'page_heading' => $request['page_heading']['page_heading_' . $language->id] ?? null,
            'name_placeholder' => $request['name_placeholder']['name_placeholder_' . $language->id] ?? null,
            'name_error' => $request['name_error']['name_error_' . $language->id] ?? null,
            'email_label' => $request['email_label']['email_label_' . $language->id] ?? null,
            'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id] ?? null,
            'email_error' => $request['email_error']['email_error_' . $language->id] ?? null,
            'message_label' => $request['message_label']['message_label_' . $language->id] ?? null,
            'message_placeholder' => $request['message_placeholder']['message_placeholder_' . $language->id] ?? null,
            'message_error' => $request['message_error']['message_error_' . $language->id] ?? null,
            'button_text' => $request['button_text']['button_text_' . $language->id] ?? null,
        ];
    }

    public function store($ratesSetting, $language, $request)
    {
        $fields = $this->fields($ratesSetting, $language, $request);
        RatesSettingDetail::create($fields);
        return true;
    }

    public function update($ratesSetting, $language, $request)
    {
        $fields = $this->fields($ratesSetting, $language, $request);
        RatesSettingDetail::whereRatesSettingId($ratesSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
