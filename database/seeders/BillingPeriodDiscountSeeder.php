<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillingPeriodDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discounts = [
            [
                'period_type' => 'quarterly',
                'discount_percentage' => 10.00,
                'multiplier' => 0.9000, // 1 - (10/100) = 0.9
                'months' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'period_type' => 'semi_annually',
                'discount_percentage' => 20.00,
                'multiplier' => 0.8000, // 1 - (20/100) = 0.8
                'months' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'period_type' => 'annually',
                'discount_percentage' => 40.00,
                'multiplier' => 0.6000, // 1 - (40/100) = 0.6
                'months' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('billing_period_discounts')->insert($discounts);
    }
}
