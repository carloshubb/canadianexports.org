<?php

namespace Database\Seeders;

use App\Models\CoffeeWallBeneficiary;
use Illuminate\Database\Seeder;

class CoffeeWallBeneficiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $beneficiaries = [
            'All',
            'Food Bank',
            'Homeless Shelter',
            'Children\'s Hospital',
            'Community Center',
            'Education Fund',
            'Healthcare Services',
            'Youth Programs',
            'Senior Care',
        ];

        foreach ($beneficiaries as $name) {
            CoffeeWallBeneficiary::firstOrCreate(
                ['name' => $name],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        $this->command->info('Coffee Wall Beneficiaries seeded successfully!');
    }
}

