<?php

namespace App\Services;

use App\Models\EventSignupSettingDetail;

class EventSignupSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['profile_section_heading.profile_section_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['profile_section_heading.profile_section_heading_' . $language->id . '.required' => 'Profile section heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'Name label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'Name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['business_name_label.business_name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_name_label.business_name_label_' . $language->id . '.required' => 'Business name label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['business_name_error.business_name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_name_error.business_name_error_' . $language->id . '.required' => 'Business name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'Email error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['password_label.password_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['password_label.password_label_' . $language->id . '.required' => 'Password label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['password_placeholder.password_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['password_placeholder.password_placeholder_' . $language->id . '.required' => 'Password label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['password_error.password_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['password_error.password_error_' . $language->id . '.required' => 'Password error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['confirm_password_label.confirm_password_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['confirm_password_label.confirm_password_label_' . $language->id . '.required' => 'Confirm password label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['confirm_password_error.confirm_password_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['confirm_password_error.confirm_password_error_' . $language->id . '.required' => 'Confirm password error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['package_section_heading.package_section_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['package_section_heading.package_section_heading_' . $language->id . '.required' => 'Package section heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['event_section_heading.event_section_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['event_section_heading.event_section_heading_' . $language->id . '.required' => 'Event section heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_section_heading.contact_section_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_section_heading.contact_section_heading_' . $language->id . '.required' => 'Contact section heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_section_heading.contact_section_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_section_heading.contact_section_heading_' . $language->id . '.required' => 'Media section heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['free_package_text.free_package_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['free_package_text.free_package_text_' . $language->id . '.required' => 'Free package text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['featured_package_text.featured_package_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['featured_package_text.featured_package_text_' . $language->id . '.required' => 'Featured package text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['premium_package_text.premium_package_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['premium_package_text.premium_package_text_' . $language->id . '.required' => 'Premium package text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['package_error.package_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['package_error.package_error_' . $language->id . '.required' => 'Package error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($eventSignupSetting, $language, $request)
    {
        return [
            'event_signup_setting_id' => $eventSignupSetting->id,
            'language_id' => $language->id,
            'profile_section_heading' => isset($request['profile_section_heading']['profile_section_heading_' . $language->id]) ? $request['profile_section_heading']['profile_section_heading_' . $language->id] : null,
            'name_label' => isset($request['name_label']['name_label_' . $language->id]) ? $request['name_label']['name_label_' . $language->id] : null,
            'name_error' => isset($request['name_error']['name_error_' . $language->id]) ? $request['name_error']['name_error_' . $language->id] : null,
            'business_name_label' => isset($request['business_name_label']['business_name_label_' . $language->id]) ? $request['business_name_label']['business_name_label_' . $language->id] : null,
            'business_name_error' => isset($request['business_name_error']['business_name_error_' . $language->id]) ? $request['business_name_error']['business_name_error_' . $language->id] : null,
            'email_label' => isset($request['email_label']['email_label_' . $language->id]) ? $request['email_label']['email_label_' . $language->id] : null,
            'email_error' => isset($request['email_error']['email_error_' . $language->id]) ? $request['email_error']['email_error_' . $language->id] : null,
            'password_label' => isset($request['password_label']['password_label_' . $language->id]) ? $request['password_label']['password_label_' . $language->id] : null,
            'password_placeholder' => isset($request['password_placeholder']['password_placeholder_' . $language->id]) ? $request['password_placeholder']['password_placeholder_' . $language->id] : null,
            'password_error' => isset($request['password_error']['password_error_' . $language->id]) ? $request['password_error']['password_error_' . $language->id] : null,
            'confirm_password_label' => isset($request['confirm_password_label']['confirm_password_label_' . $language->id]) ? $request['confirm_password_label']['confirm_password_label_' . $language->id] : null,
            'confirm_password_error' => isset($request['confirm_password_error']['confirm_password_error_' . $language->id]) ? $request['confirm_password_error']['confirm_password_error_' . $language->id] : null,
            'package_section_heading' => isset($request['package_section_heading']['package_section_heading_' . $language->id]) ? $request['package_section_heading']['package_section_heading_' . $language->id] : null,
            'event_section_heading' => isset($request['event_section_heading']['event_section_heading_' . $language->id]) ? $request['event_section_heading']['event_section_heading_' . $language->id] : null,
            'contact_section_heading' => isset($request['contact_section_heading']['contact_section_heading_' . $language->id]) ? $request['contact_section_heading']['contact_section_heading_' . $language->id] : null,
            'media_section_heading' => isset($request['media_section_heading']['media_section_heading_' . $language->id]) ? $request['media_section_heading']['media_section_heading_' . $language->id] : null,
            'free_package_text' => isset($request['free_package_text']['free_package_text_' . $language->id]) ? $request['free_package_text']['free_package_text_' . $language->id] : null,
            'featured_package_text' => isset($request['featured_package_text']['featured_package_text_' . $language->id]) ? $request['featured_package_text']['featured_package_text_' . $language->id] : null,
            'premium_package_text' => isset($request['premium_package_text']['premium_package_text_' . $language->id]) ? $request['premium_package_text']['premium_package_text_' . $language->id] : null,
            'package_error' => isset($request['package_error']['package_error_' . $language->id]) ? $request['package_error']['package_error_' . $language->id] : null,
            'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
        ];
    }

    public function store($eventSignupSetting, $language, $request)
    {
        $fields = $this->fields($eventSignupSetting, $language, $request);
        EventSignupSettingDetail::create($fields);
        return true;
    }

    public function update($eventSignupSetting, $language, $request)
    {
        $fields = $this->fields($eventSignupSetting, $language, $request);
        EventSignupSettingDetail::whereEventSignupSettingId($eventSignupSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
