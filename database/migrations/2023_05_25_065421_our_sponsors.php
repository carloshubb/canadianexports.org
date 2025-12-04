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
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template')");

        Schema::table('home_page_setting_detail', function (Blueprint $table) {
            $table->string('section3_become_sponsor_btn_text')->nullable()->after('section3_button_url');
            $table->string('section3_become_sponsor_btn_url')->nullable()->after('section3_become_sponsor_btn_text');
        });

        Schema::create('become_sponsor_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('become_sponsor_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('become_sponsor_setting_id')->nullable()->constrained('become_sponsor_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('email_label', 500)->nullable();
            $table->text('contact_number_label', 500)->nullable();
            $table->text('message_label', 500)->nullable();
            $table->text('submit_btn_text', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template')");


        Schema::table('home_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('section3_become_sponsor_btn_text');
            $table->dropColumn('section3_become_sponsor_btn_url');
        });

        Schema::dropIfExists('become_sponsor_setting_detail');
        Schema::dropIfExists('become_sponsor_setting');
    }
};
