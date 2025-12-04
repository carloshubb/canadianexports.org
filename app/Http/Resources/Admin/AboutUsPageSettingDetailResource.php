<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsPageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'about_us_page_setting_id' => $this->about_us_page_setting_id,
            'language_id' => $this->language_id,
            'page_description' => $this->page_description,

            'about_us_page_setting' => new AboutUsPageSettingResource($this->whenLoaded('aboutUsPageSetting')),
        ];
    }
}
