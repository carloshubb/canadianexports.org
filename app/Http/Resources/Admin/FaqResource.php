<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
            'faq_detail' => FaqDetailResource::collection($this->whenLoaded('faqDetail')),
        ];
    }
}
