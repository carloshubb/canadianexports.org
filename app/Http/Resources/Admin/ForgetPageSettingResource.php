<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ForgetPageSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'forget_page_setting_detail' => ForgetPageSettingDetailResource::collection($this->whenLoaded('forgetPageSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
