<?php

namespace App\Console\Commands;

use App\Models\CoffeeWallet;
use App\Services\CoffeeUsedDonorNotification;
use Illuminate\Console\Command;

class CoffeeWallNotifyDonorUsed extends Command
{
    protected $signature = 'coffee-wall:notify-donor-used {id : The coffee_wallets id}';

    protected $description = "Send the \"Someone just enjoyed your coffee!\" email to the donor for a given coffee wallet. Use when a coffee has been used/redeemed.";

    public function handle()
    {
        $id = $this->argument('id');
        $wallet = CoffeeWallet::find($id);

        if (!$wallet) {
            $this->error("Coffee wallet with id {$id} not found.");
            return Command::FAILURE;
        }

        if (!$wallet->email) {
            $this->error("This coffee wallet has no email; cannot notify donor.");
            return Command::FAILURE;
        }

        $sent = CoffeeUsedDonorNotification::send($wallet);

        if (!$sent) {
            $this->error("Failed to send donor notification.");
            return Command::FAILURE;
        }

        $this->info("Donor notification sent to {$wallet->email}.");
        return Command::SUCCESS;
    }
}
