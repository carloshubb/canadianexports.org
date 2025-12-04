<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDirectoryDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'business_directory_id' => $this->business_directory_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'business_directory' => new BusinessDirectoryResource($this->whenLoaded('businessDirectory')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
