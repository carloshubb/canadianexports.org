<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'company_email' => $this->company_email,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'phone' => $this->phone,
            'website' => $this->website,
            'keywords' => $this->keywords,
            'address' => $this->address,
            'customer_id' => $this->customer_id,
            'cta_btn' => $this->cta_btn,
            'cta_link' => $this->cta_link,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'customerBusinessCategory' => new CustomerBusinessCategoryResource($this->whenLoaded('customerBusinessCategory')),
            'customerMedia' => new CustomerMediaResource($this->whenLoaded('customerMedia')),
            'customerSocialMedia' => new CustomerSocialMediaResource($this->whenLoaded('customerSocialMedia')),
        ];
    }
}
