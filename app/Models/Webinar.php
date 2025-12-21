<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Webinar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'host_user_id',
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
        'webinar_type',
        'allow_qa',
        'allow_chat',
        'allow_private_messages',
        'is_recorded',
        'recording_url',
        'embed_code',
        'keywords',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_recorded' => 'boolean',
        'allow_qa' => 'boolean',
        'allow_chat' => 'boolean',
        'allow_private_messages' => 'boolean',
        'keywords' => 'array',
    ];

    protected $appends = ['registrations_count', 'available_seats', 'questions_count', 'unanswered_questions_count'];

    // Webinar types
    const TYPE_LIVE_INTERACTIVE = 'live_interactive';
    const TYPE_LIVE_VIEWONLY = 'live_viewonly';
    const TYPE_RECORDED = 'recorded';

    public function host()
    {
        return $this->belongsTo(Customer::class, 'host_user_id');
    }

    public function registrations()
    {
        return $this->hasMany(WebinarRegistration::class);
    }

    public function activeRegistrations()
    {
        return $this->hasMany(WebinarRegistration::class)
            ->where('status', '!=', 'cancelled');
    }

    public function questions()
    {
        return $this->hasMany(WebinarQuestion::class);
    }

    public function approvedQuestions()
    {
        return $this->hasMany(WebinarQuestion::class)
            ->whereIn('status', ['approved', 'answered'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('upvotes', 'desc')
            ->orderBy('created_at', 'asc');
    }

    public function pendingQuestions()
    {
        return $this->hasMany(WebinarQuestion::class)
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc');
    }

    public function messages()
    {
        return $this->hasMany(WebinarMessage::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(WebinarChatMessage::class);
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

    public function getQuestionsCountAttribute()
    {
        return $this->questions()->whereIn('status', ['pending', 'approved', 'answered'])->count();
    }

    public function getUnansweredQuestionsCountAttribute()
    {
        return $this->questions()->where('is_answered', false)->whereIn('status', ['pending', 'approved'])->count();
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

    public function isLive()
    {
        $start = $this->scheduled_at;
        $end = $this->scheduled_at->addMinutes($this->duration_minutes);
        return now()->between($start, $end);
    }

    public function isInteractive()
    {
        return $this->webinar_type === self::TYPE_LIVE_INTERACTIVE;
    }

    public function isViewOnly()
    {
        return $this->webinar_type === self::TYPE_LIVE_VIEWONLY;
    }

    public function isRecorded()
    {
        return $this->webinar_type === self::TYPE_RECORDED;
    }

    public function canAskQuestions()
    {
        return $this->allow_qa && $this->isInteractive();
    }

    public function canChat()
    {
        return $this->allow_chat && $this->isInteractive();
    }

    public function canSendPrivateMessages()
    {
        return $this->allow_private_messages;
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

    public function scopeLiveInteractive($query)
    {
        return $query->where('webinar_type', self::TYPE_LIVE_INTERACTIVE);
    }

    public function scopeLiveViewOnly($query)
    {
        return $query->where('webinar_type', self::TYPE_LIVE_VIEWONLY);
    }

    public function scopeRecordedWebinars($query)
    {
        return $query->where('webinar_type', self::TYPE_RECORDED);
    }

    public function scopeHostedBy($query, $userId)
    {
        return $query->where('host_user_id', $userId);
    }
}