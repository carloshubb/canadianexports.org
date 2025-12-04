<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerSocialMediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'linked_in' => $this->linked_in,
            'google' => $this->google,
            'customer_profile_id' => $this->customer_profile_id,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'customer_profile' => new CustomerProfileResource($this->whenLoaded('customerProfile')),
        ];
    }
}
