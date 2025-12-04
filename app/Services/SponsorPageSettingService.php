<?php

namespace App\Services;

use App\Models\SponsorPageSettingDetail;

class SponsorPageSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_label.contact_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_label.contact_label_' . $language->id . '.required' => 'Contact label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($sponsorPageSetting, $language, $request)
    {
        return [
            'sponsor_page_setting_id' => $sponsorPageSetting->id,
            'language_id' => $language->id,
            'email_label' => isset($request['email_label']['email_label_' . $language->id]) ? $request['email_label']['email_label_' . $language->id] : null,
            'contact_label' => isset($request['contact_label']['contact_label_' . $language->id]) ? $request['contact_label']['contact_label_' . $language->id] : null,
            'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
        ];
    }

    public function store($sponsorPageSetting, $language, $request)
    {
        $fields = $this->fields($sponsorPageSetting, $language, $request);
        SponsorPageSettingDetail::create($fields);
        return true;
    }

    public function update($sponsorPageSetting, $language, $request)
    {
        $fields = $this->fields($sponsorPageSetting, $language, $request);
        SponsorPageSettingDetail::whereSponsorPageSettingId($sponsorPageSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
