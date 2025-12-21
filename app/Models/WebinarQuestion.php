<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebinarQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'webinar_id',
        'registration_id',
        'asker_name',
        'asker_email',
        'question',
        'answer',
        'answered_by',
        'answered_at',
        'is_anonymous',
        'is_public',
        'is_answered',
        'is_featured',
        'upvotes',
        'status',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_public' => 'boolean',
        'is_answered' => 'boolean',
        'is_featured' => 'boolean',
        'answered_at' => 'datetime',
    ];

    protected $appends = ['display_name'];

    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }

    public function registration()
    {
        return $this->belongsTo(WebinarRegistration::class, 'registration_id');
    }

    public function answeredByUser()
    {
        return $this->belongsTo(User::class, 'answered_by');
    }

    public function upvotedBy()
    {
        return $this->belongsToMany(
            WebinarRegistration::class,
            'webinar_question_upvotes',
            'question_id',
            'registration_id'
        )->withTimestamps();
    }

    public function getDisplayNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonymous';
        }
        return $this->asker_name;
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->whereIn('status', ['approved', 'answered']);
    }

    public function scopeAnswered($query)
    {
        return $query->where('is_answered', true);
    }

    public function scopeUnanswered($query)
    {
        return $query->where('is_answered', false);
    }

    public function scopePublicQuestions($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function markAsAnswered($answer = null, $answeredBy = null)
    {
        $this->update([
            'is_answered' => true,
            'answer' => $answer,
            'answered_by' => $answeredBy,
            'answered_at' => now(),
            'status' => 'answered',
        ]);
    }

    public function approve()
    {
        $this->update(['status' => 'approved']);
    }

    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }

    public function toggleFeatured()
    {
        $this->update(['is_featured' => !$this->is_featured]);
    }

    public function upvote(WebinarRegistration $registration)
    {
        if (!$this->upvotedBy()->where('registration_id', $registration->id)->exists()) {
            $this->upvotedBy()->attach($registration->id);
            $this->increment('upvotes');
            return true;
        }
        return false;
    }

    public function removeUpvote(WebinarRegistration $registration)
    {
        if ($this->upvotedBy()->where('registration_id', $registration->id)->exists()) {
            $this->upvotedBy()->detach($registration->id);
            $this->decrement('upvotes');
            return true;
        }
        return false;
    }
}

