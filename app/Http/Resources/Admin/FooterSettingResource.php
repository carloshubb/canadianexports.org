<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FooterSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fb_link' => $this->fb_link,
            'twitter_link' => $this->twitter_link,
            'google_link' => $this->google_link,
            'youtube_link' => $this->youtube_link,
            'linkedin_link' => $this->linkedin_link,
            'is_active' => $this->is_active,
            'widget1_menu_id' => $this->widget1_menu_id,
            'widget2_menu_id' => $this->widget2_menu_id,
            'widget3_menu_id' => $this->widget3_menu_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'widget1_menu' => new MenuResource($this->whenLoaded('widget1Menu')),
            'widget2_menu' => new MenuResource($this->whenLoaded('widget2Menu')),
            'widget3_menu' => new MenuResource($this->whenLoaded('widget3Menu')),
            'footer_setting_detail' => FooterSettingDetailResource::collection($this->whenLoaded('footerSettingDetail')),
        ];
    }
}
