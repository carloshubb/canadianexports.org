<?php

namespace App\Http\Resources\Admin;

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
            'cta_btn' => $this->cta_btn,
            'cta_link' => $this->cta_link,
            'customer_id' => $this->customer_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            // 'visitor_count' => $this->businessProfileStats()->count(),
            'customer_business_categories' => CustomerBusinessCategoryResource::collection($this->whenLoaded('customerBusinessCategory')),
            'customer_media' => new CustomerMediaResource($this->whenLoaded('customerMedia')),
            'customer_social_media' => new CustomerSocialMediaResource($this->whenLoaded('customerSocialMedia')),
        ];
    }
}
