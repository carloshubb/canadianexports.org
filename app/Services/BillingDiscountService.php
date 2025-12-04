<?php

namespace App\Services;

use App\Models\BillingPeriodDiscount;
use Illuminate\Support\Facades\Cache;

class BillingDiscountService
{
    /**
     * Get all discount multipliers with caching
     * Returns array like: ['quarterly' => 0.9, 'semi_annually' => 0.8, 'annually' => 0.6]
     */
    public static function getMultipliers()
    {
        return Cache::remember('billing_discount_multipliers', 3600, function () {
            return BillingPeriodDiscount::getAllMultipliers();
        });
    }

    /**
     * Get all discount percentages with caching
     * Returns array like: ['quarterly' => 10, 'semi_annually' => 20, 'annually' => 40]
     */
    public static function getPercentages()
    {
        return Cache::remember('billing_discount_percentages', 3600, function () {
            return BillingPeriodDiscount::getAllDiscounts();
        });
    }

    /**
     * Get multiplier for a specific period
     */
    public static function getMultiplier($periodType)
    {
        $multipliers = self::getMultipliers();
        return $multipliers[$periodType] ?? 1.0;
    }

    /**
     * Get percentage for a specific period
     */
    public static function getPercentage($periodType)
    {
        $percentages = self::getPercentages();
        return $percentages[$periodType] ?? 0;
    }

    /**
     * Clear cached discount values
     */
    public static function clearCache()
    {
        Cache::forget('billing_discount_multipliers');
        Cache::forget('billing_discount_percentages');
    }

    /**
     * Calculate prices for all billing periods based on monthly price
     */
    public static function calculatePricesFromMonthly($monthlyPrice)
    {
        $multipliers = self::getMultipliers();
        
        return [
            'quarterly_price' => number_format(($monthlyPrice * 3 * ($multipliers['quarterly'] ?? 0.9)) / 3, 2, '.', ''),
            'semi_annually_price' => number_format(($monthlyPrice * 6 * ($multipliers['semi_annually'] ?? 0.8)) / 6, 2, '.', ''),
            'annually_price' => number_format(($monthlyPrice * 12 * ($multipliers['annually'] ?? 0.6)) / 12, 2, '.', ''),
        ];
    }
}
