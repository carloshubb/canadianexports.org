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
        Schema::create('one_more_thing', function (Blueprint $table) {
            $table->id();
            $table->string("url")->nullable();
            $table->foreignId('media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('one_more_thing_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('one_more_thing_id')->nullable()->constrained('one_more_thing')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->longText("description")->nullable();
        });

        Schema::create('one_more_thing_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('one_more_thing_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('one_more_thing_setting_id')->nullable()->constrained('one_more_thing_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string("page_heading")->nullable();
            $table->string("read_more_btn_text")->nullable();
        });

        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template', 'rates_template', 'one_more_thing_template')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('one_more_thing_detail');
        Schema::dropIfExists('one_more_thing');
        Schema::dropIfExists('one_more_thing_setting_detail');
        Schema::dropIfExists('one_more_thing_setting');
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template', 'rates_template')");
    }
};
