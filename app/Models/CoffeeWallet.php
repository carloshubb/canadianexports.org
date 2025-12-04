<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeWallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    function userInfo(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    function beneficiary(){
        return $this->belongsTo(CoffeeWallBeneficiary::class, 'beneficiary_id');
    }

    public function beneficiaries()
    {
        return $this->belongsToMany(CoffeeWallBeneficiary::class, 'coffee_wallet_beneficiary');
    }
}
