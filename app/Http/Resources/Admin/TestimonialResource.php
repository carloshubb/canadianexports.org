<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'business_category_id' => $this->business_category_id,
            'company_name' => $this->company_name,
            'status' => $this->status,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
            'testimonial_detail' => TestimonialDetailResource::collection($this->whenLoaded('testimonialDetail')),
            'business_category' => new BusinessCategoryResource($this->whenLoaded('businessCategory')),
        ];
    }
}
