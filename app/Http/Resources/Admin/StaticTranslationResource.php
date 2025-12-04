<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StaticTranslationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'display_text' => $this->display_text,
            'type' => $this->type,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'static_translation_detail' => StaticTranslationDetailResource::collection($this->whenLoaded('staticTranslationDetail')),
        ];
    }
}
