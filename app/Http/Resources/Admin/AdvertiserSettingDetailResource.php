<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertiserSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'advertiser_page_setting_id' => $this->advertiser_page_setting_id,
            'language_id' => $this->language_id,
            'tab1_text' => $this->tab1_text,
            'tab2_text' => $this->tab2_text,
            'tab3_text' => $this->tab3_text,
            'contact_tab_heading' => $this->contact_tab_heading,
            'required_fields_text' => $this->required_fields_text,
            'name_label' => $this->name_label,
            'name_error' => $this->name_error,
            'company_name_label' => $this->company_name_label,
            'company_name_error' => $this->company_name_error,
            'email_label' => $this->email_label,
            'email_error' => $this->email_error,
            'message_label' => $this->message_label,
            'message_error' => $this->message_error,
            'send_me_a_copy_text' => $this->send_me_a_copy_text,
            'button_text' => $this->button_text,
            'contact_info_heading' => $this->contact_info_heading,
            'mail_address_text' => $this->mail_address_text,
            'phone_text' => $this->phone_text,
            'email_text' => $this->email_text,
            'link_text' => $this->link_text,

            'advertiser_setting' => new AdvertiserSettingResource($this->whenLoaded('advertiserSetting')),
        ];
    }
}
