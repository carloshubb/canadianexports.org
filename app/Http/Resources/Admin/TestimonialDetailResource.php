<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'testimonial_id' => $this->testimonial_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'place' => $this->place,
            'comment' => $this->comment,
            'email' => $this->email,
            'primary_industry' => $this->primary_industry,
            'testimonial' => new TestimonialResource($this->whenLoaded('testimonial')),
        ];
    }
}
