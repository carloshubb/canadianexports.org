<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ip_address' => $this->ip_address,
            'country' => $this->country,
            'country_code' => $this->country_code,
            'state' => $this->state,
            'city' => $this->city,
            'address' => $this->address,
            'browser' => $this->browser,
            'browser_version' => $this->browser_version,
            'platform' => $this->platform,
            'user_agent' => $this->user_agent,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
        ];
    }
}
