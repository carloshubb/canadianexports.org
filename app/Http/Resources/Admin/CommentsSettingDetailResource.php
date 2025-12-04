<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentsSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comments_setting_id' => $this->comments_setting_id,
            'language_id' => $this->language_id,
            'page_heading' => $this->page_heading,
            'page_description' => $this->page_description,
            'heading' => $this->heading,
            'required_field_text' => $this->required_field_text,
            'name_label' => $this->name_label,
            'name_error' => $this->name_error,
            'email_label' => $this->email_label,
            'email_error' => $this->email_error,
            'message_label' => $this->message_label,
            'message_error' => $this->message_error,
            'button_text' => $this->button_text,

            'comments_setting' => new CommentsSettingResource($this->whenLoaded('commentsSetting')),
        ];
    }
}
