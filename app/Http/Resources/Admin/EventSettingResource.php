<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'event_setting_detail' => EventSettingDetailResource::collection($this->whenLoaded('eventSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
