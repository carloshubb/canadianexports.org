<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SponsorPageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'about_us_page_setting_id' => $this->about_us_page_setting_id,
            'language_id' => $this->language_id,
            'email_label' => $this->email_label,
            'contact_label' => $this->contact_label,
            'button_text' => $this->button_text,
            'sponsor_page_setting' => new SponsorPageSettingResource($this->whenLoaded('sponsorPageSetting')),
        ];
    }
}
