<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class I2bResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'business_category_id' => $this->business_category_id,
            'business_category_id_2' => $this->business_category_id_2,
            'business_category_id_3' => $this->business_category_id_3,
            'deadline_date' => date('m/d/Y', strtotime($this->deadline_date)),
            'deadline_date_val' => $this->deadline_date,
            'estimated_value' => $this->estimated_value,
            'pdf_1' => $this->pdf_1,
            'pdf_2' => $this->pdf_2,
            'pdf_3' => $this->pdf_3,
            'email' => $this->email,
            'pdf_1_path' => asset($this->pdf_1),
            'pdf_2_path' => asset($this->pdf_2),
            'pdf_3_path' => asset($this->pdf_3),
            'business_category_name' => $this->business_category_name,
            'business_category_name_2' => $this->business_category_name_2,
            'business_category_name_3' => $this->business_category_name_3,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'i2b_detail' => I2bDetailResource::collection($this->whenLoaded('i2bDetail')),
            'business_category' => new BusinessCategoryResource($this->whenLoaded('businessCategory')),
            'business_category2' => new BusinessCategoryResource($this->whenLoaded('businessCategory2')),
            'business_category3' => new BusinessCategoryResource($this->whenLoaded('businessCategory3')),
        ];
    }
}
