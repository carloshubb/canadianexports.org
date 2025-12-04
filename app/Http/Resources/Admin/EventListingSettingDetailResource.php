<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventListingSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_listing_setting_id' => $this->event_listing_setting_id,
            'language_id' => $this->language_id,
            'event_heading_text' => $this->event_heading_text,
            'no_event_found_text' => $this->no_event_found_text,
            'user_has_events_text' => $this->user_has_events_text,
            'add_event_btn_text' => $this->add_event_btn_text,
            'upgrade_profile_btn_text' => $this->upgrade_profile_btn_text,
            'search_placeholder_text' => $this->search_placeholder_text,
            'show_text' => $this->show_text,
            'events_text' => $this->events_text,
            'title_text' => $this->title_text,
            'action_text' => $this->action_text,
            'edit_button_text' => $this->edit_button_text,
            'start_at_end_at_text' => $this->start_at_end_at_text,

            'event_listing_setting' => new EventListingSettingResource($this->whenLoaded('eventListingSetting')),
        ];
    }
}
