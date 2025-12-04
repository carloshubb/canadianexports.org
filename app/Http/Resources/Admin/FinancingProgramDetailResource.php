<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancingProgramDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'financing_program_id' => $this->financing_program_id,
            'language_id' => $this->language_id,
            'name_title' => $this->name_title,
            'business_name' => $this->business_name,
            'zipcode' => $this->zipcode,
            'revenue_last_year' => $this->revenue_last_year,
            'full_time_employees' => $this->full_time_employees,
            'incorporation' => $this->incorporation,
            'company_ownership' => $this->company_ownership,
            'primary_industry' => $this->primary_industry,
            'needs_intentions' => $this->needs_intentions,
            'email' => $this->email,
            'financingProgram' => new FinancingProgramResource($this->whenLoaded('financingProgram')),
        ];
    }
}
