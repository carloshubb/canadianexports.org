<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessCategoryDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'business_category_id' => $this->business_category_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
