<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventMediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'media_id' => $this->media_id,
            'media' => new MediaResource($this->whenLoaded('media')),
        ];
    }
}
