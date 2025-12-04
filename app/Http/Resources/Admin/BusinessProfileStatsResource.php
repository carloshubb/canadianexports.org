<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessProfileStatsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_profile_id' => $this->customer_profile_id,
            'visitor_info_id' => $this->visitor_info_id,
            'type' => $this->type,
            'visitor' => new VisitorResource($this->whenLoaded('visitor')),
            'customer_profile' => new CustomerProfileResource($this->whenLoaded('customerProfile')),
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
        ];
    }
}
