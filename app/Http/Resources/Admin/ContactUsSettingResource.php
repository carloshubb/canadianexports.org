<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'contact_us_setting_detail' => ContactUsSettingDetailResource::collection($this->whenLoaded('contactUsSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
