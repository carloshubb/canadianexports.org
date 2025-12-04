<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerInquiry extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = [];

    public function i2b()
    {
        return $this->belongsTo(I2b::class);
    }

    public function registrationPackage()
    {
        return $this->belongsTo(RegistrationPackage::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
