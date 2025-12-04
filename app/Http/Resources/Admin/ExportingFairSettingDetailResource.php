<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ExportingFairSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'exporting_fair_setting_id' => $this->exporting_fair_setting_id,
            'language_id' => $this->language_id,
            'page_heading' => $this->page_heading,
            'exporting_fair_setting' => new ExportingFairSettingResource($this->whenLoaded('exportingFairSetting')),
        ];
    }
}
