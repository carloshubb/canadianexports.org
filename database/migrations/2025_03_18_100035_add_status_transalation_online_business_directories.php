<?php

use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lang = getDefaultLanguage();

        $result = StaticTranslation::where('type', 'online_business_directory_search')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Business directory search',
                'type' => 'online_business_directory_search',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'name_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'page_title',
                'display_text' => 'Page Title',
            ]);

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'name_label_text',
                'display_text' => 'Name label text',
            ]);

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'province_label_text',
                'display_text' => 'Province Lable Text',
            ]);
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'city_label_text',
                'display_text' => 'City Lable Text',
            ]);
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'industry_label_text',
                'display_text' => 'Industry Lable Text',
            ]);
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'postal_code_label_text',
                'display_text' => 'Postal code Lable Text',
            ]);
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'phone_label_text',
                'display_text' => 'Phone Lable Text',
            ]);
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'address_label_text',
                'display_text' => 'Address Lable Text',
            ]);
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'fax_label_text',
                'display_text' => 'Fax Lable Text',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
