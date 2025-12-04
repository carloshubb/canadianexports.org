<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RatesSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'rates_setting_id' => $this->rates_setting_id,
            'language_id' => $this->language_id,
            'price_table_pre_text' => $this->price_table_pre_text,
            'price_table_post_text' => $this->price_table_post_text,
            'required_fields_text' => $this->required_fields_text,
            'name_label' => $this->name_label,
            'name_placeholder' => $this->name_placeholder,
            'name_error' => $this->name_error,
            'page_heading' => $this->page_heading,
            'email_label' => $this->email_label,
            'email_placeholder' => $this->email_placeholder,
            'email_error' => $this->email_error,
            'message_label' => $this->message_label,
            'message_placeholder' => $this->message_placeholder,
            'message_error' => $this->message_error,
            'button_text' => $this->button_text,
            'rates_setting' => new RatesSettingResource($this->whenLoaded('ratesSetting')),
        ];
    }
}
