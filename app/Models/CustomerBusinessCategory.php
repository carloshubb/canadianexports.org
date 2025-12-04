<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBusinessCategory extends Model
{
    use HasFactory;


    public $timestamps = false;

    protected $fillable = ['customer_id', 'business_category_id', 'customer_profile_id'];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerProfile()
    {
        return $this->belongsTo(CustomerProfile::class);
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class);
    }

}
