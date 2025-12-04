<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Web\RegistrationPackageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'registration_package_id' => $this->registration_package_id,
            'no_of_emails' => $this->no_of_emails,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'registration_package' => new RegistrationPackageResource($this->whenLoaded('registrationPackage')),
        ];
    }
}
