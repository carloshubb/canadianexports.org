<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_main_menu' => $this->is_main_menu,
            'is_footer_menu' => $this->is_footer_menu,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'menu_detail' => MenuDetailResource::collection($this->whenLoaded('menuDetail')),
        ];
    }
}
