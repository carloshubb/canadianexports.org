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
        Schema::create('rates_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('rates_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rates_setting_id')->nullable()->constrained('rates_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('free_package_text', 500)->nullable();
            $table->text('featured_package_text', 500)->nullable();
            $table->text('premium_package_text', 500)->nullable();
            $table->text('free_package_btn_text', 500)->nullable();
            $table->text('featured_package_btn_text', 500)->nullable();
            $table->text('premium_package_btn_text', 500)->nullable();
        });
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template', 'rates_template')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates_setting_detail');
        Schema::dropIfExists('rates_setting');
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template')");
    }
};
