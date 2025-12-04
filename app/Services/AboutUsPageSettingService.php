<?php

namespace App\Services;

use App\Models\AboutUsPageSettingDetail;

class AboutUsPageSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['page_description.page_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_description.page_description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($aboutUsPageSetting, $language, $request)
    {
        return [
            'about_us_page_setting_id' => $aboutUsPageSetting->id,
            'language_id' => $language->id,
            'page_description' => isset($request['page_description']['page_description_' . $language->id]) ? $request['page_description']['page_description_' . $language->id] : null,
        ];
    }

    public function store($aboutUsPageSetting, $language, $request)
    {
        $fields = $this->fields($aboutUsPageSetting, $language, $request);
        AboutUsPageSettingDetail::create($fields);
        return true;
    }

    public function update($aboutUsPageSetting, $language, $request)
    {
        $fields = $this->fields($aboutUsPageSetting, $language, $request);
        AboutUsPageSettingDetail::whereAboutUsPageSettingId($aboutUsPageSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
