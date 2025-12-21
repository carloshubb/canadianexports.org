<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'webinar_id',
        'registration_id',
        'sender_name',
        'sender_email',
        'sender_type',
        'message',
        'is_read',
        'read_at',
        'parent_id',
        'status',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }

    public function registration()
    {
        return $this->belongsTo(WebinarRegistration::class, 'registration_id');
    }

    public function parent()
    {
        return $this->belongsTo(WebinarMessage::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(WebinarMessage::class, 'parent_id');
    }

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFromAttendee($query)
    {
        return $query->where('sender_type', 'attendee');
    }

    public function scopeFromPresenter($query)
    {
        return $query->where('sender_type', 'presenter');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForConversation($query, $registrationId)
    {
        return $query->where('registration_id', $registrationId)
            ->orWhere(function ($q) use ($registrationId) {
                $q->where('sender_type', 'presenter')
                    ->whereHas('parent', function ($sq) use ($registrationId) {
                        $sq->where('registration_id', $registrationId);
                    });
            });
    }

    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function softDeleteByUser()
    {
        $this->update([
            'status' => 'deleted_by_user',
            'deleted_at' => now(),
        ]);
    }

    public function softDeleteByAdmin($adminId)
    {
        $this->update([
            'status' => 'deleted_by_admin',
            'deleted_by' => $adminId,
            'deleted_at' => now(),
        ]);
    }

    public function isVisible()
    {
        return $this->status === 'active';
    }
}

