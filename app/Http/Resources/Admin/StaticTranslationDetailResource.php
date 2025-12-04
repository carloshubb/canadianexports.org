<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StaticTranslationDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'static_translation_id' => $this->static_translation_id,
            'language_id' => $this->language_id,
            'display_text' => $this->display_text,
            'key' => $this->key,
            'value' => $this->value,
            'static_translation' => new StaticTranslationResource($this->whenLoaded('staticTranslation')),
        ];
    }
}
