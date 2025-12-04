<?php

namespace App\Services;

use App\Models\CommentsSettingDetail;

class CommentsSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['page_heading.page_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_heading.page_heading_' . $language->id . '.required' => 'Page heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['page_description.page_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_description.page_description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['heading.heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['heading.heading_' . $language->id . '.required' => 'Heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['required_field_text.required_field_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['required_field_text.required_field_text_' . $language->id . '.required' => 'Required fields text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'Name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'Email error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_label.message_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_label.message_label_' . $language->id . '.required' => 'Message in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_error.message_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_error.message_error_' . $language->id . '.required' => 'Message error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($commentsSetting, $language, $request)
    {
        return [
            'comments_setting_id' => $commentsSetting->id,
            'language_id' => $language->id,
            'page_heading' => isset($request['page_heading']['page_heading_' . $language->id]) ? $request['page_heading']['page_heading_' . $language->id] : null,
            'page_description' => isset($request['page_description']['page_description_' . $language->id]) ? $request['page_description']['page_description_' . $language->id] : null,
            'heading' => isset($request['heading']['heading_' . $language->id]) ? $request['heading']['heading_' . $language->id] : null,
            'required_field_text' => isset($request['required_field_text']['required_field_text_' . $language->id]) ? $request['required_field_text']['required_field_text_' . $language->id] : null,
            'name_label' => isset($request['name_label']['name_label_' . $language->id]) ? $request['name_label']['name_label_' . $language->id] : null,
            'name_error' => isset($request['name_error']['name_error_' . $language->id]) ? $request['name_error']['name_error_' . $language->id] : null,
            'email_label' => isset($request['email_label']['email_label_' . $language->id]) ? $request['email_label']['email_label_' . $language->id] : null,
            'email_error' => isset($request['email_error']['email_error_' . $language->id]) ? $request['email_error']['email_error_' . $language->id] : null,
            'message_label' => isset($request['message_label']['message_label_' . $language->id]) ? $request['message_label']['message_label_' . $language->id] : null,
            'message_error' => isset($request['message_error']['message_error_' . $language->id]) ? $request['message_error']['message_error_' . $language->id] : null,
            'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
        ];
    }

    public function store($commentsSetting, $language, $request)
    {
        $fields = $this->fields($commentsSetting, $language, $request);
        CommentsSettingDetail::create($fields);
        return true;
    }

    public function update($commentsSetting, $language, $request)
    {
        $fields = $this->fields($commentsSetting, $language, $request);
        CommentsSettingDetail::whereCommentsSettingId($commentsSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
