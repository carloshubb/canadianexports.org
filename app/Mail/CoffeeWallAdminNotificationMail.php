<?php

namespace App\Mail;

use App\Models\CoffeeWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Email sent to admin when a Coffee on the Wall is added (donation submitted).
 */
class CoffeeWallAdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var CoffeeWallet */
    public $coffeeWallet;

    /**
     * Create a new message instance.
     */
    public function __construct(CoffeeWallet $coffeeWallet)
    {
        $this->coffeeWallet = $coffeeWallet->load(['package', 'beneficiaries']);
    }

    public function build()
    {
        return $this->subject('Coffee on the Wall added to Canadian Exports')
            ->markdown('mails.coffee-wall-admin-notification')
            ->with(['coffeeWallet' => $this->coffeeWallet]);
    }
}
