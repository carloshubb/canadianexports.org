<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class CoffeeWallPackageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'custom' => $this->custom,
            'is_default' => $this->is_default,
            
            'stripe_product_id' => $this->stripe_product_id,
            'stripe_price_id' => $this->stripe_price_id,
            
            'paypal_product_id' => $this->paypal_product_id,
            'paypal_price_id' => $this->paypal_price_id,
            
            'coffee_wall_package_detail' => CoffeeWallPackageDetailResource::collection($this->whenLoaded('coffeeWallPackageDetail')),
        ];
    }
}
