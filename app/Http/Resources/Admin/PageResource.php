<?php

namespace App\Http\Resources\Admin;

use App\Models\Widget;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'template' => $this->template,
            'is_home_page' => $this->is_home_page,
            'slug' => $this->slug,
            'meta_keywords' => $this->meta_keywords,
            'after_header_widget_id' => $this->after_header_widget_id,
            'after_header_widget' => Widget::select('id', 'name')->whereId($this->after_header_widget_id)->first() ?? null,
            'before_footer_widget_id' => $this->before_footer_widget_id,
            'before_footer_widget' => Widget::select('id', 'name')->whereId($this->before_footer_widget_id)->first() ?? null,
            'facebook_media_id' => $this->facebook_media_id,
            'facebook_media' => new MediaResource($this->whenLoaded('facebook')),
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
            'page_detail' => PageDetailResource::collection($this->whenLoaded('pageDetail')),
        ];
    }
}
