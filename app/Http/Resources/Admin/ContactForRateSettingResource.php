<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactForRateSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'contact_for_rate_setting_detail' => ContactForRateSettingDetailResource::collection($this->whenLoaded('contactForRateSettingDetail')),
        ];
    }
}
