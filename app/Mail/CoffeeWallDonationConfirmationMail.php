<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Confirmation email sent to the donor after they complete a Coffee on the Wall payment (Stripe or PayPal).
 */
class CoffeeWallDonationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string Donor display name */
    public $donorName;

    /** @var string|float Donation amount (e.g. "25" or "25.00") */
    public $amount;

    /** @var string Formatted date (e.g. "January 27, 2025") */
    public $donationDate;

    /**
     * Create a new message instance.
     */
    public function __construct(string $donorName, $amount, string $donationDate)
    {
        $this->donorName = $donorName;
        $this->amount = $amount;
        $this->donationDate = $donationDate;
    }

    public function build()
    {
        return $this->subject('Thank you for your Coffee on the Wall donation ☕')
            ->markdown('mails.coffee-wall-donation-confirmation')
            ->with([
                'donorName' => $this->donorName,
                'amount' => $this->amount,
                'donationDate' => $this->donationDate,
            ]);
    }
}
