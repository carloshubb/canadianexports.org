<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function eventDetail()
    {
        return $this->hasMany(EventDetail::class, 'event_id', 'id');
    }

    public function eventMedia()
    {
        return $this->hasMany(EventMedia::class, 'event_id', 'id');
    }

    public function eventContacts()
    {
        return $this->hasMany(EventContact::class, 'event_id', 'id');
    }
    public function registrationPackage()
{
    return $this->belongsTo(RegistrationPackage::class, 'registration_package_id');
}
}
