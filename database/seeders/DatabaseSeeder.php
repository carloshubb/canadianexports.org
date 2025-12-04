<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            GeneralSettingSeeder::class,
            ValidationSeeder::class,
            DirectorySeeder::class,
            PaymentSeeder::class,
            StaticTranslationSeeder::class,
            AdvanceSearchSettingSeeder::class,
            BusinessProfileSettingSeeder::class,
            CookiesModalSettingSeeder::class,
            EventDetailSettingSeeder::class,
            ForgetPasswordSettingSeeder::class,
            I2bModalSettingSeeder::class,
            ResetPasswordSettingSeeder::class,
            UpgradeSettingSeeder::class,
            PaymentSettingSeeder::class,
            CoffeeWallSettingSeeder::class,
            PackageSummarySeeder::class,
            ExportingFairSettingSeeder::class,
            GeneralMessageSeeder::class,
            ResendEmailVerificationSettingSeeder::class,
        ]);
    }
}
