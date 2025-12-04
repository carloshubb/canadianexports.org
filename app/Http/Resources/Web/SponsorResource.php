<?php

namespace App\Http\Resources\Web;

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
            'sponsorship_amount' => $this->sponsorship_amount,
            'status' => $this->status,
            'is_visible' => $this->is_visible,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'paid_at' => $this->paid_at?->format('Y-m-d H:i:s'),
            
            // Relationships
            'beneficiary' => $this->whenLoaded('beneficiary'),
            'beneficiaries' => $this->whenLoaded('beneficiaries', function () {
                return $this->beneficiaries->map(function ($beneficiary) {
                    return [
                        'id' => $beneficiary->id,
                        'name' => $beneficiary->name,
                    ];
                });
            }),
            'logo_media' => $this->whenLoaded('logoMedia', function() {
                return [
                    'id' => $this->logoMedia->id,
                    'path' => $this->logoMedia->path,
                    'medium_image' => $this->logoMedia->medium_image ?? $this->logoMedia->path,
                    'thumbnail' => $this->logoMedia->thumbnail ?? $this->logoMedia->path,
                ];
            }),
            'featured_media' => $this->whenLoaded('featuredMedia', function() {
                return [
                    'id' => $this->featuredMedia->id,
                    'path' => $this->featuredMedia->path,
                    'medium_image' => $this->featuredMedia->medium_image ?? $this->featuredMedia->path,
                    'thumbnail' => $this->featuredMedia->thumbnail ?? $this->featuredMedia->path,
                ];
            }),
            
            // Timestamps
            'created_at' => $this->created_at?->format('Y-m-d'),
        ];
    }
}

