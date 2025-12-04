<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsPageSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'about_us_page_setting_detail' => AboutUsPageSettingDetailResource::collection($this->whenLoaded('aboutUsPageSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
