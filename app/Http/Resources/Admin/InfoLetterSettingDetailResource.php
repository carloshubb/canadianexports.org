<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class InfoLetterSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'info_letter_setting_id' => $this->info_letter_setting_id,
            'language_id' => $this->language_id,
            'company_name_label' => $this->company_name_label,
            'company_name_error' => $this->company_name_error,
            'name_label' => $this->name_label,
            'name_error' => $this->name_error,
            'email_label' => $this->email_label,
            'email_error' => $this->email_error,
            'country_label' => $this->country_label,
            'country_error' => $this->country_error,
            'button_text' => $this->button_text,
            'widget_name' => $this->widget_name,

            'info_letter_setting' => new InfoLetterSettingResource($this->whenLoaded('infoLetterSetting')),
        ];
    }
}
