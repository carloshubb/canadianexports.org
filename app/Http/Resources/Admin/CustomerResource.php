<?php

namespace App\Http\Resources\Admin;

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
            'is_account_closed' => $this->is_account_closed,
            'active_email_url' => $this->active_email_url,
            'type' => $this->type,
            'business_name' => $this->business_name,
            'events_allowed' => $this->events_allowed,
            'events_remaining' => $this->events_remaining,
            'package_subscribed_date' => isset($this->package_subscribed_date) ? date('F d, Y', strtotime($this->package_subscribed_date)) : null,
            'package_expiry_date' => isset($this->package_expiry_date) ? date('F d, Y', strtotime($this->package_expiry_date)) : null,
            'images_allowed' => $this->images_allowed,
            'is_package_amount_paid' => $this->is_package_amount_paid,
            'registration_package_id' => $this->registration_package_id,
            'payment_frequency' => $this->payment_frequency,
            'package_price' => $this->package_price,
            'registration_package' => $this->whenLoaded('registrationPackage'),
            'customer_business_category' => $this->whenLoaded('customerBusinessCategory'),
            'customer_media' => new CustomerMediaResource($this->whenLoaded('customerMedia')),
            'customer_profile' => $this->whenLoaded('customerProfile'),
            'customer_social_media' => $this->whenLoaded('customerSocialMedia'),
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
        ];
    }
}
