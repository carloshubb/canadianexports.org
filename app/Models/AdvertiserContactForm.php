<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertiserContactForm extends Model
{
    use HasFactory;

    protected $table = 'advertiser_contact_form';

    protected $guarded = [];

    public function emailSentByUser()
    {
        return $this->belongsTo(Customer::class, 'email_sent_by', 'id');
    }

    public function customerProfile()
    {
        return $this->belongsTo(CustomerProfile::class, 'customer_profile_id', 'id');
    }

}
