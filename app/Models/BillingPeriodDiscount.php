<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingPeriodDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_type',
        'discount_percentage',
        'multiplier',
        'months',
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'multiplier' => 'decimal:4',
        'months' => 'integer',
    ];

    /**
     * Update multiplier based on discount percentage
     */
    public function updateMultiplier()
    {
        $this->multiplier = 1 - ($this->discount_percentage / 100);
        return $this;
    }

    /**
     * Get discount by period type
     */
    public static function getByPeriod($periodType)
    {
        return static::where('period_type', $periodType)->first();
    }

    /**
     * Get all discounts as key-value array
     */
    public static function getAllDiscounts()
    {
        return static::all()->pluck('discount_percentage', 'period_type')->toArray();
    }

    /**
     * Get all multipliers as key-value array
     */
    public static function getAllMultipliers()
    {
        return static::all()->pluck('multiplier', 'period_type')->toArray();
    }
}
