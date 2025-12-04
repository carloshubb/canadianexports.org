<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationPackageDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'registration_package_id' => $this->registration_package_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'registration_package' => new RegistrationPackageResource($this->whenLoaded('registrationPackage')),
        ];
    }
}
