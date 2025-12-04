<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventSignupSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'event_signup_setting_detail' => EventSignupSettingDetailResource::collection($this->whenLoaded('eventSignupSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
