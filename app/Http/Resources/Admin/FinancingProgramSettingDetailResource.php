<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancingProgramSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'financing_program_setting_id' => $this->financing_program_setting_id,
            'language_id' => $this->language_id,
            'required_fields_text' => $this->required_fields_text,
            'zipcode_label' => $this->zipcode_label,
            'zipcode_placeholder' => $this->zipcode_placeholder,
            'zipcode_error' => $this->zipcode_error,
            'incorporation_label' => $this->incorporation_label,
            'incorporation_placeholder' => $this->incorporation_placeholder,
            'incorporation_error' => $this->incorporation_error,
            'business_name_label' => $this->business_name_label,
            'business_name_placeholder' => $this->business_name_placeholder,
            'business_name_error' => $this->business_name_error,
            'name_title_label' => $this->name_title_label,
            'name_title_placeholder' => $this->name_title_placeholder,
            'name_title_error' => $this->name_title_error,
            'email_label' => $this->email_label,
            'email_placeholder' => $this->email_placeholder,
            'email_error' => $this->email_error,
            'full_time_employees_label' => $this->full_time_employees_label,
            'full_time_employees_placeholder' => $this->full_time_employees_placeholder,
            'full_time_employees_error' => $this->full_time_employees_error,
            'revenue_last_year_label' => $this->revenue_last_year_label,
            'revenue_last_year_placeholder' => $this->revenue_last_year_placeholder,
            'revenue_last_year_error' => $this->revenue_last_year_error,
            'company_ownership_label' => $this->company_ownership_label,
            'company_ownership_placeholder' => $this->company_ownership_placeholder,
            'company_ownership_error' => $this->company_ownership_error,
            'needs_intentions_label' => $this->needs_intentions_label,
            'needs_intentions_placeholder' => $this->needs_intentions_placeholder,
            'needs_intentions_error' => $this->needs_intentions_error,
            'primary_industry_label' => $this->primary_industry_label,
            'primary_industry_placeholder' => $this->primary_industry_placeholder,
            'primary_industry_error' => $this->primary_industry_error,
            'submit_button_text' => $this->submit_button_text,
            'financing_program_setting' => new FinancingProgramSettingResource($this->whenLoaded('financingProgramSetting')),
        ];
    }
}
