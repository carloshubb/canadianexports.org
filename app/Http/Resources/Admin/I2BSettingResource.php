<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class I2BSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'i2b_setting_detail' => I2BSettingDetailResource::collection($this->whenLoaded('i2BSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
