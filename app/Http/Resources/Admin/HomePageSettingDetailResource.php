<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class HomePageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'home_page_setting_id' => $this->home_page_setting_id,
            'language_id' => $this->language_id,

            'slider_heading' => $this->slider_heading,
            'slider_description' => $this->slider_description,
            'slider_search_placeholder' => $this->slider_search_placeholder,
            'slider_advance_search_text' => $this->slider_advance_search_text,
            'slider_image' => $this->slider_image,

            'section1_heading' => $this->section1_heading,
            'section1_description' => $this->section1_description,
            'section1_business_category' => $this->section1_business_category,
            'section1_business_category_url' => $this->section1_business_category_url,

            'section2_heading' => $this->section2_heading,
            'section2_category_label' => $this->section2_category_label,
            'section2_country_label' => $this->section2_country_label,
            'section2_deadline_label' => $this->section2_deadline_label,
            'section2_estimated_value_label' => $this->section2_estimated_value_label,
            'section2_i2b_button_text' => $this->section2_i2b_button_text,
            'section2_button_text' => $this->section2_button_text,
            'section2_button_url' => $this->section2_button_url,

            'section3_heading' => $this->section3_heading,
            'section3_button_text' => $this->section3_button_text,
            'section3_button_url' => $this->section3_button_url,
            'sponsor_value_button_text' => $this->sponsor_value_button_text,
            'sponsor_value_button_url' => $this->sponsor_value_button_url,
            'section3_become_sponsor_btn_text' => $this->section3_become_sponsor_btn_text,
            'section3_become_sponsor_btn_url' => $this->section3_become_sponsor_btn_url,

            'section4_heading' => $this->section4_heading,

            'section5_heading' => $this->section5_heading,
            'section5_event_detail_button_text' => $this->section5_event_detail_button_text,
            'section5_website_button_text' => $this->section5_website_button_text,
            'section5_see_all_button_text' => $this->section5_see_all_button_text,
            'section5_see_all_button_url' => $this->section5_see_all_button_url,
            'section5_add_event_text' => $this->section5_add_event_text,
            'section5_add_event_url' => $this->section5_add_event_url,

            'section6_heading' => $this->section6_heading,
            'section6_description' => $this->section6_description,
            'section6_see_all_button' => $this->section6_see_all_button,
            'contact_for_rates_btn_text' => $this->contact_for_rates_btn_text,
            'contact_for_rates_btn_url' => $this->contact_for_rates_btn_url,

            'home_page_setting' => new HomePageSettingResource($this->whenLoaded('homePageSetting')),
        ];
    }
}
