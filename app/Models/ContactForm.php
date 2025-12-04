<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    use HasFactory;

    protected $table = 'contact_form';

    protected $guarded = [];

    
    public function emailSentByUser()
    {
        return $this->belongsTo(Customer::class, 'email_sent_by', 'id');
    }

}
