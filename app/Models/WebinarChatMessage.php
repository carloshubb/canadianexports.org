<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'webinar_id',
        'registration_id',
        'sender_name',
        'message',
        'status',
        'deleted_by',
    ];

    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }

    public function registration()
    {
        return $this->belongsTo(WebinarRegistration::class, 'registration_id');
    }

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeRecent($query, $limit = 100)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    public function deleteByAdmin($adminId)
    {
        $this->update([
            'status' => 'deleted_by_admin',
            'deleted_by' => $adminId,
        ]);
    }

    public function isVisible()
    {
        return $this->status === 'active';
    }
}

