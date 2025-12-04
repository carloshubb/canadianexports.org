<?php

namespace App\Services;

use App\Models\ForgetPageSettingDetail;

class ForgetPageSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['body_text.body_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['body_text.body_text_' . $language->id . '.required' => 'Header text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'Email error in ' . $language->name . ' is required.']);


            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($forgetPageSetting, $language, $request)
    {
        return [
            'forget_page_setting_id' => $forgetPageSetting->id,
            'language_id' => $language->id,
            'body_text' => isset($request['body_text']['body_text_' . $language->id]) ? $request['body_text']['body_text_' . $language->id] : null,
            'email_label' => isset($request['email_label']['email_label_' . $language->id]) ? $request['email_label']['email_label_' . $language->id] : null,
            'email_error' => isset($request['email_error']['email_error_' . $language->id]) ? $request['email_error']['email_error_' . $language->id] : null,
            'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
        ];
    }

    public function store($forgetPageSetting, $language, $request)
    {
        $fields = $this->fields($forgetPageSetting, $language, $request);
        ForgetPageSettingDetail::create($fields);
        return true;
    }

    public function update($forgetPageSetting, $language, $request)
    {
        $fields = $this->fields($forgetPageSetting, $language, $request);
        ForgetPageSettingDetail::whereForgetPageSettingId($forgetPageSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
