<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RegPageSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'reg_page_setting_detail' => RegPageSettingDetailResource::collection($this->whenLoaded('regPageSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
