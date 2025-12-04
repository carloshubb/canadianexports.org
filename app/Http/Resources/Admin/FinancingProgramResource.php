<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancingProgramResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'business_category_id' => $this->business_category_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
            'financing_program_details' => FinancingProgramDetailResource::collection($this->whenLoaded('financingProgramDetail')),
            'business_category' => new BusinessCategoryResource($this->whenLoaded('businessCategory')),
        ];
    }
}
