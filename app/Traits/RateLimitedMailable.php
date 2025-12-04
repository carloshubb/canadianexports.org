<?php

namespace App\Traits;

/**
 * Trait for Mailable classes that need rate limiting (e.g., for Mailtrap free tier)
 * 
 * Usage:
 *   class YourMail extends Mailable
 *   {
 *       use Queueable, SerializesModels, RateLimitedMailable;
 *   
 *       // Optional: Override the delay in seconds
 *       public $emailDelay = 5; // default is 3 seconds
 *   }
 */
trait RateLimitedMailable
{    
    /**
     * Number of times to retry sending if it fails
     */
    public $tries = 5;
    
    /**
     * Maximum execution time (seconds)
     */
    public $timeout = 120;
    
    /**
     * Delay between retries (seconds)
     * Each retry waits progressively longer
     */
    public function backoff()
    {
        return [10, 20, 30, 60]; // 10s, 20s, 30s, 60s
    }
    
    /**
     * Apply a delay to this email to avoid rate limits
     * Call this in your constructor: $this->applyRateLimit();
     * 
     * @param int $seconds Delay in seconds (uses $emailDelay property if not provided)
     * 
     * NOTE: Disabled for paid email accounts - emails will be sent immediately
     */
    protected function applyRateLimit($seconds = null)
    {
        // Disabled - no longer needed with paid email account
        // Emails will now be sent immediately without delays
        // 
        // Previous implementation (for free email accounts):
        // $delay = $seconds ?? $this->emailDelay ?? 3;
        // $this->delay(now()->addSeconds($delay));
    }
}

