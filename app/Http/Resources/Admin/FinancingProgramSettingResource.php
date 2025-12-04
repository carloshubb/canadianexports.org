<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancingProgramSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'financing_program_setting_detail' => FinancingProgramSettingDetailResource::collection($this->whenLoaded('financingProgramSettingDetail')),
        ];
    }
}
