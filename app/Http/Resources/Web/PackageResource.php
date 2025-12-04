<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'package_type' => $this->package_type,

            'monthly_price' => $this->monthly_price,
            'quarterly_price' => $this->quarterly_price,
            'semi_annual_price' => $this->semi_annual_price,
            'annual_price' => $this->annual_price,

            'is_default' => $this->is_default,
            // 'sorting_order' => $this->sorting_order,
            'events_allowed' => $this->events_allowed,
            'images_allowed' => $this->images_allowed,
            'event_price' => $this->event_price,


            'stripe_product_id' => $this->stripe_product_id,


            
            'package_detail' => PackageDetailResource::collection($this->whenLoaded('packageDetail')),
            'package_feature' => PackageFeatureResource::collection($this->whenLoaded('packageFeature')),
        ];
    }
}
