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

    protected $appends = ['registrations_count', 'available_seats', 'questions_count', 'unanswered_questions_count', 'cover_image_url', 'presenter_image_url'];

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

    /**
     * Get cover image URL (parsed from JSON array or string)
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->parseImagePath($this->cover_image);
    }

    /**
     * Get presenter image URL (parsed from JSON array or string)
     */
    public function getPresenterImageUrlAttribute()
    {
        return $this->parseImagePath($this->presenter_image);
    }

    /**
     * Parse image path from database (handles JSON array or string)
     */
    private function parseImagePath($imagePath)
    {
        if (empty($imagePath)) {
            return null;
        }

        $path = null;

        // JSON string (["media/temp/..."])
        if (is_string($imagePath) && str_starts_with(trim($imagePath), '[')) {
            $parsed = json_decode($imagePath, true);

            if (json_last_error() === JSON_ERROR_NONE && !empty($parsed[0])) {
                $path = $parsed[0];
            }
        }
        // Array input
        elseif (is_array($imagePath) && !empty($imagePath[0])) {
            $path = $imagePath[0];
        }
        // Plain string
        elseif (is_string($imagePath)) {
            $path = $imagePath;
        }

        if (!$path) {
            return null;
        }

        // Normalize slashes
        $path = str_replace('\\', '/', $path);

        // Remove leading slash
        $path = ltrim($path, '/');

        // For temp media files (media/temp/...)
        // These are ALWAYS saved directly to web-accessible path via getWebPublicPath
        // So they should ALWAYS be accessed as /media/temp/... not /storage/media/temp/...
        if (str_starts_with($path, 'media/temp/')) {
            // Always use direct path (without storage/) for temp files
            return asset($path);
        }

        // For other media files (not temp)
        if (str_starts_with($path, 'media/')) {
            // Check if file exists in web-accessible path (VPS/Hostinger) first
            $webPath = getWebPublicPath($path);
            if (file_exists($webPath)) {
                // File exists in web-accessible path
                return asset($path);
            }
            // Fallback: try storage path (local development with symlink)
            $storagePath = 'storage/' . $path;
            $storageFullPath = public_path($storagePath);
            if (file_exists($storageFullPath) || is_link(public_path('storage'))) {
                return asset($storagePath);
            }
            // If neither exists, return direct path (let browser try)
            return asset($path);
        }

        // If already starts with storage/, use as is (for local)
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        // Default fallback - try with storage/ prefix first, then direct
        $storagePath = 'storage/' . $path;
        $storageFullPath = public_path($storagePath);
        if (file_exists($storageFullPath)) {
            return asset($storagePath);
        }
        
        // Try direct path (for Hostinger)
        return asset($path);
    }

    /**
     * Check if we're running on Hostinger or similar shared hosting
     */
    private function isHostingerEnvironment(): bool
    {
        // Check if document root differs from Laravel public path
        // On Hostinger: DOCUMENT_ROOT = public_html, public_path() = public_html/src/public
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? public_path();
        $laravelPublic = public_path();
        
        // If Laravel public is inside document root, we're likely on shared hosting
        if (strpos($laravelPublic, $documentRoot) === 0 && $laravelPublic !== $documentRoot) {
            return true;
        }
        
        // Check if storage symlink doesn't exist (another indicator)
        $storageLink = public_path('storage');
        if (!is_link($storageLink) && !file_exists($storageLink)) {
            return true;
        }
        
        return false;
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