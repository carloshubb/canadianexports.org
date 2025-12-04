<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationPackageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'package_type' => $this->package_type,
            
            'monthly_price' => $this->monthly_price,
            'quarterly_price' => $this->quarterly_price,
            'semi_annually_price' => $this->semi_annually_price,
            'annually_price' => $this->annually_price,
            
            'stripe_monthly_id' => $this->stripe_monthly_id,
            'stripe_quarterly_id' => $this->stripe_quarterly_id,
            'stripe_semi_annually_id' => $this->stripe_semi_annually_id,
            'stripe_annually_id' => $this->stripe_annually_id,
            
            'paypal_auto_renew_monthly_id' => $this->paypal_auto_renew_monthly_id,
            'paypal_auto_renew_quarterly_id' => $this->paypal_auto_renew_quarterly_id,
            'paypal_auto_renew_semi_annually_id' => $this->paypal_auto_renew_semi_annually_id,
            
            'paypal_auto_renew_annually_id' => $this->paypal_auto_renew_annually_id,
            'paypal_non_auto_renew_monthly_id' => $this->paypal_non_auto_renew_monthly_id,
            'paypal_non_auto_renew_quarterly_id' => $this->paypal_non_auto_renew_quarterly_id,
            'paypal_non_auto_renew_semi_annually_id' => $this->paypal_non_auto_renew_semi_annually_id,
            'paypal_non_auto_renew_annually_id' => $this->paypal_non_auto_renew_annually_id,
            
            'is_default' => $this->is_default,
            // 'sorting_order' => $this->sorting_order,
            'events_allowed' => $this->events_allowed,
            'images_allowed' => $this->images_allowed,
            'event_price' => $this->event_price,
            'event_stripe_id' => $this->event_stripe_id,
            'event_paypal_id' => $this->event_paypal_id,
            'registration_package_detail' => RegistrationPackageDetailResource::collection($this->whenLoaded('registrationPackageDetail')),
            'registration_package_feature' => RegistrationPackageFeatureResource::collection($this->whenLoaded('registrationPackageFeature')),
        ];
    }
}
