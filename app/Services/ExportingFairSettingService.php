<?php

namespace App\Services;

use App\Models\ExportingFairSettingDetail;

class ExportingFairSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['page_heading.page_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_heading.page_heading_' . $language->id . '.required' => 'Page heading in ' . $language->name . ' is required.']);

        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($exportingFairSetting, $language, $request)
    {
        return [
            'exporting_fair_setting_id' => $exportingFairSetting->id,
            'language_id' => $language->id,
            'page_heading' => isset($request['page_heading']['page_heading_' . $language->id]) ? $request['page_heading']['page_heading_' . $language->id] : null,
        ];
    }

    public function store($exportingFairSetting, $language, $request)
    {
        $fields = $this->fields($exportingFairSetting, $language, $request);
        ExportingFairSettingDetail::create($fields);
        return true;
    }

    public function update($exportingFairSetting, $language, $request)
    {
        $fields = $this->fields($exportingFairSetting, $language, $request);
        ExportingFairSettingDetail::whereExportingFairSettingId($exportingFairSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
