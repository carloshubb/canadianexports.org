<?php

namespace Database\Seeders;

use App\Models\SponsorAmount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorAmountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $amounts = [
            // One-time sponsorship amounts
            ['amount' => 100, 'frequency' => 'one_time', 'is_default' => false, 'sort_order' => 1],
            ['amount' => 500, 'frequency' => 'one_time', 'is_default' => false, 'sort_order' => 2],
            ['amount' => 1000, 'frequency' => 'one_time', 'is_default' => false, 'sort_order' => 3],
            ['amount' => 2000, 'frequency' => 'one_time', 'is_default' => false, 'sort_order' => 4],
            ['amount' => 5000, 'frequency' => 'one_time', 'is_default' => true, 'sort_order' => 5], // $5,000 is default for one-time
            ['amount' => 10000, 'frequency' => 'one_time', 'is_default' => false, 'sort_order' => 6],
            
            // Monthly sponsorship amounts
            ['amount' => 50, 'frequency' => 'monthly', 'is_default' => false, 'sort_order' => 1],
            ['amount' => 100, 'frequency' => 'monthly', 'is_default' => true, 'sort_order' => 2], // $100 is default for monthly
            ['amount' => 250, 'frequency' => 'monthly', 'is_default' => false, 'sort_order' => 3],
            ['amount' => 500, 'frequency' => 'monthly', 'is_default' => false, 'sort_order' => 4],
            ['amount' => 1000, 'frequency' => 'monthly', 'is_default' => false, 'sort_order' => 5],
            
            // Quarterly sponsorship amounts
            ['amount' => 150, 'frequency' => 'quarterly', 'is_default' => false, 'sort_order' => 1],
            ['amount' => 300, 'frequency' => 'quarterly', 'is_default' => true, 'sort_order' => 2], // $300 is default for quarterly
            ['amount' => 750, 'frequency' => 'quarterly', 'is_default' => false, 'sort_order' => 3],
            ['amount' => 1500, 'frequency' => 'quarterly', 'is_default' => false, 'sort_order' => 4],
            ['amount' => 3000, 'frequency' => 'quarterly', 'is_default' => false, 'sort_order' => 5],
            
            // Annually sponsorship amounts
            ['amount' => 600, 'frequency' => 'annually', 'is_default' => false, 'sort_order' => 1],
            ['amount' => 1200, 'frequency' => 'annually', 'is_default' => true, 'sort_order' => 2], // $1,200 is default for annually
            ['amount' => 3000, 'frequency' => 'annually', 'is_default' => false, 'sort_order' => 3],
            ['amount' => 6000, 'frequency' => 'annually', 'is_default' => false, 'sort_order' => 4],
            ['amount' => 12000, 'frequency' => 'annually', 'is_default' => false, 'sort_order' => 5],
        ];

        foreach ($amounts as $amount) {
            SponsorAmount::create($amount);
        }
    }
}
