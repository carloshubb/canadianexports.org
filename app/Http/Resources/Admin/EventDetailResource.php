<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'language_id' => $this->language_id,
            'title' => $this->title,
            'country' => $this->country,
            'city' => $this->city,
            'street_name' => $this->street_name,
            'venue' => $this->venue,
            'product_search' => $this->product_search,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'event' => new EventResource($this->whenLoaded('event')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
