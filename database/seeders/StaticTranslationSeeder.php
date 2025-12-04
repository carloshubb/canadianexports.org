<?php

namespace Database\Seeders;

use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StaticTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Schema::disableForeignKeyConstraints();
        // StaticTranslationDetail::truncate();
        // StaticTranslation::truncate();
        // Schema::enableForeignKeyConstraints();
        $lang = getDefaultLanguage();

        $result = StaticTranslation::where('type', 'general')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'General setting',
                'type' => 'general',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'signup_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'signup_button_text',
                'display_text' => 'Signup button text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'signin_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'signin_button_text',
                'display_text' => 'Signin button text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'account_setting_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'account_setting_text',
                'display_text' => 'Account setting text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'business_profile_setting_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'business_profile_setting_text',
                'display_text' => 'Business profile setting text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'media_setting_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'media_setting_text',
                'display_text' => 'Media setting text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'social_media_setting_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'social_media_setting_text',
                'display_text' => 'Social media setting text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'event_listing_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'event_listing_text',
                'display_text' => 'Event listing text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'sponser_listing_text')->first();
          if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'sponser_listing_text',
                'display_text' => 'Sponser listing text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'delete_profile_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'delete_profile_text',
                'display_text' => 'Delete profile text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'logout_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'logout_button_text',
                'display_text' => 'Logout text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'view_company_profile_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'view_company_profile_button_text',
                'display_text' => 'View company profile button text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'process_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'process_button_text',
                'display_text' => 'Process button text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'cancel_subscription_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'cancel_subscription_text',
                'display_text' => 'Cancel subscription text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'resume_subscription_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'resume_subscription_text',
                'display_text' => 'Resume subscription text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'upgrade_package_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'upgrade_package_button_text',
                'display_text' => 'Upgrade package button text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'next_invoice_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'next_invoice_text',
                'display_text' => 'Next invoice text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'package_validity_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'package_validity_text',
                'display_text' => 'Package validity text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'no_result_found_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'no_result_found_text',
                'display_text' => 'No result found text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'pagination_showing_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'pagination_showing_text',
                'display_text' => 'Pagination showing text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'pagination_to_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'pagination_to_text',
                'display_text' => 'Pagination to text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'pagination_of_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'pagination_of_text',
                'display_text' => 'Pagination of text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'pagination_results_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'pagination_results_text',
                'display_text' => 'Pagination results text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'language_modal_heading')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'language_modal_heading',
                'display_text' => 'Language modal heading',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'language_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'language_button_text',
                'display_text' => 'Language button text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'search_result_for_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'search_result_for_text',
                'display_text' => 'Search result for text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'home_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'home_button_text',
                'display_text' => 'Home button text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'profile_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'profile_button_text',
                'display_text' => 'profile button text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'search_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'search_button_text',
                'display_text' => 'search button text',
            ]);
        }
         $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'signup_modal_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'signup_modal_text',
                'display_text' => 'What do you want to register on Canadian Exports?',
            ]);
        }
         $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'signup_modal_exporter_button')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'signup_modal_exporter_button',
                'display_text' => 'Register an Exporter Profile',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'signup_modal_event_button')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'signup_modal_event_button',
                'display_text' => 'Create an Event',
            ]);
        }
    }
}
