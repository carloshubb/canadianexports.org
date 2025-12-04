<?php

namespace App\Traits;

use App\Services\EmailSubscriptionService;

trait HasUnsubscribeLink
{
    /**
     * The unsubscribe link for this email
     *
     * @var string|null
     */
    public $unsubscribeLink = null;

    /**
     * Generate and set the unsubscribe link for a given email address
     *
     * @param string $email
     * @param string $type Type of unsubscribe: 'auto', 'customer', or 'newsletter'
     * @return $this
     */
    public function withUnsubscribeLink(string $email, string $type = 'auto')
    {
        $service = app(EmailSubscriptionService::class);
        $this->unsubscribeLink = $service->generateUnsubscribeLink($email, $type);
        
        return $this;
    }

    /**
     * Check if an email address is subscribed before sending
     *
     * @param string $email
     * @return bool
     */
    protected function canSendTo(string $email): bool
    {
        $service = app(EmailSubscriptionService::class);
        return $service->isSubscribed($email);
    }
}

