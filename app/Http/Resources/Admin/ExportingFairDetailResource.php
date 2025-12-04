<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ExportingFairDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'exporting_fair_id' => $this->exporting_fair_id,
            'language_id' => $this->language_id,
            'title' => $this->title,
            'address' => $this->address,
            'country' => $this->country,
            'city' => $this->city,
            'street_name' => $this->street_name,
            'zipcode' => $this->zipcode,
            'product_search' => $this->product_search,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'exporting_fair' => new ExportingFairResource($this->whenLoaded('exportingFair')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
