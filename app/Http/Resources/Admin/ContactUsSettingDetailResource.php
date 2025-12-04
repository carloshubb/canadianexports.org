<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contact_us_setting_id' => $this->contact_us_setting_id,
            'language_id' => $this->language_id,
            'page_heading' => $this->page_heading,
            'page_description' => $this->page_description,
            'mail_address_label' => $this->mail_address_label,
            'mail_address' => $this->mail_address,
            'website_label' => $this->website_label,
            'website' => $this->website,
            'toll_free_label' => $this->toll_free_label,
            'toll_free' => $this->toll_free,
            'general_inquires_label' => $this->general_inquires_label,
            'general_inquires' => $this->general_inquires,
            'telephone_label' => $this->telephone_label,
            'telephone' => $this->telephone,
            'sales_department_label' => $this->sales_department_label,
            'sales_department' => $this->sales_department,
            'fax_label' => $this->fax_label,
            'fax' => $this->fax,
            'job_at_canadian_exporters_label' => $this->job_at_canadian_exporters_label,
            'job_at_canadian_exporters' => $this->job_at_canadian_exporters,
            'e_mail_label' => $this->e_mail_label,
            'e_mail' => $this->e_mail,
            'office_hours_label' => $this->office_hours_label,
            'office_hours' => $this->office_hours,
            'heading' => $this->heading,
            'required_field_text' => $this->required_field_text,
            'name_label' => $this->name_label,
            'name_error' => $this->name_error,
            'email_label' => $this->email_label,
            'email_error' => $this->email_error,
            'message_label' => $this->message_label,
            'message_error' => $this->message_error,
            'button_text' => $this->button_text,

            'contact_us_setting' => new ContactUsSettingResource($this->whenLoaded('ContactUsSetting')),
        ];
    }
}
