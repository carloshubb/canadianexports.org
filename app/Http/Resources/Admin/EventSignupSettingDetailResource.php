<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventSignupSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_signup_setting_id' => $this->event_signup_setting_id,
            'language_id' => $this->language_id,
            'profile_section_heading' => $this->profile_section_heading,
            'name_label' => $this->name_label,
            'name_error' => $this->name_error,
            'business_name_label' => $this->business_name_label,
            'business_name_error' => $this->business_name_error,
            'email_label' => $this->email_label,
            'email_error' => $this->email_error,
            'password_label' => $this->password_label,
            'password_placeholder' => $this->password_placeholder,
            'password_error' => $this->password_error,
            'confirm_password_label' => $this->confirm_password_label,
            'confirm_password_error' => $this->confirm_password_error,
            'free_package_text' => $this->free_package_text,
            'featured_package_text' => $this->featured_package_text,
            'premium_package_text' => $this->premium_package_text,
            'package_error' => $this->package_error,
            'package_section_heading' => $this->package_section_heading,
            'event_section_heading' => $this->event_section_heading,
            'contact_section_heading' => $this->contact_section_heading,
            'media_section_heading' => $this->media_section_heading,
            'button_text' => $this->button_text,

            'event_signup_setting' => new EventSignupSettingResource($this->whenLoaded('eventSignupSetting')),
        ];
    }
}
