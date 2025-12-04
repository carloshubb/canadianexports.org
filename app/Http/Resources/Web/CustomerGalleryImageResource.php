<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerGalleryImageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'customer_media_id' => $this->customer_media_id,
            'media_id' => $this->media_id,
            'customer_media' => new CustomerMediaResource($this->whenLoaded('customerMedia')),
            'media' => new MediaResource($this->whenLoaded('media')),
        ];
    }
}
