<?php

namespace App\Services;

use App\Models\ContactForRateSettingDetail;

class ContactForRateSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($contactForRateSetting, $language, $request)
    {
        return [
            'contact_for_rate_setting_id' => $contactForRateSetting->id,
            'language_id' => $language->id,
            'required_fields_text' => $request['required_fields_text']['required_fields_text_' . $language->id] ?? null,
            'name_label' => $request['name_label']['name_label_' . $language->id] ?? null,
            'name_placeholder' => $request['name_placeholder']['name_placeholder_' . $language->id] ?? null,
            'name_error' => $request['name_error']['name_error_' . $language->id] ?? null,
            'business_name_label' => $request['business_name_label']['business_name_label_' . $language->id] ?? null,
            'business_name_placeholder' => $request['business_name_placeholder']['business_name_placeholder_' . $language->id] ?? null,
            'business_name_error' => $request['business_name_error']['business_name_error_' . $language->id] ?? null,
            'phone_label' => $request['phone_label']['phone_label_' . $language->id] ?? null,
            'phone_placeholder' => $request['phone_placeholder']['phone_placeholder_' . $language->id] ?? null,
            'phone_error' => $request['phone_error']['phone_error_' . $language->id] ?? null,
            'email_label' => $request['email_label']['email_label_' . $language->id] ?? null,
            'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id] ?? null,
            'email_error' => $request['email_error']['email_error_' . $language->id] ?? null,
            'message_label' => $request['message_label']['message_label_' . $language->id] ?? null,
            'message_placeholder' => $request['message_placeholder']['message_placeholder_' . $language->id] ?? null,
            'message_error' => $request['message_error']['message_error_' . $language->id] ?? null,
            'button_text' => $request['button_text']['button_text_' . $language->id] ?? null,
        ];
    }

    public function store($contactForRateSetting, $language, $request)
    {
        $fields = $this->fields($contactForRateSetting, $language, $request);
        ContactForRateSettingDetail::create($fields);
        return true;
    }

    public function update($contactForRateSetting, $language, $request)
    {
        $fields = $this->fields($contactForRateSetting, $language, $request);
        ContactForRateSettingDetail::whereContactForRateSettingId($contactForRateSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
