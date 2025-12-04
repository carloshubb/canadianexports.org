<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'menu_id' => $this->menu_id,
            'language_id' => $this->language_id,
            'menu_items' => json_decode($this->menu_items, 1),
            'menu' => new MenuResource($this->whenLoaded('menu')),
        ];
    }
}
