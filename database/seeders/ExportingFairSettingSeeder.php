<?php

namespace Database\Seeders;

use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Illuminate\Database\Seeder;

class ExportingFairSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = getDefaultLanguage();
        $result = StaticTranslation::where('type', 'exporting_fair_detail_setting')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Export fair detail setting',
                'type' => 'exporting_fair_detail_setting',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_event_date_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_event_date_text',
                'display_text' => 'Event date text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_venue_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_venue_text',
                'display_text' => 'Venue text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_booth_number_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_booth_number_text',
                'display_text' => 'Booth number text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_location_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_location_text',
                'display_text' => 'Location text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_short_description_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_short_description_text',
                'display_text' => 'Short description text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_product_search_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_product_search_text',
                'display_text' => 'Product search text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_for_exibitor_url_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_for_exibitor_url_text',
                'display_text' => 'For exibitor (URL) text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_for_visitor_url_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_for_visitor_url_text',
                'display_text' => 'For visitor (URL) text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_for_press_url_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_for_press_url_text',
                'display_text' => 'For press (URL) text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_video_url_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_video_url_text',
                'display_text' => 'Video (URL) text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_description_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_description_text',
                'display_text' => 'Description text',
            ]);
        }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_book_a_stand_text')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'ef_book_a_stand_text',
        //         'display_text' => 'Book a stand text',
        //     ]);
        // }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_contacts_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_contacts_text',
                'display_text' => 'Contacts text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_visit_event_website_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_visit_event_website_text',
                'display_text' => 'Visit event website text',
            ]);
        }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_book_a_stand_modal_title')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'ef_book_a_stand_modal_title',
        //         'display_text' => 'Book a stand modal title text',
        //     ]);
        // }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_book_a_stand_modal_name')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'ef_book_a_stand_modal_name',
        //         'display_text' => 'name text',
        //     ]);
        // }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_book_a_stand_modal_name_error')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'ef_book_a_stand_modal_name_error',
        //         'display_text' => 'name error',
        //     ]);
        // }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_book_a_stand_modal_email')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'ef_book_a_stand_modal_email',
        //         'display_text' => 'email text',
        //     ]);
        // }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_book_a_stand_modal_email_error')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'ef_book_a_stand_modal_email_error',
        //         'display_text' => 'email error',
        //     ]);
        // }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_book_a_stand_modal_message')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'ef_book_a_stand_modal_message',
        //         'display_text' => 'message text',
        //     ]);
        // }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_book_a_stand_modal_message_error')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'ef_book_a_stand_modal_message_error',
        //         'display_text' => 'message text',
        //     ]);
        // }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_book_a_stand_modal_submit_btn')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'ef_book_a_stand_modal_submit_btn',
        //         'display_text' => 'Book a stand modal submit button text',
        //     ]);
        // }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_contact_information_modal_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_contact_information_modal_title',
                'display_text' => 'Contact information modal title',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_contact_information_modal_name')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_contact_information_modal_name',
                'display_text' => 'Contact information modal name text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_contact_information_modal_email')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_contact_information_modal_email',
                'display_text' => 'Contact information modal email text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_contact_information_modal_phone')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_contact_information_modal_phone',
                'display_text' => 'Contact information modal phone text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_contact_information_modal_designation')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_contact_information_modal_designation',
                'display_text' => 'Contact information modal designation text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ef_event_detail_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ef_event_detail_button_text',
                'display_text' => 'Event detail button text',
            ]);
        }
    }
}
