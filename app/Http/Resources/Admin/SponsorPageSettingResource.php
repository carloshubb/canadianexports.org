<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SponsorPageSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'sponsor_page_setting_detail' => SponsorPageSettingDetailResource::collection($this->whenLoaded('sponsorPageSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
