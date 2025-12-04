<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessStoriesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'business_category_id' => $this->business_category_id,
            // 'company_name' => $this->company_name,
            'status' => $this->status,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
            'success_stories_details' => SuccessStoriesDetailResource::collection($this->whenLoaded('successStoriesDetail')),
            'business_category' => new BusinessCategoryResource($this->whenLoaded('businessCategory')),
        ];
    }
}
