<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FooterSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'footer_setting_id' => $this->footer_setting_id,
            'language_id' => $this->language_id,
            'widget1' => $this->widget1,
            'widget2' => $this->widget2,
            'widget3' => $this->widget3,
            'copyright_text' => $this->copyright_text,
            'footer_setting' => new FooterSettingResource($this->whenLoaded('footerSetting')),
        ];
    }
}
