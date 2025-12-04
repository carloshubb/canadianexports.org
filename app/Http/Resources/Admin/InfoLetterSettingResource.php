<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class InfoLetterSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'info_letter_setting_detail' => InfoLetterSettingDetailResource::collection($this->whenLoaded('infoLetterSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
