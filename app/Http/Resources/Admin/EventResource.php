<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'zipcode' => $this->zipcode,
            'featured' => $this->featured,
            'media_id' => $this->media_id,
            'registration_package' => $this->registrationPackage,
            'customer' => $this->when($this->customer, function () {
                return [
                    'id' => optional($this->customer)->id,
                    'registration_package' => optional($this->customer)->registrationPackage,
                ];
            }),
            'video_url' => $this->video_url,
            'slug' => $this->slug,
            'start_date' => \Request::route()->getName() == 'events.show' ? $this->start_date : date('m/d/Y', strtotime($this->start_date)),
            'end_date' => \Request::route()->getName() == 'events.show' ? $this->end_date  : date('m/d/Y', strtotime($this->end_date)),
            'event_website' => $this->event_website,
            'exibitors_url' => $this->exibitors_url,
            'visitors_url' => $this->visitors_url,
            'press_url' => $this->press_url,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'pintrest_url' => $this->pintrest_url,
            'instagram_url' => $this->instagram_url,
            'snapchat_url' => $this->snapchat_url,
            'payment_method' => $this->payment_method,
            'payment_method_id' => $this->payment_method_id,
            'show_page' => $this->show_page,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'event_detail' => EventDetailResource::collection($this->whenLoaded('eventDetail')),
            'event_media' => EventMediaResource::collection($this->whenLoaded('eventMedia')),
            'event_contacts' => EventContactResource::collection($this->whenLoaded('eventContacts')),
            'media' => new MediaResource($this->whenLoaded('media')),
        ];
    }
}