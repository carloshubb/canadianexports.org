<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqExporterSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'faq_exporter_setting_detail' => FaqExporterSettingDetailResource::collection($this->whenLoaded('faqExporterSettingDetail')),
            'page' => new PageResource($this->whenLoaded('page')),

        ];
    }
}
