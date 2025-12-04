<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeWallBeneficiary extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function coffeeWallets()
    {
        return $this->belongsToMany(CoffeeWallet::class, 'coffee_wallet_beneficiary');
    }
}
