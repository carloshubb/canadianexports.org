<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'business_category_detail' => BusinessCategoryDetailResource::collection($this->whenLoaded('businessCategoryDetail')),
        ];
    }
}
