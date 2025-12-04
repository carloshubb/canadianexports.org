<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CoffeeWalletsResource extends JsonResource
{
    public function toArray($request)
    {
        $beneficiaries = $this->beneficiaries instanceof \Illuminate\Support\Collection
            ? $this->beneficiaries
            : collect($this->beneficiaries ?? []);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'beneficiary_id' => optional($beneficiaries->first())->id ?? $this->beneficiary_id,
            'beneficiary_ids' => $beneficiaries->pluck('id')->values(),
            'beneficiary_names' => $beneficiaries->pluck('name')->values(),
            'dr_amount' => $this->dr_amount,
            'customer_profile' => new CustomerResource($this->whenLoaded('userInfo')),
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'updated_at' => date('m/d/Y H:i:s', strtotime($this->updated_at)),
        ];
    }
}
