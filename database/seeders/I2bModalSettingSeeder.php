<?php

namespace Database\Seeders;

use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Illuminate\Database\Seeder;

class I2bModalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = getDefaultLanguage();
        $result = StaticTranslation::where('type', 'i2b_modal')->first();

        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'I2b modal setting',
                'type' => 'i2b_modal',
            ]);
        }



        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'greeting_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'greeting_text',
                'display_text' => 'Greeting text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'free_package_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'free_package_text',
                'display_text' => 'Free package (description)',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'paid_package_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'paid_package_text',
                'display_text' => 'Paid package (description)',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'free_package_submit_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'free_package_submit_button_text',
                'display_text' => 'Free package submit button text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'guest_package_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'guest_package_text',
                'display_text' => 'Guest user package (description)',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'paid_package_submit_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'paid_package_submit_button_text',
                'display_text' => 'Paid package submit button text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'i2b_upgrade_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'i2b_upgrade_text',
                'display_text' => 'Upgrade text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'i2b_package_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'i2b_package_text',
                'display_text' => 'Package text',
            ]);
        }
        
        $staticTranslations = StaticTranslation::where('type', 'i2b_modal')->get();
        foreach ($staticTranslations as $staticTranslation) {
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'required_feild_text')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'i2b_inquiry_error')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'i2b_inquiry_name')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'i2b_email_error')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'i2b_email_name')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'i2b_company_error')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'i2b_company_name')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'i2b_modal_title')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'i2b_modal_body_text')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'i2b_modal_submit_button_text')->delete();
        }
    }
}
