<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDirectoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'industry' => $this->industry,
            'status' => $this->status,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'business_directory_detail' => BusinessDirectoryDetailResource::collection($this->whenLoaded('businessDirectoryDetail')),
        ];
    }
}
