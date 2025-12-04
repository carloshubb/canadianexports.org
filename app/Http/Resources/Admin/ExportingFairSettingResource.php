<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ExportingFairSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'exporting_fair_setting_detail' => ExportingFairSettingDetailResource::collection($this->whenLoaded('exportingFairSettingDetail')),
        ];
    }
}
