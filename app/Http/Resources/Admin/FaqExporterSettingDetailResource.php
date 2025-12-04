<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqExporterSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'faq_exporter_id' => $this->faq_exporter_id,
            'language_id' => $this->language_id,
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
            'faq_exporter_setting' => new FaqExporterSettingResource($this->whenLoaded('faqExporterSetting')),
        ];
    }
}
