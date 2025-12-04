<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'verify_customer_email' => $this->verify_customer_email,
            'stripe_customer_id' => $this->stripe_customer_id,
            'is_active' => $this->is_active,
            'subscription_status' => $this->subscription_status,
            'active_email_url' => $this->active_email_url,
            'type' => $this->type,
            'business_name' => $this->business_name,
            'registration_package_id' => $this->registration_package_id,
            'payment_frequency' => $this->payment_frequency,
            'package_price' => $this->package_price,
            'package_subscribed_date' => $this->package_subscribed_date,
            'package_expiry_date' => $this->package_expiry_date,
            'is_package_expire' => $this->package_expiry_date == null || date('Y-m-d', strtotime($this->package_expiry_date)) < date('Y-m-d') ? 1 : 0,
            'is_package_amount_paid' => $this->is_package_amount_paid,
            'events_allowed' => $this->events_allowed,
            'events_remaining' => $this->events_remaining,
            'images_allowed' => $this->images_allowed,
            'registration_package' => new RegistrationPackageResource($this->whenLoaded('registrationPackage')),
            'customer_business_categories' => CustomerBusinessCategoryResource::collection($this->whenLoaded('customerBusinessCategory')),
            'customer_media' => new CustomerMediaResource($this->whenLoaded('customerMedia')),
            'customer_profile' => new CustomerProfileResource($this->whenLoaded('customerProfile')),
            'customer_social_media' => new CustomerSocialMediaResource($this->whenLoaded('customerSocialMedia')),
            'profile_image' => new MediaResource($this->whenLoaded('profileImage')),
        ];
    }
}
