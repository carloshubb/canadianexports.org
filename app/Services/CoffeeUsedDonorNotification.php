<?php

namespace App\Services;

use App\Mail\CoffeeUsedDonorMail;
use App\Models\CoffeeWallet;
use Illuminate\Support\Facades\Mail;

/**
 * Sends the automated "your coffee was enjoyed" email to the donor when a Coffee on the Wall has been used.
 * Call this when a coffee is redeemed/used (e.g. from your redemption controller or admin "mark as used" action).
 *
 * Example:
 *   CoffeeUsedDonorNotification::send($coffeeWallet, now()->format('F j, Y'), 'Business name, category, province, and the service received.');
 */
class CoffeeUsedDonorNotification
{
    /**
     * Notify the donor that their coffee has been used.
     * Sends whenever the wallet has an email (notify_when_used is not checked).
     *
     * @param CoffeeWallet|int $coffeeWallet Model or id
     * @param string|null $redemptionDate Formatted date (e.g. "January 27, 2025"). Defaults to today.
     * @param string|null $beneficiarySharedInfo What the beneficiary agreed to share (e.g. "Business name, category, province, and the service received.")
     * @return bool Whether the email was sent
     */
    public static function send($coffeeWallet, ?string $redemptionDate = null, ?string $beneficiarySharedInfo = null): bool
    {
        $wallet = $coffeeWallet instanceof CoffeeWallet
            ? $coffeeWallet
            : CoffeeWallet::find($coffeeWallet);

        if (!$wallet || !$wallet->email) {
            return false;
        }

        $donorName = $wallet->name ?: 'there';
        $date = $redemptionDate ?? now()->format('F j, Y');

        Mail::to($wallet->email)->send(new CoffeeUsedDonorMail($donorName, $date, $beneficiarySharedInfo));

        return true;
    }
}
