<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OnlineBusinessDirectorySettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'online_business_directory_setting_id' => $this->online_business_directory_setting_id,
            'language_id' => $this->language_id,
            'keyword_label' => $this->keyword_label,
            'keyword_placeholder' => $this->keyword_placeholder,
            'keyword_error' => $this->keyword_error,
            'city_label' => $this->city_label,
            'city_placeholder' => $this->city_placeholder,
            'city_error' => $this->city_error,
            'province_label' => $this->province_label,
            'province_placeholder' => $this->province_placeholder,
            'province_error' => $this->province_error,
            'industry_label' => $this->industry_label,
            'industry_placeholder' => $this->industry_placeholder,
            'industry_error' => $this->industry_error,
            'button_text' => $this->button_text,
            'online_business_directory_setting' => new OnlineBusinessDirectorySettingResource($this->whenLoaded('onlineBusinessDirectorySetting')),
        ];
    }
}
