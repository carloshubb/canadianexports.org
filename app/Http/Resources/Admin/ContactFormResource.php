<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactFormResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email_sent_by' => $this->email_sent_by,
            'customer_profile_id' => $this->customer_profile_id,
            'name' => $this->name,
            'type' => $this->type,
            'email' => $this->email,
            'message' => $this->message,
            'type' => $this->type,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'email_sent_by_user' => new CustomerResource($this->whenLoaded('emailSentByUser')),
        ];
    }
}
