<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CloseAccountSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contact_us_setting_id' => $this->contact_us_setting_id,
            'language_id' => $this->language_id,
            'button_text' => $this->button_text,
            'email_label' => $this->email_label,
            'email_placeholder' => $this->email_placeholder,
            'email_error' => $this->email_error,
            'message_label' => $this->message_label,
            'message_placeholder' => $this->message_placeholder,
            'message_error' => $this->message_error,
            'name_label' => $this->name_label,
            'name_placeholder' => $this->name_placeholder,
            'name_error' => $this->name_error,
            'page_heading' => $this->page_heading,
            'close_account_setting' => new CloseAccountSettingResource($this->whenLoaded('closeAccountSetting')),
        ];
    }
}
