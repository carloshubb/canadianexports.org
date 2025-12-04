<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactForRateSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contact_for_rate_id' => $this->contact_for_rate_id,
            'language_id' => $this->language_id,
            'required_fields_text' => $this->required_fields_text,
            'name_label' => $this->name_label,
            'name_placeholder' => $this->name_placeholder,
            'name_error' => $this->name_error,
            'business_name_label' => $this->business_name_label,
            'business_name_placeholder' => $this->business_name_placeholder,
            'business_name_error' => $this->business_name_error,
            'phone_label' => $this->phone_label,
            'phone_placeholder' => $this->phone_placeholder,
            'phone_error' => $this->phone_error,
            'email_label' => $this->email_label,
            'email_placeholder' => $this->email_placeholder,
            'email_error' => $this->email_error,
            'message_label' => $this->message_label,
            'message_placeholder' => $this->message_placeholder,
            'message_error' => $this->message_error,
            'button_text' => $this->button_text,
            'contact_for_rate_setting' => new ContactForRateSettingResource($this->whenLoaded('contactForRateSetting')),
        ];
    }
}
