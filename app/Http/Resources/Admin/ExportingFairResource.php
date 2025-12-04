<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ExportingFairResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'zipcode' => $this->zipcode,
            'media_id' => $this->media_id,
            'video_url' => $this->video_url,
            'start_date' => \Request::route()->getName() == 'exporting-fairs.show' ? $this->start_date : date('m/d/Y', strtotime($this->start_date)),
            'end_date' => \Request::route()->getName() == 'exporting-fairs.show' ? $this->end_date  : date('m/d/Y', strtotime($this->end_date)),
            'booth_number' => $this->booth_number,
            'event_website' => $this->event_website,
            'exibitors_url' => $this->exibitors_url,
            'visitors_url' => $this->visitors_url,
            'press_url' => $this->press_url,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'contact_designation' => $this->contact_designation,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'pintrest_url' => $this->pintrest_url,
            'instagram_url' => $this->instagram_url,
            'snapchat_url' => $this->snapchat_url,
            'payment_method' => $this->payment_method,
            'payment_method_id' => $this->payment_method_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'exporting_fair_detail' => ExportingFairDetailResource::collection($this->whenLoaded('exportingFairDetail')),
            'media' => new MediaResource($this->whenLoaded('media')),
        ];
    }
}
