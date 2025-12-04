<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class CoffeeWallPackageDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'package_id' => $this->package_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'coffee_wall_package' => new CoffeeWallPackageResource($this->whenLoaded('coffeeWallPackage')),
        ];
    }
}
