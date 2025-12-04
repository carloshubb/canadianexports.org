<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BecomeSponsorSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'become_sponsor_setting_id' => $this->become_sponsor_setting_id,
            'language_id' => $this->language_id,
            'name_label' => $this->name_label,
            'name_error' => $this->name_error,
            'name_placeholder' => $this->name_placeholder,
            'company_name_label' => $this->company_name_label,
            'company_name_error' => $this->company_name_error,
            'company_name_placeholder' => $this->company_name_placeholder,
            'email_label' => $this->email_label,
            'email_error' => $this->email_error,
            'email_placeholder' => $this->email_placeholder,
            'contact_number_label' => $this->contact_number_label,
            'contact_number_error' => $this->contact_number_error,
            'contact_number_placeholder' => $this->contact_number_placeholder,
            'message_label' => $this->message_label,
            'message_error' => $this->message_error,
            'message_placeholder' => $this->message_placeholder,
            'image_label' => $this->image_label,
            'image_placeholder' => $this->image_placeholder,
            'image_error' => $this->image_error,
            'url_label' => $this->url_label,
            'url_error' => $this->url_error,
            'url_placeholder' => $this->url_placeholder,
            'time_to_call_label' => $this->time_to_call_label,
            'time_to_call_error' => $this->time_to_call_error,
            'time_to_call_am_label' => $this->time_to_call_am_label,
            'time_to_call_pm_label' => $this->time_to_call_pm_label,
            'appointment_label' => $this->appointment_label,
            'appointment_error' => $this->appointment_error,
            'appointment_yes_option' => $this->appointment_yes_option,
            'appointment_no_option' => $this->appointment_no_option,
            'appointment_date_label' => $this->appointment_date_label,
            'appointment_date_error' => $this->appointment_date_error,
            'feature_image_label' => $this->feature_image_label,
            'feature_image_error' => $this->feature_image_error,
            'feature_image_placeholder' => $this->feature_image_placeholder,
            'summary_label' => $this->summary_label,
            'summary_error' => $this->summary_error,
            'summary_placeholder' => $this->summary_placeholder,
            'detail_description_label' => $this->detail_description_label,
            'detail_description_error' => $this->detail_description_error,
            'detail_description_placeholder' => $this->detail_description_placeholder,
            'submit_btn_text' => $this->submit_btn_text,
            'become_sponsor_setting' => new BecomeSponsorSettingResource($this->whenLoaded('becomeSponsorSetting')),
        ];
    }
}
