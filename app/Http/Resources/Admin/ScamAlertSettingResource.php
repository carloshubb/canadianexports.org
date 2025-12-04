<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ScamAlertSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'scam_alert_setting_detail' => ScamAlertSettingDetailResource::collection($this->whenLoaded('scamAlertSettingDetail')),
        ];
    }
}
