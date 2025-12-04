<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DirectorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!file_exists(public_path('media'))) {
            mkdir(public_path('media'), 0777, true);
        }
        if (!file_exists(public_path('media/banners'))) {
            mkdir(public_path('media/banners'), 0777, true);
        }
        if (!file_exists(public_path('media/customers'))) {
            mkdir(public_path('media/customers'), 0777, true);
        }
        if (!file_exists(public_path('media/events'))) {
            mkdir(public_path('media/events'), 0777, true);
        }
        if (!file_exists(public_path('media/flag_icons'))) {
            mkdir(public_path('media/flag_icons'), 0777, true);
        }
        if (!file_exists(public_path('media/images'))) {
            mkdir(public_path('media/images'), 0777, true);
        }
        if (!file_exists(public_path('media/issues'))) {
            mkdir(public_path('media/issues'), 0777, true);
        }
        if (!file_exists(public_path('media/media'))) {
            mkdir(public_path('media/media'), 0777, true);
        }
        if (!file_exists(public_path('media/pages'))) {
            mkdir(public_path('media/pages'), 0777, true);
        }
        if (!file_exists(public_path('media/widgets'))) {
            mkdir(public_path('media/widgets'), 0777, true);
        }
        if (!file_exists(public_path('media/one-more-thing'))) {
            mkdir(public_path('media/one-more-thing'), 0777, true);
        }
        if (!file_exists(public_path('media/exporting-fairs'))) {
            mkdir(public_path('media/exporting-fairs'), 0777, true);
        }
        if (!file_exists(public_path('documents'))) {
            mkdir(public_path('documents'), 0777, true);
        }
        if (!file_exists(public_path('documents/i2b'))) {
            mkdir(public_path('documents/i2b'), 0777, true);
        }
        if (!file_exists(public_path('documents/i2b/import'))) {
            mkdir(public_path('documents/i2b/import'), 0777, true);
        }
        if (!file_exists(public_path('documents/business-profiles'))) {
            mkdir(public_path('documents/business-profiles'), 0777, true);
        }
        if (!file_exists(public_path('documents/business-profiles/import'))) {
            mkdir(public_path('documents/business-profiles/import'), 0777, true);
        }
    }
}
