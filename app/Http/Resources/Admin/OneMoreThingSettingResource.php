<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OneMoreThingSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'one_more_thing_setting_detail' => OneMoreThingSettingDetailResource::collection($this->whenLoaded('oneMoreThingSettingDetail')),
        ];
    }
}
