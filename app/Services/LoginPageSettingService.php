<?php

namespace App\Services;

use App\Models\LoginPageSettingDetail;

class LoginPageSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['main_heading.main_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['main_heading.main_heading_' . $language->id . '.required' => 'Heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['required_fields_text.required_fields_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['required_fields_text.required_fields_text_' . $language->id . '.required' => 'required fields text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'Email error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_help.email_help_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_help.email_help_' . $language->id . '.required' => 'Email help in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['password_label.password_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['password_label.password_label_' . $language->id . '.required' => 'Password help in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['password_error.password_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['password_error.password_error_' . $language->id . '.required' => 'Password error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['remeber_me_label.remeber_me_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['remeber_me_label.remeber_me_label_' . $language->id . '.required' => 'Remeber me label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['forgot_password_text.forgot_password_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['forgot_password_text.forgot_password_text_' . $language->id . '.required' => 'Forgot password text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['signin_btn_text.signin_btn_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['signin_btn_text.signin_btn_text_' . $language->id . '.required' => 'Signin button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['signup_btn_text.signup_btn_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['signup_btn_text.signup_btn_text_' . $language->id . '.required' => 'Signup button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['protect_account_heading.protect_account_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['protect_account_heading.protect_account_heading_' . $language->id . '.required' => 'Signup button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['protect_account_description.protect_account_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['protect_account_description.protect_account_description_' . $language->id . '.required' => 'Signup button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($loginPageSetting, $language, $request)
    {
        return [
            'login_page_setting_id' => $loginPageSetting->id,
            'language_id' => $language->id,
            'main_heading' => $request['main_heading']['main_heading_' . $language->id] ?? null,
            'required_fields_text' => $request['required_fields_text']['required_fields_text_' . $language->id] ?? null,
            'email_label' => $request['email_label']['email_label_' . $language->id] ?? null,
            'email_error' => $request['email_error']['email_error_' . $language->id] ?? null,
            'email_help' => $request['email_help']['email_help_' . $language->id] ?? null,
            'password_label' => $request['password_label']['password_label_' . $language->id] ?? null,
            'password_error' => $request['password_error']['password_error_' . $language->id] ?? null,
            'remeber_me_label' => $request['remeber_me_label']['remeber_me_label_' . $language->id] ?? null,
            'forgot_password_text' => $request['forgot_password_text']['forgot_password_text_' . $language->id] ?? null,
            'signin_btn_text' => $request['signin_btn_text']['signin_btn_text_' . $language->id] ?? null,
            'signup_btn_text' => $request['signup_btn_text']['signup_btn_text_' . $language->id] ?? null,
            'protect_account_heading' => $request['protect_account_heading']['protect_account_heading_' . $language->id] ?? null,
            'protect_account_description' => $request['protect_account_description']['protect_account_description_' . $language->id] ?? null,
        ];
    }

    public function store($loginPageSetting, $language, $request)
    {
        $fields = $this->fields($loginPageSetting, $language, $request);
        LoginPageSettingDetail::create($fields);
        return true;
    }

    public function update($loginPageSetting, $language, $request)
    {
        $fields = $this->fields($loginPageSetting, $language, $request);
        LoginPageSettingDetail::whereLoginPageSettingId($loginPageSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
