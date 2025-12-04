<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'faq_id' => $this->faq_id,
            'language_id' => $this->language_id,
            'question' => $this->question,
            'answer' => $this->answer,
            'faq' => new FaqResource($this->whenLoaded('faq')),
        ];
    }
}
