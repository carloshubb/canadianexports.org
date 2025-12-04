<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BecomeSponsorSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'become_sponsor_setting_detail' => BecomeSponsorSettingDetailResource::collection($this->whenLoaded('becomeSponsorSettingDetail')),
        ];
    }
}
