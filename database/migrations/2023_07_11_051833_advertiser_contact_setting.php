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
        Schema::create('advertiser_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('advertiser_setting_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('advertiser_setting_id')->nullable()->constrained('advertiser_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('tab1_text')->nullable();
            $table->string('tab2_text')->nullable();
            $table->string('tab3_text')->nullable();
            $table->string('contact_tab_heading')->nullable();
            $table->string('required_fields_text')->nullable();
            $table->string('name_label')->nullable();
            $table->string('name_error')->nullable();
            $table->string('company_name_label')->nullable();
            $table->string('company_name_error')->nullable();
            $table->string('email_label')->nullable();
            $table->string('email_error')->nullable();
            $table->string('message_label')->nullable();
            $table->string('message_error')->nullable();
            $table->string('button_text')->nullable();
            $table->string('contact_info_heading')->nullable();
            $table->string('mail_address_text')->nullable();
            $table->string('phone_text')->nullable();
            $table->string('email_text')->nullable();
            $table->string('link_text')->nullable();
        });
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template')");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertiser_setting_detail');
        Schema::dropIfExists('advertiser_setting');
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template')");

    }
};
