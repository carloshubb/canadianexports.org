<?php

namespace App\Services;

use App\Models\BecomeSponsorSettingDetail;

class BecomeSponsorSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'Name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['company_name_label.company_name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['company_name_label.company_name_label_' . $language->id . '.required' => 'Company name label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['company_name_error.company_name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['company_name_error.company_name_error_' . $language->id . '.required' => 'Company name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'Email error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_number_label.contact_number_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_number_label.contact_number_label_' . $language->id . '.required' => 'Contact number label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_number_error.contact_number_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_number_error.contact_number_error_' . $language->id . '.required' => 'Contact number error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_label.message_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_label.message_label_' . $language->id . '.required' => 'Message in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_error.message_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_error.message_error_' . $language->id . '.required' => 'Message in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['image_label.image_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['image_label.image_label_' . $language->id . '.required' => 'Image in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['image_placeholder.image_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['image_placeholder.image_placeholder_' . $language->id . '.required' => 'Image placeholder in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['image_error.image_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['image_error.image_error_' . $language->id . '.required' => 'Image error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['url_label.url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['url_label.url_label_' . $language->id . '.required' => 'URL in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['url_error.url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['url_error.url_error_' . $language->id . '.required' => 'URL error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['submit_btn_text.submit_btn_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['submit_btn_text.submit_btn_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($becomeSponsorSetting, $language, $request)
    {
        return [
            'become_sponsor_setting_id' => $becomeSponsorSetting->id,
            'language_id' => $language->id,
            'name_label' => $request['name_label']['name_label_' . $language->id] ?? null,
            'name_error' => $request['name_error']['name_error_' . $language->id] ?? null,
            'name_placeholder' => $request['name_placeholder']['name_placeholder_' . $language->id] ?? null,
            'company_name_label' => $request['company_name_label']['company_name_label_' . $language->id] ?? null,
            'company_name_error' => $request['company_name_error']['company_name_error_' . $language->id] ?? null,
            'company_name_placeholder' => $request['company_name_placeholder']['company_name_placeholder_' . $language->id] ?? null,
            'email_label' => $request['email_label']['email_label_' . $language->id] ?? null,
            'email_error' => $request['email_error']['email_error_' . $language->id] ?? null,
            'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id] ?? null,
            'contact_number_label' => $request['contact_number_label']['contact_number_label_' . $language->id] ?? null,
            'contact_number_error' => $request['contact_number_error']['contact_number_error_' . $language->id] ?? null,
            'contact_number_placeholder' => $request['contact_number_placeholder']['contact_number_placeholder_' . $language->id] ?? null,
            'message_label' => $request['message_label']['message_label_' . $language->id] ?? null,
            'message_error' => $request['message_error']['message_error_' . $language->id] ?? null,
            'message_placeholder' => $request['message_placeholder']['message_placeholder_' . $language->id] ?? null,
            'image_label' => $request['image_label']['image_label_' . $language->id] ?? null,
            'image_placeholder' => $request['image_placeholder']['image_placeholder_' . $language->id] ?? null,
            'image_error' => $request['image_error']['image_error_' . $language->id] ?? null,
            'url_label' => $request['url_label']['url_label_' . $language->id] ?? null,
            'url_error' => $request['url_error']['url_error_' . $language->id] ?? null,
            'url_placeholder' => $request['url_placeholder']['url_placeholder_' . $language->id] ?? null,
            'time_to_call_label' => $request['time_to_call_label']['time_to_call_label_' . $language->id] ?? null,
            'time_to_call_error' => $request['time_to_call_error']['time_to_call_error_' . $language->id] ?? null,
            'time_to_call_am_label' => $request['time_to_call_am_label']['time_to_call_am_label_' . $language->id] ?? null,
            'time_to_call_pm_label' => $request['time_to_call_pm_label']['time_to_call_pm_label_' . $language->id] ?? null,
            'appointment_label' => $request['appointment_label']['appointment_label_' . $language->id] ?? null,
            'appointment_error' => $request['appointment_error']['appointment_error_' . $language->id] ?? null,
            'appointment_yes_option' => $request['appointment_yes_option']['appointment_yes_option_' . $language->id] ?? null,
            'appointment_no_option' => $request['appointment_no_option']['appointment_no_option_' . $language->id] ?? null,
            'appointment_date_label' => $request['appointment_date_label']['appointment_date_label_' . $language->id] ?? null,
            'appointment_date_error' => $request['appointment_date_error']['appointment_date_error_' . $language->id] ?? null,
            'feature_image_label' => $request['feature_image_label']['feature_image_label_' . $language->id] ?? null,
            'feature_image_error' => $request['feature_image_error']['feature_image_error_' . $language->id] ?? null,
            'feature_image_placeholder' => $request['feature_image_placeholder']['feature_image_placeholder_' . $language->id] ?? null,
            'summary_label' => $request['summary_label']['summary_label_' . $language->id] ?? null,
            'summary_error' => $request['summary_error']['summary_error_' . $language->id] ?? null,
            'summary_placeholder' => $request['summary_placeholder']['summary_placeholder_' . $language->id] ?? null,
            'detail_description_label' => $request['detail_description_label']['detail_description_label_' . $language->id] ?? null,
            'detail_description_error' => $request['detail_description_error']['detail_description_error_' . $language->id] ?? null,
            'detail_description_placeholder' => $request['detail_description_placeholder']['detail_description_placeholder_' . $language->id] ?? null,
            'submit_btn_text' => $request['submit_btn_text']['submit_btn_text_' . $language->id] ?? null,
            'sponsorship_section_heading' => $request['sponsorship_section_heading']['sponsorship_section_heading_' . $language->id] ?? null,
            'enter_amount_placeholder' => $request['enter_amount_placeholder']['enter_amount_placeholder_' . $language->id] ?? null,
            'talk_to_us_first_label' => $request['talk_to_us_first_label']['talk_to_us_first_label_' . $language->id] ?? null,
            'talk_to_us_first_description' => $request['talk_to_us_first_description']['talk_to_us_first_description_' . $language->id] ?? null,
            'no_amounts_message' => $request['no_amounts_message']['no_amounts_message_' . $language->id] ?? null,
            'contact_preferences_heading' => $request['contact_preferences_heading']['contact_preferences_heading_' . $language->id] ?? null,
            'best_time_to_call_label' => $request['best_time_to_call_label']['best_time_to_call_label_' . $language->id] ?? null,
            'preferred_date_label' => $request['preferred_date_label']['preferred_date_label_' . $language->id] ?? null,
            'call_time_morning' => $request['call_time_morning']['call_time_morning_' . $language->id] ?? null,
            'call_time_afternoon' => $request['call_time_afternoon']['call_time_afternoon_' . $language->id] ?? null,
            'call_time_evening' => $request['call_time_evening']['call_time_evening_' . $language->id] ?? null,
            'account_details_heading' => $request['account_details_heading']['account_details_heading_' . $language->id] ?? null,
            'contact_name_placeholder' => $request['contact_name_placeholder']['contact_name_placeholder_' . $language->id] ?? null,
            'email_hint' => $request['email_hint']['email_hint_' . $language->id] ?? null,
            'password_label' => $request['password_label']['password_label_' . $language->id] ?? null,
            'password_hint' => $request['password_hint']['password_hint_' . $language->id] ?? null,
            'confirm_password_label' => $request['confirm_password_label']['confirm_password_label_' . $language->id] ?? null,
            'optional_text' => $request['optional_text']['optional_text_' . $language->id] ?? null,
            'brand_story_heading' => $request['brand_story_heading']['brand_story_heading_' . $language->id] ?? null,
            'featured_image_hint' => $request['featured_image_hint']['featured_image_hint_' . $language->id] ?? null,
            'logo_hint' => $request['logo_hint']['logo_hint_' . $language->id] ?? null,
            'summary_placeholder_long' => $request['summary_placeholder_long']['summary_placeholder_long_' . $language->id] ?? null,
            'detail_description_placeholder_long' => $request['detail_description_placeholder_long']['detail_description_placeholder_long_' . $language->id] ?? null,
            'message_placeholder_long' => $request['message_placeholder_long']['message_placeholder_long_' . $language->id] ?? null,
            'featured_image_idle' => $request['featured_image_idle']['featured_image_idle_' . $language->id] ?? null,
            'logo_idle' => $request['logo_idle']['logo_idle_' . $language->id] ?? null,
            'payment_method_heading' => $request['payment_method_heading']['payment_method_heading_' . $language->id] ?? null,
            'debit_credit_label' => $request['debit_credit_label']['debit_credit_label_' . $language->id] ?? null,
            'cardholder_name_label' => $request['cardholder_name_label']['cardholder_name_label_' . $language->id] ?? null,
            'terms_privacy_label' => $request['terms_privacy_label']['terms_privacy_label_' . $language->id] ?? null,
            'donation_non_refundable_label' => $request['donation_non_refundable_label']['donation_non_refundable_label_' . $language->id] ?? null,
            'processing_text' => $request['processing_text']['processing_text_' . $language->id] ?? null,
            'reactivate_btn_text' => $request['reactivate_btn_text']['reactivate_btn_text_' . $language->id] ?? null,
            'become_sponsor_btn_text' => $request['become_sponsor_btn_text']['become_sponsor_btn_text_' . $language->id] ?? null,
        ];
    }

    public function store($becomeSponsorSetting, $language, $request)
    {
        $fields = $this->fields($becomeSponsorSetting, $language, $request);
        BecomeSponsorSettingDetail::create($fields);
        return true;
    }

    public function update($becomeSponsorSetting, $language, $request)
    {
        $fields = $this->fields($becomeSponsorSetting, $language, $request);
        BecomeSponsorSettingDetail::whereBecomeSponsorSettingId($becomeSponsorSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
