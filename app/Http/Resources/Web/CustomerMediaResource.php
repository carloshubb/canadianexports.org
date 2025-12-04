<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerMediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'title' => $this->title,
            'description' => $this->description,
            'images' => $this->images,
            'logo' => $this->logo,
            'video' => $this->video,
            'video_frame' => $this->video_frame,
            'customer_profile_id' => $this->customer_profile_id,
            'customer_gallery_images' => CustomerGalleryImageResource::collection($this->whenLoaded('customerGalleryImages')),
            'customer_logo' => new MediaResource($this->whenLoaded('customerLogo')),
            'customer_profile' => new CustomerProfileResource($this->whenLoaded('customerProfile')),
        ];
    }
}
