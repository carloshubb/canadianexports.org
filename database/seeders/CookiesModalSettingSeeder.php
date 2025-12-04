<?php

namespace Database\Seeders;

use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Illuminate\Database\Seeder;

class CookiesModalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = getDefaultLanguage();
        $result = StaticTranslation::where('type', 'cookies_modal')->first();
        if(!$result){
            $result = StaticTranslation::create([
                'display_text' => 'Cookies modal setting',
                'type' => 'cookies_modal',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'body_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'body_text',
                'display_text' => 'Cookies body text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'learn_more_btn_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'learn_more_btn_text',
                'display_text' => 'learn more button text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'learn_more_btn_link')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'learn_more_btn_link',
                'display_text' => 'learn more button link',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'allow_cookies_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'allow_cookies_button_text',
                'display_text' => 'Allow cookies button text',
            ]);
        }
    }
}
