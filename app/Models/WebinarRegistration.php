<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'webinar_id',
        'name',
        'email',
        'phone',
        'company',
        'status',
        'registered_at',
        'attended_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'attended_at' => 'datetime',
    ];

    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }

    public function markAsAttended()
    {
        $this->update([
            'status' => 'attended',
            'attended_at' => now(),
        ]);
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }
}