<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerPaymentMethodResource extends JsonResource
{
    public function toArray($request)
    {
        $cardNumber = $this->card_no;
        $last4Digits = substr($cardNumber, -4);
        $maskedCardNumber = str_repeat("*", strlen($cardNumber) - 4) . $last4Digits;
        return [
            'id' => $this->id,
            'card_no' => $maskedCardNumber,
            'is_default' => $this->is_default,
        ];
    }
}
