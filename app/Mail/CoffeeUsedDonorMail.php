<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Automated email sent to the donor when their Coffee on the Wall has been used (redeemed).
 * Send when a coffee is marked as used, e.g.:
 *   Mail::to($coffeeWallet->email)->send(new CoffeeUsedDonorMail($donorName, $redemptionDate, $beneficiarySharedInfo));
 * Only send if the donor has notify_when_used enabled (or per your business rules).
 */
class CoffeeUsedDonorMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string Donor display name */
    public $donorName;

    /** @var string Formatted date of redemption (e.g. "January 27, 2025") */
    public $redemptionDate;

    /** @var string Text describing what the beneficiary agreed to share (e.g. "Business name, category, province, and the service received") */
    public $beneficiarySharedInfo;

    /**
     * Create a new message instance.
     *
     * @param string $donorName
     * @param string $redemptionDate
     * @param string|null $beneficiarySharedInfo Default: "a small local business (this is what the beneficiary agreed to share: business name, category, province, and the service received)"
     */
    public function __construct(string $donorName, string $redemptionDate, ?string $beneficiarySharedInfo = null)
    {
        $this->donorName = $donorName;
        $this->redemptionDate = $redemptionDate;
        $this->beneficiarySharedInfo = $beneficiarySharedInfo ?? 'a small local business. This is what the beneficiary agreed to share: business name, category, province, and the service received.';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Someone just enjoyed your coffee! ☕')
            ->markdown('mails.coffee-used-donor')
            ->with([
                'donorName' => $this->donorName,
                'redemptionDate' => $this->redemptionDate,
                'beneficiarySharedInfo' => $this->beneficiarySharedInfo,
            ]);
    }
}
