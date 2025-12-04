<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'business_category_detail' => BusinessCategoryDetailResource::collection($this->whenLoaded('businessCategoryDetail')),
        ];
    }
}
