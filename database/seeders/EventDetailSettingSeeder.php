<?php

namespace Database\Seeders;

use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Illuminate\Database\Seeder;

class EventDetailSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = getDefaultLanguage();
        $result = StaticTranslation::where('type', 'event_detail_setting')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Event detail setting',
                'type' => 'event_detail_setting',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'event_date_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'event_date_text',
                'display_text' => 'Event date text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'venue_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'venue_text',
                'display_text' => 'Venue text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'location_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'location_text',
                'display_text' => 'Location text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'product_search_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'product_search_text',
                'display_text' => 'Product search text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'for_exibitor_url_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'for_exibitor_url_text',
                'display_text' => 'For exibitor (URL) text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'for_visitor_url_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'for_visitor_url_text',
                'display_text' => 'For visitor (URL) text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'for_press_url_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'for_press_url_text',
                'display_text' => 'For press (URL) text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'video_url_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'video_url_text',
                'display_text' => 'Video (URL) text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'description_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'description_text',
                'display_text' => 'Description text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'book_a_stand_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'book_a_stand_text',
                'display_text' => 'Book a stand text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'organizer_contact_heading')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'organizer_contact_heading',
                'display_text' => 'Organizer contact heading',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'contact_email_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'contact_email_text',
                'display_text' => "Contact's email text",
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'contact_phone_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'contact_phone_text',
                'display_text' => "Contact's phone text",
            ]);
        }
        
        $staticTranslations = StaticTranslation::where('type', 'event_detail_setting')->get();

        foreach ($staticTranslations as $staticTranslation) {
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'contacts_text')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'visit_event_website_text')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'book_a_stand_modal_title')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'book_a_stand_modal_name')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'book_a_stand_modal_name_error')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'book_a_stand_modal_email')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'book_a_stand_modal_email_error')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'book_a_stand_modal_message')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'book_a_stand_modal_message_error')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'book_a_stand_modal_submit_btn')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'contact_information_modal_title')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'contact_information_modal_name')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'contact_information_modal_email')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'contact_information_modal_phone')->delete();
            $staticTranslationDetail = StaticTranslationDetail::where('static_translation_id', $staticTranslation->id)->where('key', 'contact_information_modal_designation')->delete();
        }
    }
}
