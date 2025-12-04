<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqImporterSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'faq_importer_setting_detail' => FaqImporterSettingDetailResource::collection($this->whenLoaded('faqImporterSettingDetail')),
        ];
    }
}
