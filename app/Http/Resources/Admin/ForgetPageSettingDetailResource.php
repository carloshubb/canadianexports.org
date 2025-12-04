<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ForgetPageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'forget_page_setting_id' => $this->forget_page_setting_id,
            'language_id' => $this->language_id,
            'body_text' => $this->body_text,
            'email_label' => $this->email_label,
            'email_error' => $this->email_error,
            'button_text' => $this->button_text,

            'forget_page_setting' => new ForgetPageSettingResource($this->whenLoaded('forgetPageSetting')),
        ];
    }
}
