<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PageDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'meta_keywords' => $this->meta_keywords,
            'page_detail' => $this->page_detail,
            'edit_page_detail' => $this->edit_page_detail,
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
