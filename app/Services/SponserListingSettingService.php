<?php

namespace App\Services;

use App\Models\SponserListingSettingDetail;

class SponserListingSettingService
{

    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['no_sponser_found_text.no_sponser_found_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['no_sponser_found_text.no_sponser_found_text_' . $language->id . '.required' => 'No sponser found text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['user_has_sponser_text.user_has_sponser_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['user_has_sponser_text.user_has_sponser_text_' . $language->id . '.required' => 'User has sponser text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['add_sponser_btn_text.add_sponser_btn_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['add_sponser_btn_text.add_sponser_btn_text_' . $language->id . '.required' => 'Add sponser button text in ' . $language->name . ' is required.']);
            $validationRule = array_merge($validationRule, ['upgrade_profile_btn_text.upgrade_profile_btn_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['search_placeholder_text.search_placeholder_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['search_placeholder_text.search_placeholder_text_' . $language->id . '.required' => 'Search placeholder text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['show_text.show_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['show_text.show_text_' . $language->id . '.required' => 'Show text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['sponser_text.sponser_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['sponser_text.sponser_text_' . $language->id . '.required' => 'sponser text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['title_text.title_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['title_text.title_text_' . $language->id . '.required' => 'Title text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['action_text.action_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['action_text.action_text_' . $language->id . '.required' => 'Action text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['edit_button_text.edit_button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['edit_button_text.edit_button_text_' . $language->id . '.required' => 'Edit button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['start_at_end_at_text.start_at_end_at_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['start_at_end_at_text.start_at_end_at_text_' . $language->id . '.required' => 'Date text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($sponserListingSetting, $language, $request)
    {
        return [
            'sponser_list_setting_id' => $sponserListingSetting->id,
            'language_id' => $language->id,
            'no_sponser_found_text' => isset($request['no_sponser_found_text']['no_sponser_found_text_' . $language->id]) ? $request['no_sponser_found_text']['no_sponser_found_text_' . $language->id] : null,
            'user_has_sponser_text' => isset($request['user_has_sponser_text']['user_has_sponser_text_' . $language->id]) ? $request['user_has_sponser_text']['user_has_sponser_text_' . $language->id] : null,
            'add_sponser_btn_text' => isset($request['add_sponser_btn_text']['add_sponser_btn_text_' . $language->id]) ? $request['add_sponser_btn_text']['add_sponser_btn_text_' . $language->id] : null,
            'upgrade_profile_btn_text' => $request['upgrade_profile_btn_text']['upgrade_profile_btn_text_' . $language->id] ?? null,
            'search_placeholder_text' => isset($request['search_placeholder_text']['search_placeholder_text_' . $language->id]) ? $request['search_placeholder_text']['search_placeholder_text_' . $language->id] : null,
            'show_text' => isset($request['show_text']['show_text_' . $language->id]) ? $request['show_text']['show_text_' . $language->id] : null,
            'sponser_text' => isset($request['sponser_text']['sponser_text_' . $language->id]) ? $request['sponser_text']['sponser_text_' . $language->id] : null,
            'title_text' => isset($request['title_text']['title_text_' . $language->id]) ? $request['title_text']['title_text_' . $language->id] : null,
            'action_text' => isset($request['action_text']['action_text_' . $language->id]) ? $request['action_text']['action_text_' . $language->id] : null,
            'edit_button_text' => isset($request['edit_button_text']['edit_button_text_' . $language->id]) ? $request['edit_button_text']['edit_button_text_' . $language->id] : null,
            'start_at_end_at_text' => isset($request['start_at_end_at_text']['start_at_end_at_text_' . $language->id]) ? $request['start_at_end_at_text']['start_at_end_at_text_' . $language->id] : null,
        ];
    }

    public function store($sponserListingSetting, $language, $request)
    {
        $fields = $this->fields($sponserListingSetting, $language, $request);
        SponserListingSettingDetail::create($fields);
        return true;
    }

    public function update($sponserListingSetting, $language, $request)
    {
        $fields = $this->fields($sponserListingSetting, $language, $request);
        SponserListingSettingDetail::where('sponser_list_setting_id',$sponserListingSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }

}
