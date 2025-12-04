<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\InfoLetter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailSubscriptionService
{
    /**
     * Check if an email address is subscribed to receive emails
     * Checks both customers and info_letters tables
     *
     * @param string $email
     * @return bool
     */
    public function isSubscribed(string $email): bool
    {
        // Check if unsubscribed in customers table
        $customerUnsubscribed = Customer::where('email', $email)
            ->where('is_subscribe', 0)
            ->exists();

        if ($customerUnsubscribed) {
            return false;
        }

        // Check if unsubscribed in info_letters table
        $infoLetterUnsubscribed = InfoLetter::where('email', $email)
            ->where('is_subscribe', 0)
            ->exists();

        if ($infoLetterUnsubscribed) {
            return false;
        }

        // If not explicitly unsubscribed, consider them subscribed
        return true;
    }

    /**
     * Generate an unsubscribe link for any email address
     * Uses existing subscribe_hash from customer or info_letter, or creates a new one
     *
     * @param string $email
     * @param string $type Type of email: 'customer' for customers, 'newsletter' for info letters
     * @return string|null
     */
    public function generateUnsubscribeLink(string $email, string $type = 'auto'): ?string
    {
        $subscribeHash = null;
        $route = 'front.confirm-unsubscribe';

        // Auto-detect or use specified type
        if ($type === 'auto') {
            // First check if this is a customer
            $customer = Customer::where('email', $email)->first();
            if ($customer) {
                $subscribeHash = $customer->subscribe_hash;
                if (!$subscribeHash) {
                    $subscribeHash = $this->generateHash();
                    $customer->update(['subscribe_hash' => $subscribeHash]);
                }
                $route = 'front.confirm-unsubscribe-holiday';
            } else {
                // Check if this is an info letter subscriber
                $infoLetter = InfoLetter::where('email', $email)->first();
                if ($infoLetter) {
                    $subscribeHash = $infoLetter->subscribe_hash;
                    if (!$subscribeHash) {
                        $subscribeHash = $this->generateHash();
                        $infoLetter->update(['subscribe_hash' => $subscribeHash]);
                    }
                    $route = 'front.confirm-unsubscribe';
                } else {
                    // Create a new info letter entry for this email
                    $subscribeHash = $this->generateHash();
                    InfoLetter::create([
                        'email' => $email,
                        'subscribe_hash' => $subscribeHash,
                        'is_subscribe' => 1,
                    ]);
                    $route = 'front.confirm-unsubscribe';
                }
            }
        } elseif ($type === 'customer') {
            $customer = Customer::where('email', $email)->first();
            if ($customer) {
                $subscribeHash = $customer->subscribe_hash;
                if (!$subscribeHash) {
                    $subscribeHash = $this->generateHash();
                    $customer->update(['subscribe_hash' => $subscribeHash]);
                }
                $route = 'front.confirm-unsubscribe-holiday';
            }
        } elseif ($type === 'newsletter') {
            $infoLetter = InfoLetter::where('email', $email)->first();
            if ($infoLetter) {
                $subscribeHash = $infoLetter->subscribe_hash;
                if (!$subscribeHash) {
                    $subscribeHash = $this->generateHash();
                    $infoLetter->update(['subscribe_hash' => $subscribeHash]);
                }
            } else {
                // Create a new info letter entry
                $subscribeHash = $this->generateHash();
                InfoLetter::create([
                    'email' => $email,
                    'subscribe_hash' => $subscribeHash,
                    'is_subscribe' => 1,
                ]);
            }
            $route = 'front.confirm-unsubscribe';
        }

        if ($subscribeHash) {
            return route($route, ['q' => $subscribeHash]);
        }

        return null;
    }

    /**
     * Generate a unique hash for subscribe/unsubscribe functionality
     *
     * @return string
     */
    protected function generateHash(): string
    {
        return Str::random(32) . time();
    }

    /**
     * Get subscriber info (customer or info_letter) for a given email
     *
     * @param string $email
     * @return array
     */
    public function getSubscriberInfo(string $email): array
    {
        $customer = Customer::where('email', $email)->first();
        if ($customer) {
            return [
                'type' => 'customer',
                'model' => $customer,
                'is_subscribed' => (bool) $customer->is_subscribe,
                'subscribe_hash' => $customer->subscribe_hash,
            ];
        }

        $infoLetter = InfoLetter::where('email', $email)->first();
        if ($infoLetter) {
            return [
                'type' => 'info_letter',
                'model' => $infoLetter,
                'is_subscribed' => (bool) $infoLetter->is_subscribe,
                'subscribe_hash' => $infoLetter->subscribe_hash,
            ];
        }

        return [
            'type' => null,
            'model' => null,
            'is_subscribed' => true, // Default to subscribed if not found
            'subscribe_hash' => null,
        ];
    }

    /**
     * Unsubscribe an email address from all communications
     *
     * @param string $email
     * @return bool
     */
    public function unsubscribe(string $email): bool
    {
        try {
            // Update both systems
            Customer::where('email', $email)->update(['is_subscribe' => 0]);
            InfoLetter::where('email', $email)->update(['is_subscribe' => 0]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to unsubscribe email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Resubscribe an email address to communications
     *
     * @param string $email
     * @return bool
     */
    public function resubscribe(string $email): bool
    {
        try {
            // Update both systems
            Customer::where('email', $email)->update(['is_subscribe' => 1]);
            InfoLetter::where('email', $email)->update(['is_subscribe' => 1]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to resubscribe email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send email only if the recipient is subscribed
     * Use this for marketing/promotional emails
     *
     * @param string $email The recipient email address
     * @param \Illuminate\Mail\Mailable $mailable The email to send
     * @param bool $queue Whether to queue the email (default: false)
     * @return bool True if sent, false if not subscribed or failed
     */
    public function sendIfSubscribed(string $email, $mailable, bool $queue = false): bool
    {
        if (!$this->isSubscribed($email)) {
            Log::info("Email not sent to {$email} - user is unsubscribed", [
                'mailable' => get_class($mailable)
            ]);
            return false;
        }

        try {
            if ($queue) {
                Mail::to($email)->send($mailable);
            } else {
                Mail::to($email)->send($mailable);
            }
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send email to {$email}: " . $e->getMessage(), [
                'mailable' => get_class($mailable)
            ]);
            return false;
        }
    }

    /**
     * Send email to multiple recipients, filtering out unsubscribed users
     * Use this for marketing/promotional bulk emails
     *
     * @param array $emails Array of email addresses
     * @param \Illuminate\Mail\Mailable $mailable The email to send
     * @param bool $queue Whether to queue the email (default: false)
     * @return array ['sent' => int, 'skipped' => int, 'failed' => int]
     */
    public function sendBulkIfSubscribed(array $emails, $mailable, bool $queue = false): array
    {
        $results = ['sent' => 0, 'skipped' => 0, 'failed' => 0];

        foreach ($emails as $email) {
            if (!$this->isSubscribed($email)) {
                $results['skipped']++;
                Log::info("Email not sent to {$email} - user is unsubscribed");
                continue;
            }

            try {
                if ($queue) {
                    Mail::to($email)->send(clone $mailable);
                } else {
                    Mail::to($email)->send(clone $mailable);
                }
                $results['sent']++;
            } catch (\Exception $e) {
                $results['failed']++;
                Log::error("Failed to send email to {$email}: " . $e->getMessage());
            }
        }

        return $results;
    }
}

