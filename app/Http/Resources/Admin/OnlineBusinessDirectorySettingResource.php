<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OnlineBusinessDirectorySettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'online_business_directory_setting_detail' => OnlineBusinessDirectorySettingDetailResource::collection($this->whenLoaded('onlineBusinessDirectorySettingDetail')),
        ];
    }
}
