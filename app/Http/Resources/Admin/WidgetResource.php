<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class WidgetResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_code' => $this->short_code,
            'type' => $this->type,
            'layout' => $this->layout,
            'image_path' => $this->image_path,
            'image_path_2' => $this->image_path_2,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
            'widget_detail' => WidgetDetailResource::collection($this->whenLoaded('widgetDetail')),
            'media' => new MediaResource($this->whenLoaded('media')),
            'media2' => new MediaResource($this->whenLoaded('media2')),
        ];
    }
}
