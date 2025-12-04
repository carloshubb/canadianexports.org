<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class InfoLetterResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email_sent_by' => $this->email_sent_by,
            'company_name' => $this->company_name,
            'name' => $this->name,
            'email' => $this->email,
            'country' => $this->country,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'email_sent_by_user' => new CustomerResource($this->whenLoaded('emailSentByUser')),
        ];
    }
}
