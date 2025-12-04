<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'native_name' => $this->native_name,
            'direction' => $this->direction,
            'is_default' => $this->is_default == '1' ? 1 : 0,
            'flag_icon' => new MediaResource($this->whenLoaded('flagIcon')),
        ];
    }
}
