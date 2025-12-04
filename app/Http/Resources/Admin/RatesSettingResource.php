<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RatesSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'rates_setting_detail' => RatesSettingDetailResource::collection($this->whenLoaded('ratesSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),
        ];
    }
}
