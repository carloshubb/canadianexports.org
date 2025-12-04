<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // GeneralSetting::truncate();

        $generalSetting = GeneralSetting::where('key', 'admin_email')->whereNull('type')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Admin email',
                'key' => 'admin_email',
                'value' => 'info@xelent.pk',
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'user_signup_page')->where('type', 'pages_setting')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'User signup page',
                'key' => 'user_signup_page',
               'type' => 'pages_setting',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'user_signin_page')->where('type', 'pages_setting')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'User signin page',
                'key' => 'user_signin_page',
               'type' => 'pages_setting',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'user_event_signup_page')->where('type', 'pages_setting')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Event signup page',
                'key' => 'user_event_signup_page',
               'type' => 'pages_setting',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'user_event_create_page')->where('type', 'pages_setting')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Event create page',
                'key' => 'user_event_create_page',
                'type' => 'pages_setting',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'user_event_listing_page')->where('type', 'pages_setting')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Event listing page',
                'key' => 'user_event_listing_page',
               'type' => 'pages_setting',
                'value' => null,
            ]);
        }$generalSetting = GeneralSetting::where('key', 'user_sponser_listing_page')->where('type', 'pages_setting')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Sponser listing page',
                'key' => 'user_sponser_listing_page',
               'type' => 'pages_setting',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'see_all_magazine_page')->where('type', 'pages_setting')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'See all magazine page',
                'key' => 'see_all_magazine_page',
                'type' => 'pages_setting',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'contact_us_page')->where('type', 'pages_setting')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Contact us page',
                'key' => 'contact_us_page',
                'type' => 'pages_setting',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'close_account_page')->where('type', 'pages_setting')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Close account page',
                'key' => 'close_account_page',
               'type' => 'pages_setting',
                'value' => null,
            ]);
        }


        $generalSetting = GeneralSetting::where('key', 'thumbnail_image_width')->where('type', 'media')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Thumbnail image width',
                'key' => 'thumbnail_image_width',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'thumbnail_image_height')->where('type', 'media')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Thumbnail image height',
                'key' => 'thumbnail_image_height',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'medium_image_width')->where('type', 'media')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Medium image width',
                'key' => 'medium_image_width',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'medium_image_height')->where('type', 'media')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Medium image height',
                'key' => 'medium_image_height',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'large_image_width')->where('type', 'media')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Large image width',
                'key' => 'large_image_width',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'large_image_height')->where('type', 'media')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Large image height',
                'key' => 'large_image_height',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'canadian_exporters_emails_per_day')->where('type', 'email')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'General form submission per day',
                'key' => 'canadian_exporters_emails_per_day',
                'type' => 'email',
                'value' => 10,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'free_package_price_per_month')->where('type', 'package')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Free package price per month',
                'key' => 'free_package_price_per_month',
                'type' => 'package',
                'value' => 0,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'featured_package_price_per_month')->where('type', 'package')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Featured package price per month',
                'key' => 'featured_package_price_per_month',
                'type' => 'package',
                'value' => 10,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'premium_package_price_per_month')->where('type', 'package')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Premium package price per month',
                'key' => 'premium_package_price_per_month',
                'type' => 'package',
                'value' => 20,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'facebook_meta_image')->where('type', 'meta_tags')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Facebook meta image',
                'key' => 'facebook_meta_image',
                'type' => 'meta_tags',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'twitter_meta_image')->where('type', 'meta_tags')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Twitter meta image',
                'key' => 'twitter_meta_image',
                'type' => 'meta_tags',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'linkedin_meta_image')->where('type', 'meta_tags')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'Linkedin meta image',
                'key' => 'linkedin_meta_image',
                'type' => 'meta_tags',
                'value' => null,
            ]);
        }



        $generalSetting = GeneralSetting::where('key', 'stripe_free_product')->where('type', 'stripe_config')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'stripe free product',
                'key' => 'stripe_free_product',
                'type' => 'stripe_config',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'stripe_featured_product')->where('type', 'stripe_config')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'stripe featured product',
                'key' => 'stripe_featured_product',
                'type' => 'stripe_config',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'stripe_premium_product')->where('type', 'stripe_config')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'stripe premium product',
                'key' => 'stripe_premium_product',
                'type' => 'stripe_config',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'stripe_pay_to_go_product')->where('type', 'stripe_config')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'stripe pay to go product',
                'key' => 'stripe_pay_to_go_product',
                'type' => 'stripe_config',
                'value' => null,
            ]);
        }





        $generalSetting = GeneralSetting::where('key', 'paypal_free_product')->where('type', 'paypal_config')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'paypal free product',
                'key' => 'paypal_free_product',
                'type' => 'paypal_config',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'paypal_featured_product')->where('type', 'paypal_config')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'paypal featured product',
                'key' => 'paypal_featured_product',
                'type' => 'paypal_config',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'paypal_premium_product')->where('type', 'paypal_config')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'paypal premium product',
                'key' => 'paypal_premium_product',
                'type' => 'paypal_config',
                'value' => null,
            ]);
        }
        $generalSetting = GeneralSetting::where('key', 'paypal_pay_to_go_product')->where('type', 'paypal_config')->first();
        if (!$generalSetting) {
            GeneralSetting::create([
                'display_text' => 'paypal pay to go product',
                'key' => 'paypal_pay_to_go_product',
                'type' => 'paypal_config',
                'value' => null,
            ]);
        }
    }
}
