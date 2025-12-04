<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class I2bDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'i2b_id' => $this->i2b_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'country_name' => $this->country_name,
            'i2b' => new I2bResource($this->whenLoaded('i2b')),
        ];
    }
}
