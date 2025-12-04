<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class WidgetDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'widget_id' => $this->widget_id,
            'language_id' => $this->language_id,
            'text_detail' => $this->text_detail,
            'button_text' => $this->button_text,
            'button_link' => $this->button_link,
            'action' => $this->action,
            'widget' => new WidgetResource($this->whenLoaded('widget')),
        ];
    }
}
