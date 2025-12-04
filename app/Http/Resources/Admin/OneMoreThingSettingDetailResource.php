<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OneMoreThingSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'one_more_thing_setting_id' => $this->one_more_thing_setting_id,
            'language_id' => $this->language_id,
            'page_heading' => $this->page_heading,
            'read_more_btn_text' => $this->read_more_btn_text,
            'one_more_thing_setting' => new OneMoreThingSettingResource($this->whenLoaded('oneMoreThingSetting')),
        ];
    }
}
