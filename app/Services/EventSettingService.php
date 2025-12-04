<?php

namespace App\Services;

use App\Models\EventSettingDetail;

class EventSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['search_label.search_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['search_label.search_label_' . $language->id . '.required' => 'Search label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['search_placeholder.search_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['search_placeholder.search_placeholder_' . $language->id . '.required' => 'Search placeholder in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['search_error.search_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['search_error.search_error_' . $language->id . '.required' => 'Search error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['business_categories_label.business_categories_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_categories_label.business_categories_label_' . $language->id . '.required' => 'Business categories label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['business_categories_placeholder.business_categories_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_categories_placeholder.business_categories_placeholder_' . $language->id . '.required' => 'Business categories placeholder label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['business_categories_error.business_categories_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_categories_error.business_categories_error_' . $language->id . '.required' => 'Business categories error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['business_categories_all_text.business_categories_all_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_categories_all_text.business_categories_all_text_' . $language->id . '.required' => 'Business categories all text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_label.country_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_label.country_label_' . $language->id . '.required' => 'Country label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_placeholder.country_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_placeholder.country_placeholder_' . $language->id . '.required' => 'Country placeholder in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_error.country_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_error.country_error_' . $language->id . '.required' => 'Country error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_all_text.country_all_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_all_text.country_all_text_' . $language->id . '.required' => 'Country all text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['search_button_text.search_button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['search_button_text.search_button_text_' . $language->id . '.required' => 'Search button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($eventSetting, $language, $request)
    {
        return [
            'event_setting_id' => $eventSetting->id,
            'language_id' => $language->id,
            'search_label' => isset($request['search_label']['search_label_' . $language->id]) ? $request['search_label']['search_label_' . $language->id] : null,
            'search_placeholder' => isset($request['search_placeholder']['search_placeholder_' . $language->id]) ? $request['search_placeholder']['search_placeholder_' . $language->id] : null,
            'search_error' => isset($request['search_error']['search_error_' . $language->id]) ? $request['search_error']['search_error_' . $language->id] : null,
            'business_categories_label' => isset($request['business_categories_label']['business_categories_label_' . $language->id]) ? $request['business_categories_label']['business_categories_label_' . $language->id] : null,
            'business_categories_placeholder' => isset($request['business_categories_placeholder']['business_categories_placeholder_' . $language->id]) ? $request['business_categories_placeholder']['business_categories_placeholder_' . $language->id] : null,
            'business_categories_error' => isset($request['business_categories_error']['business_categories_error_' . $language->id]) ? $request['business_categories_error']['business_categories_error_' . $language->id] : null,
            'business_categories_all_text' => isset($request['business_categories_all_text']['business_categories_all_text_' . $language->id]) ? $request['business_categories_all_text']['business_categories_all_text_' . $language->id] : null,
            'country_label' => isset($request['country_label']['country_label_' . $language->id]) ? $request['country_label']['country_label_' . $language->id] : null,
            'country_placeholder' => isset($request['country_placeholder']['country_placeholder_' . $language->id]) ? $request['country_placeholder']['country_placeholder_' . $language->id] : null,
            'country_error' => isset($request['country_error']['country_error_' . $language->id]) ? $request['country_error']['country_error_' . $language->id] : null,
            'country_all_text' => isset($request['country_all_text']['country_all_text_' . $language->id]) ? $request['country_all_text']['country_all_text_' . $language->id] : null,
            'search_button_text' => isset($request['search_button_text']['search_button_text_' . $language->id]) ? $request['search_button_text']['search_button_text_' . $language->id] : null,
            'title_heading' => $request['title_heading']['title_heading_' . $language->id] ?? null,
            'industry_heading' => $request['industry_heading']['industry_heading_' . $language->id] ?? null,
            'country_heading' => $request['country_heading']['country_heading_' . $language->id] ?? null,
            'deadline_heading' => $request['deadline_heading']['deadline_heading_' . $language->id] ?? null,
            'estimated_value_heading' => $request['estimated_value_heading']['estimated_value_heading_' . $language->id] ?? null,
        ];
    }

    public function store($eventSetting, $language, $request)
    {
        $fields = $this->fields($eventSetting, $language, $request);
        EventSettingDetail::create($fields);
        return true;
    }

    public function update($eventSetting, $language, $request)
    {
        $fields = $this->fields($eventSetting, $language, $request);
        EventSettingDetail::where('event_setting_id', $eventSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
