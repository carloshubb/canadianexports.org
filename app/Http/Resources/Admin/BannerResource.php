<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'url' => $this->url,
            'media_id' => $this->media_id,
            'image' => $this->image,
            'business_name' => $this->business_name,
            'is_visible' => $this->is_visible,
            'small_business_description' => $this->small_business_description,
            'detail_description' => $this->detail_description,
            'contact_number' => $this->contact_number,
            'is_active' => $this->is_active,
            'time_to_call' => $this->time_to_call,
            'appointment' => $this->appointment,
            'appointment_date' => $this->appointment_date,
            'message' => $this->message,
            'media' => new MediaResource($this->whenLoaded('media')),
            'media_image' => new MediaResource($this->whenLoaded('mediaImage')),
        ];
    }
}
