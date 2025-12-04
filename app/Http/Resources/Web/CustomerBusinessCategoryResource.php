<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerBusinessCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'business_category_id' => $this->business_category_id,
            'customer_profile_id' => $this->customer_profile_id,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'business_category' => new BusinessCategoryResource($this->whenLoaded('businessCategory')),
            'customer_profile' => new CustomerProfileResource($this->whenLoaded('customerProfile')),
        ];
    }
}
