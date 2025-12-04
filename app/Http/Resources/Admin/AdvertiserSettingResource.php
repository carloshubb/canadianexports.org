<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertiserSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'advertiser_setting_detail' => AdvertiserSettingDetailResource::collection($this->whenLoaded('advertiserSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
