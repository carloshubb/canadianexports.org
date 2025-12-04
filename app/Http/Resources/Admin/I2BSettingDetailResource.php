<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class I2BSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'i2b_setting_id' => $this->i2b_setting_id,
            'language_id' => $this->language_id,
            'search_label' => $this->search_label,
            'search_placeholder' => $this->search_placeholder,
            'search_error' => $this->search_error,
            'business_categories_label' => $this->business_categories_label,
            'business_categories_placeholder' => $this->business_categories_placeholder,
            'business_categories_error' => $this->business_categories_error,
            'business_categories_all_text' => $this->business_categories_all_text,
            'country_label' => $this->country_label,
            'country_placeholder' => $this->country_placeholder,
            'country_error' => $this->country_error,
            'country_all_text' => $this->country_all_text,
            'search_button_text' => $this->search_button_text,
            'title_heading' => $this->title_heading,
            'industry_heading' => $this->industry_heading,
            'country_heading' => $this->country_heading,
            'deadline_heading' => $this->deadline_heading,
            'estimated_value_heading' => $this->estimated_value_heading,

            'i2b_setting' => new I2BSettingResource($this->whenLoaded('i2BSetting')),
        ];
    }
}
