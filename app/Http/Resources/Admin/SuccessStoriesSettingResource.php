<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessStoriesSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'success_stories_setting_detail' => SuccessStoriesSettingDetailResource::collection($this->whenLoaded('successStoriesSettingDetail')),
        ];
    }
}
