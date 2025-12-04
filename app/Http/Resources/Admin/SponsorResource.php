<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SponsorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'business_name' => $this->business_name,
            'slug' => $this->slug,
            'contact_name' => $this->contact_name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'url' => $this->url,
            'summary' => $this->summary,
            'detail_description' => $this->detail_description,
            'message' => $this->message,
            
            // Sponsorship details
            'sponsorship_type' => $this->sponsorship_type,
            'sponsorship_amount' => $this->sponsorship_amount,
            'talk_to_us_first' => $this->talk_to_us_first,
            'preferred_call_time' => $this->preferred_call_time,
            'preferred_call_date' => $this->preferred_call_date,
            'talk_to_us_name' => $this->talk_to_us_name,
            'talk_to_us_phone' => $this->talk_to_us_phone,
            
            // Payment info
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'paid_at' => $this->paid_at?->format('Y-m-d H:i:s'),
            
            // Status
            'status' => $this->status,
            'is_visible' => $this->is_visible,
            
            // Relationships
            'customer_id' => $this->customer_id,
            'beneficiary_id' => $this->beneficiary_id,
            'beneficiary' => $this->whenLoaded('beneficiary'),
            'beneficiaries' => $this->whenLoaded('beneficiaries', function () {
                return $this->beneficiaries->map(function ($beneficiary) {
                    return [
                        'id' => $beneficiary->id,
                        'name' => $beneficiary->name,
                    ];
                });
            }),
            'logo_media' => $this->whenLoaded('logoMedia'),
            'featured_media' => $this->whenLoaded('featuredMedia'),
            'customer' => $this->whenLoaded('customer'),
            
            // Timestamps
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}

