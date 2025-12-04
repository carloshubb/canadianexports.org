<?php

namespace App\Services;

use App\Models\OneMoreThingSettingDetail;

class OneMoreThingSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['page_heading.page_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_heading.page_heading_' . $language->id . '.required' => 'Page heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['read_more_btn_text.read_more_btn_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['read_more_btn_text.read_more_btn_text_' . $language->id . '.required' => 'Read more button text in ' . $language->name . ' is required.']);

        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($oneMoreThingSetting, $language, $request)
    {
        return [
            'one_more_thing_setting_id' => $oneMoreThingSetting->id,
            'language_id' => $language->id,
            'page_heading' => isset($request['page_heading']['page_heading_' . $language->id]) ? $request['page_heading']['page_heading_' . $language->id] : null,
            'read_more_btn_text' => isset($request['read_more_btn_text']['read_more_btn_text_' . $language->id]) ? $request['read_more_btn_text']['read_more_btn_text_' . $language->id] : null,
        ];
    }

    public function store($oneMoreThingSetting, $language, $request)
    {
        $fields = $this->fields($oneMoreThingSetting, $language, $request);
        OneMoreThingSettingDetail::create($fields);
        return true;
    }

    public function update($oneMoreThingSetting, $language, $request)
    {
        $fields = $this->fields($oneMoreThingSetting, $language, $request);
        OneMoreThingSettingDetail::whereOneMoreThingSettingId($oneMoreThingSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
