<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'testimonial_setting_detail' => TestimonialSettingDetailResource::collection($this->whenLoaded('testimonialSettingDetail')),
        ];
    }
}
