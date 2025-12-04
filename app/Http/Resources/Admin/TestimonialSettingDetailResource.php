<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'testimonial_id' => $this->testimonial_id,
            'language_id' => $this->language_id,
            'required_fields_text' => $this->required_fields_text,
            'name_label' => $this->name_label,
            'name_placeholder' => $this->name_placeholder,
            'name_error' => $this->name_error,
            'company_name_label' => $this->company_name_label,
            'company_name_placeholder' => $this->company_name_placeholder,
            'company_name_error' => $this->company_name_error,
            'business_categories_label' => $this->business_categories_label,
            'business_categories_placeholder' => $this->business_categories_placeholder,
            'business_categories_error' => $this->business_categories_error,
            'page_heading' => $this->page_heading,
            'email_label' => $this->email_label,
            'email_placeholder' => $this->email_placeholder,
            'email_error' => $this->email_error,
            'message_label' => $this->message_label,
            'message_placeholder' => $this->message_placeholder,
            'message_error' => $this->message_error,
            'button_text' => $this->button_text,
            'testimonial_setting' => new TestimonialSettingResource($this->whenLoaded('testimonialSetting')),
        ];
    }
}
