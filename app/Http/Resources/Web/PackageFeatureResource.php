<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageFeatureResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'package_id' => $this->package_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'package' => new PackageResource($this->whenLoaded('package')),
        ];
    }
}
