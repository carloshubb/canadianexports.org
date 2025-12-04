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
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template')");

        Schema::create('event_create_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('event_create_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_create_setting_id')->nullable()->constrained('event_create_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('title_label', 500)->nullable();
            $table->text('country_label', 500)->nullable();
            $table->text('city_label', 500)->nullable();
            $table->text('street_name_label', 500)->nullable();
            $table->text('venue_label', 500)->nullable();
            $table->text('product_search_label', 500)->nullable();
            $table->text('short_description_label', 500)->nullable();
            $table->text('description_label', 500)->nullable();
            $table->text('start_date_label', 500)->nullable();
            $table->text('end_date_label', 500)->nullable();
            $table->text('event_website_label', 500)->nullable();
            $table->text('exibitors_url_label', 500)->nullable();
            $table->text('visitors_label', 500)->nullable();
            $table->text('press_url_label', 500)->nullable();
            $table->text('logo_label', 500)->nullable();
            $table->text('button_text', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template')");
        Schema::dropIfExists('event_create_setting_detail');
        Schema::dropIfExists('event_create_setting');
    }
};
