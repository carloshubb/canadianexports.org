<?php

namespace App\Services;

use App\Models\ScamAlertSettingDetail;

class ScamAlertSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($scamAlertSetting, $language, $request)
    {
        return [
            'scam_alert_setting_id' => $scamAlertSetting->id,
            'language_id' => $language->id,
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

    public function store($scamAlertSetting, $language, $request)
    {
        $fields = $this->fields($scamAlertSetting, $language, $request);
        ScamAlertSettingDetail::create($fields);
        return true;
    }

    public function update($scamAlertSetting, $language, $request)
    {
        $fields = $this->fields($scamAlertSetting, $language, $request);
        ScamAlertSettingDetail::whereScamAlertSettingId($scamAlertSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
