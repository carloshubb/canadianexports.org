<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSocialMedia extends Model
{
    use HasFactory;

    protected $table = 'customer_social_media';

    public $timestamps = false;

    protected $fillable = ['customer_id', 'facebook', 'twitter', 'youtube', 'linked_in', 'google', 'customer_profile_id', 'social_media5'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerProfile()
    {
        return $this->belongsTo(CustomerProfile::class);
    }
}
