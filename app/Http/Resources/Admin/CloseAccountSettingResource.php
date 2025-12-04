<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CloseAccountSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'close_account_setting_detail' => CloseAccountSettingDetailResource::collection($this->whenLoaded('closeAccountSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
