<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventListingSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'event_listing_setting_detail' => EventListingSettingDetailResource::collection($this->whenLoaded('eventListingSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
