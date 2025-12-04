<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class HolidayEmailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email_subject' => $this->email_subject,
            'email_content' => $this->email_content,
            'holidays_from' => $this->holidays_from,
            'holidays_from_formetted' => date('m/d/Y', strtotime($this->holidays_from)),
            'holidays_to' => $this->holidays_to,
            'holidays_to_formetted' => date('m/d/Y', strtotime($this->holidays_to)),
            'email_sent_date' => $this->email_sent_date,
            'email_sent_date_formetted' => date('m/d/Y', strtotime($this->email_sent_date)),
            'is_email_sent' => $this->is_email_sent,
        ];
    }
}
