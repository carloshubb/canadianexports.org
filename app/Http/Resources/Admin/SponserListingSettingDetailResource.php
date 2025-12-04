<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SponserListingSettingDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sponser_list_setting_id' => $this->sponser_list_setting_id,
            'language_id' => $this->language_id,
            'sponser_heading_text' => $this->sponser_heading_text,
            'no_sponser_found_text' => $this->no_sponser_found_text,
            'user_has_sponser_text' => $this->user_has_sponser_text,
            'add_sponser_btn_text' => $this->add_sponser_btn_text,
            'upgrade_profile_btn_text' => $this->upgrade_profile_btn_text,
            'search_placeholder_text' => $this->search_placeholder_text,
            'show_text' => $this->show_text,
            'sponser_text' => $this->sponser_text,
            'title_text' => $this->title_text,
            'action_text' => $this->action_text,
            'edit_button_text' => $this->edit_button_text,
            'start_at_end_at_text' => $this->start_at_end_at_text,

            'sponser_listing_setting' => new SponserListingSettingResource($this->whenLoaded('sponserListingSetting')),
        ];
    }
}
