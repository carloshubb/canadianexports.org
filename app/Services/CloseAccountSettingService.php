<?php

namespace App\Services;

use App\Models\CloseAccountSettingDetail;

class CloseAccountSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {
            $validationRule = array_merge($validationRule, ['page_heading.page_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_heading.page_heading_' . $language->id . '.required' => 'Page heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_placeholder.name_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_placeholder.name_placeholder_' . $language->id . '.required' => 'Name placeholder in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'Name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_placeholder.email_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_placeholder.email_placeholder_' . $language->id . '.required' => 'Email palceholder in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'Email error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_label.message_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_label.message_label_' . $language->id . '.required' => 'Message in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_placeholder.message_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_placeholder.message_placeholder_' . $language->id . '.required' => 'Message placeholder in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_error.message_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_error.message_error_' . $language->id . '.required' => 'Message error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($CloseAccountSetting, $language, $request)
    {
        return [
            'close_account_setting_id' => $CloseAccountSetting->id,
            'language_id' => $language->id,
            'name_label' => isset($request['name_label']['name_label_' . $language->id]) ? $request['name_label']['name_label_' . $language->id] : null,
            'name_placeholder' => isset($request['name_placeholder']['name_placeholder_' . $language->id]) ? $request['name_placeholder']['name_placeholder_' . $language->id] : null,
            'name_error' => isset($request['name_error']['name_error_' . $language->id]) ? $request['name_error']['name_error_' . $language->id] : null,
            'email_label' => isset($request['email_label']['email_label_' . $language->id]) ? $request['email_label']['email_label_' . $language->id] : null,
            'email_placeholder' => isset($request['email_placeholder']['email_placeholder_' . $language->id]) ? $request['email_placeholder']['email_placeholder_' . $language->id] : null,
            'email_error' => isset($request['email_error']['email_error_' . $language->id]) ? $request['email_error']['email_error_' . $language->id] : null,
            'message_label' => isset($request['message_label']['message_label_' . $language->id]) ? $request['message_label']['message_label_' . $language->id] : null,
            'message_placeholder' => isset($request['message_placeholder']['message_placeholder_' . $language->id]) ? $request['message_placeholder']['message_placeholder_' . $language->id] : null,
            'message_error' => isset($request['message_error']['message_error_' . $language->id]) ? $request['message_error']['message_error_' . $language->id] : null,
            'page_heading' => isset($request['page_heading']['page_heading_' . $language->id]) ? $request['page_heading']['page_heading_' . $language->id] : null,

            'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
        ];
    }

    public function store($CloseAccountSetting, $language, $request)
    {
        $fields = $this->fields($CloseAccountSetting, $language, $request);
        CloseAccountSettingDetail::create($fields);
        return true;
    }

    public function update($CloseAccountSetting, $language, $request)
    {
        $fields = $this->fields($CloseAccountSetting, $language, $request);
        CloseAccountSettingDetail::whereCloseAccountSettingId($CloseAccountSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
