<?php

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
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template', 'rates_template', 'one_more_thing_template', 'exporting_fair_template', 'comments_template', 'faq_exporter_template', 'faq_importer_template')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template', 'rates_template', 'one_more_thing_template', 'exporting_fair_template', 'comments_template')");
    }
};
