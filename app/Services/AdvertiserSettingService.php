<?php

namespace App\Services;

use App\Models\AdvertiserSettingDetail;

class AdvertiserSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['tab1_text.tab1_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['tab1_text.tab1_text_' . $language->id . '.required' => 'Tab 1 text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['tab2_text.tab2_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['tab2_text.tab2_text_' . $language->id . '.required' => 'Tab 2 text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['tab3_text.tab3_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['tab3_text.tab3_text_' . $language->id . '.required' => 'Tab 3 text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_tab_heading.contact_tab_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_tab_heading.contact_tab_heading_' . $language->id . '.required' => 'Contact tab heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['required_fields_text.required_fields_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['required_fields_text.required_fields_text_' . $language->id . '.required' => 'Required fields text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'Name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['company_name_label.company_name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['company_name_label.company_name_label_' . $language->id . '.required' => 'Company name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['company_name_error.company_name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['company_name_error.company_name_error_' . $language->id . '.required' => 'Company name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'Email error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_label.message_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_label.message_label_' . $language->id . '.required' => 'Message in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_error.message_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_error.message_error_' . $language->id . '.required' => 'Message error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['send_me_a_copy_text.send_me_a_copy_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['send_me_a_copy_text.send_me_a_copy_text_' . $language->id . '.required' => 'Send me a copy text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);

            $errorMessages = array_merge($errorMessages, ['contact_info_heading.contact_info_heading_' . $language->id . '.required' => 'Contact info heading in ' . $language->name . ' is required.']);
            
            $errorMessages = array_merge($errorMessages, ['mail_address_text.mail_address_text_' . $language->id . '.required' => 'Mail address text in ' . $language->name . ' is required.']);
            
            $errorMessages = array_merge($errorMessages, ['phone_text.phone_text_' . $language->id . '.required' => 'Phone text in ' . $language->name . ' is required.']);
            
            $errorMessages = array_merge($errorMessages, ['email_text.email_text_' . $language->id . '.required' => 'Email text in ' . $language->name . ' is required.']);
            
            $errorMessages = array_merge($errorMessages, ['link_text.link_text_' . $language->id . '.required' => 'Link text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($advertiserSetting, $language, $request)
    {
        return [
            'advertiser_setting_id' => $advertiserSetting->id,
            'language_id' => $language->id,
            'tab1_text' => isset($request['tab1_text']['tab1_text_' . $language->id]) ? $request['tab1_text']['tab1_text_' . $language->id] : null,
            'tab2_text' => isset($request['tab2_text']['tab2_text_' . $language->id]) ? $request['tab2_text']['tab2_text_' . $language->id] : null,
            'tab3_text' => isset($request['tab3_text']['tab3_text_' . $language->id]) ? $request['tab3_text']['tab3_text_' . $language->id] : null,
            'contact_tab_heading' => isset($request['contact_tab_heading']['contact_tab_heading_' . $language->id]) ? $request['contact_tab_heading']['contact_tab_heading_' . $language->id] : null,
            'required_fields_text' => isset($request['required_fields_text']['required_fields_text_' . $language->id]) ? $request['required_fields_text']['required_fields_text_' . $language->id] : null,
            'name_label' => isset($request['name_label']['name_label_' . $language->id]) ? $request['name_label']['name_label_' . $language->id] : null,
            'name_error' => isset($request['name_error']['name_error_' . $language->id]) ? $request['name_error']['name_error_' . $language->id] : null,
            'company_name_label' => isset($request['company_name_label']['company_name_label_' . $language->id]) ? $request['company_name_label']['company_name_label_' . $language->id] : null,
            'company_name_error' => isset($request['company_name_error']['company_name_error_' . $language->id]) ? $request['company_name_error']['company_name_error_' . $language->id] : null,
            'email_label' => isset($request['email_label']['email_label_' . $language->id]) ? $request['email_label']['email_label_' . $language->id] : null,
            'email_error' => isset($request['email_error']['email_error_' . $language->id]) ? $request['email_error']['email_error_' . $language->id] : null,
            'message_label' => isset($request['message_label']['message_label_' . $language->id]) ? $request['message_label']['message_label_' . $language->id] : null,
            'message_error' => isset($request['message_error']['message_error_' . $language->id]) ? $request['message_error']['message_error_' . $language->id] : null,
            'send_me_a_copy_text' => isset($request['send_me_a_copy_text']['send_me_a_copy_text_' . $language->id]) ? $request['send_me_a_copy_text']['send_me_a_copy_text_' . $language->id] : null,
            'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
            'contact_info_heading' => isset($request['contact_info_heading']['contact_info_heading_' . $language->id]) ? $request['contact_info_heading']['contact_info_heading_' . $language->id] : null,
            'mail_address_text' => isset($request['mail_address_text']['mail_address_text_' . $language->id]) ? $request['mail_address_text']['mail_address_text_' . $language->id] : null,
            'phone_text' => isset($request['phone_text']['phone_text_' . $language->id]) ? $request['phone_text']['phone_text_' . $language->id] : null,
            'email_text' => isset($request['email_text']['email_text_' . $language->id]) ? $request['email_text']['email_text_' . $language->id] : null,
            'link_text' => isset($request['link_text']['link_text_' . $language->id]) ? $request['link_text']['link_text_' . $language->id] : null,
        ];
    }

    public function store($advertiserSetting, $language, $request)
    {
        $fields = $this->fields($advertiserSetting, $language, $request);
        AdvertiserSettingDetail::create($fields);
        return true;
    }

    public function update($advertiserSetting, $language, $request)
    {
        $fields = $this->fields($advertiserSetting, $language, $request);
        AdvertiserSettingDetail::whereAdvertiserSettingId($advertiserSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
