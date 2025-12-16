<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\WebinarRegistration;

class Webinar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'presenter_name',
        'presenter_bio',
        'presenter_image',
        'scheduled_at',
        'duration_minutes',
        'meeting_link',
        'meeting_platform',
        'cover_image',
        'max_attendees',
        'status',
        'is_recorded',
        'recording_url',
        'keywords',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_recorded' => 'boolean',
        'keywords' => 'array',
    ];

    protected $appends = ['registrations_count', 'available_seats'];

    public function registrations()
    {
        return $this->hasMany(WebinarRegistration::class);
    }

    public function activeRegistrations()
    {
        return $this->hasMany(WebinarRegistration::class)
            ->where('status', '!=', 'cancelled');
    }

    public function getRegistrationsCountAttribute()
    {
        return $this->activeRegistrations()->count();
    }

    public function getAvailableSeatsAttribute()
    {
        if (!$this->max_attendees) {
            return 'Unlimited';
        }
        
        $remaining = $this->max_attendees - $this->registrations_count;
        return max(0, $remaining);
    }

    public function isFull()
    {
        if (!$this->max_attendees) {
            return false;
        }
        
        return $this->registrations_count >= $this->max_attendees;
    }

    public function isUpcoming()
    {
        return $this->scheduled_at > now();
    }

    public function isPast()
    {
        return $this->scheduled_at < now();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('scheduled_at', '<', now());
    }
}