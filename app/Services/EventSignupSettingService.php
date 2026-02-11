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

            $validationRule = array_merge($validationRule, ['organizer_website_label.organizer_website_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['organizer_website_label.organizer_website_label_' . $language->id . '.required' => 'Organizer website label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['your_profile_heading.your_profile_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['your_profile_heading.your_profile_heading_' . $language->id . '.required' => 'Your profile heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['the_organizer_heading.the_organizer_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['the_organizer_heading.the_organizer_heading_' . $language->id . '.required' => 'The organizer heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_person_heading.contact_person_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_person_heading.contact_person_heading_' . $language->id . '.required' => 'Contact person heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['organizer_phone_label.organizer_phone_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['organizer_phone_label.organizer_phone_label_' . $language->id . '.required' => 'Organizer phone label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['mailing_address_label.mailing_address_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['mailing_address_label.mailing_address_label_' . $language->id . '.required' => 'Mailing address label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_name_label.contact_name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_name_label.contact_name_label_' . $language->id . '.required' => 'Contact name label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_phone_label.contact_phone_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_phone_label.contact_phone_label_' . $language->id . '.required' => 'Contact phone label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_phone_hint.contact_phone_hint_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_phone_hint.contact_phone_hint_' . $language->id . '.required' => 'Contact phone hint in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_email_label.contact_email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_email_label.contact_email_label_' . $language->id . '.required' => 'Contact email label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_email_hint.contact_email_hint_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_email_hint.contact_email_hint_' . $language->id . '.required' => 'Contact email hint in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_photo_label.contact_photo_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_photo_label.contact_photo_label_' . $language->id . '.required' => 'Contact photo label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_photo_tooltip.contact_photo_tooltip_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_photo_tooltip.contact_photo_tooltip_' . $language->id . '.required' => 'Contact photo tooltip in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['main_event_image_label.main_event_image_label_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['main_event_image_hint.main_event_image_hint_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['photo_gallery_heading.photo_gallery_heading_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['photo_gallery_label.photo_gallery_label_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['photo_gallery_subtitle_featured.photo_gallery_subtitle_featured_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['photo_gallery_subtitle_premium.photo_gallery_subtitle_premium_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['update_btn_text.update_btn_text_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['privacy_heading.privacy_heading_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['privacy_bullet_1.privacy_bullet_1_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['privacy_bullet_2.privacy_bullet_2_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['privacy_bullet_3.privacy_bullet_3_' . $language->id => ['nullable', 'string']]);

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

            $validationRule = array_merge($validationRule, ['organizer_contact_section_heading.organizer_contact_section_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['organizer_contact_section_heading.organizer_contact_section_heading_' . $language->id . '.required' => 'Organizer contact section heading in ' . $language->name . ' is required.']);

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
            'organizer_website_label' => isset($request['organizer_website_label']['organizer_website_label_' . $language->id]) ? $request['organizer_website_label']['organizer_website_label_' . $language->id] : null,
            'your_profile_heading' => isset($request['your_profile_heading']['your_profile_heading_' . $language->id]) ? $request['your_profile_heading']['your_profile_heading_' . $language->id] : null,
            'the_organizer_heading' => isset($request['the_organizer_heading']['the_organizer_heading_' . $language->id]) ? $request['the_organizer_heading']['the_organizer_heading_' . $language->id] : null,
            'contact_person_heading' => isset($request['contact_person_heading']['contact_person_heading_' . $language->id]) ? $request['contact_person_heading']['contact_person_heading_' . $language->id] : null,
            'organizer_phone_label' => isset($request['organizer_phone_label']['organizer_phone_label_' . $language->id]) ? $request['organizer_phone_label']['organizer_phone_label_' . $language->id] : null,
            'mailing_address_label' => isset($request['mailing_address_label']['mailing_address_label_' . $language->id]) ? $request['mailing_address_label']['mailing_address_label_' . $language->id] : null,
            'contact_name_label' => isset($request['contact_name_label']['contact_name_label_' . $language->id]) ? $request['contact_name_label']['contact_name_label_' . $language->id] : null,
            'contact_phone_label' => isset($request['contact_phone_label']['contact_phone_label_' . $language->id]) ? $request['contact_phone_label']['contact_phone_label_' . $language->id] : null,
            'contact_phone_hint' => isset($request['contact_phone_hint']['contact_phone_hint_' . $language->id]) ? $request['contact_phone_hint']['contact_phone_hint_' . $language->id] : null,
            'contact_email_label' => isset($request['contact_email_label']['contact_email_label_' . $language->id]) ? $request['contact_email_label']['contact_email_label_' . $language->id] : null,
            'contact_email_hint' => isset($request['contact_email_hint']['contact_email_hint_' . $language->id]) ? $request['contact_email_hint']['contact_email_hint_' . $language->id] : null,
            'contact_photo_label' => isset($request['contact_photo_label']['contact_photo_label_' . $language->id]) ? $request['contact_photo_label']['contact_photo_label_' . $language->id] : null,
            'contact_photo_tooltip' => isset($request['contact_photo_tooltip']['contact_photo_tooltip_' . $language->id]) ? $request['contact_photo_tooltip']['contact_photo_tooltip_' . $language->id] : null,
            'main_event_image_label' => isset($request['main_event_image_label']['main_event_image_label_' . $language->id]) ? $request['main_event_image_label']['main_event_image_label_' . $language->id] : null,
            'main_event_image_hint' => isset($request['main_event_image_hint']['main_event_image_hint_' . $language->id]) ? $request['main_event_image_hint']['main_event_image_hint_' . $language->id] : null,
            'photo_gallery_heading' => isset($request['photo_gallery_heading']['photo_gallery_heading_' . $language->id]) ? $request['photo_gallery_heading']['photo_gallery_heading_' . $language->id] : null,
            'photo_gallery_label' => isset($request['photo_gallery_label']['photo_gallery_label_' . $language->id]) ? $request['photo_gallery_label']['photo_gallery_label_' . $language->id] : null,
            'photo_gallery_subtitle_featured' => isset($request['photo_gallery_subtitle_featured']['photo_gallery_subtitle_featured_' . $language->id]) ? $request['photo_gallery_subtitle_featured']['photo_gallery_subtitle_featured_' . $language->id] : null,
            'photo_gallery_subtitle_premium' => isset($request['photo_gallery_subtitle_premium']['photo_gallery_subtitle_premium_' . $language->id]) ? $request['photo_gallery_subtitle_premium']['photo_gallery_subtitle_premium_' . $language->id] : null,
            'update_btn_text' => isset($request['update_btn_text']['update_btn_text_' . $language->id]) ? $request['update_btn_text']['update_btn_text_' . $language->id] : null,
            'privacy_heading' => isset($request['privacy_heading']['privacy_heading_' . $language->id]) ? $request['privacy_heading']['privacy_heading_' . $language->id] : null,
            'privacy_bullet_1' => isset($request['privacy_bullet_1']['privacy_bullet_1_' . $language->id]) ? $request['privacy_bullet_1']['privacy_bullet_1_' . $language->id] : null,
            'privacy_bullet_2' => isset($request['privacy_bullet_2']['privacy_bullet_2_' . $language->id]) ? $request['privacy_bullet_2']['privacy_bullet_2_' . $language->id] : null,
            'privacy_bullet_3' => isset($request['privacy_bullet_3']['privacy_bullet_3_' . $language->id]) ? $request['privacy_bullet_3']['privacy_bullet_3_' . $language->id] : null,
            'email_label' => isset($request['email_label']['email_label_' . $language->id]) ? $request['email_label']['email_label_' . $language->id] : null,
            'email_error' => isset($request['email_error']['email_error_' . $language->id]) ? $request['email_error']['email_error_' . $language->id] : null,
            'password_label' => isset($request['password_label']['password_label_' . $language->id]) ? $request['password_label']['password_label_' . $language->id] : null,
            'password_placeholder' => isset($request['password_placeholder']['password_placeholder_' . $language->id]) ? $request['password_placeholder']['password_placeholder_' . $language->id] : null,
            'password_error' => isset($request['password_error']['password_error_' . $language->id]) ? $request['password_error']['password_error_' . $language->id] : null,
            'confirm_password_label' => isset($request['confirm_password_label']['confirm_password_label_' . $language->id]) ? $request['confirm_password_label']['confirm_password_label_' . $language->id] : null,
            'confirm_password_error' => isset($request['confirm_password_error']['confirm_password_error_' . $language->id]) ? $request['confirm_password_error']['confirm_password_error_' . $language->id] : null,
            'package_section_heading' => isset($request['package_section_heading']['package_section_heading_' . $language->id]) ? $request['package_section_heading']['package_section_heading_' . $language->id] : null,
            'organizer_contact_section_heading' => isset($request['organizer_contact_section_heading']['organizer_contact_section_heading_' . $language->id]) ? $request['organizer_contact_section_heading']['organizer_contact_section_heading_' . $language->id] : null,
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
