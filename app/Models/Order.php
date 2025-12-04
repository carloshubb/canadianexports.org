<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function registrationPackage()
    {
        return $this->belongsTo(RegistrationPackage::class);
    }
}
