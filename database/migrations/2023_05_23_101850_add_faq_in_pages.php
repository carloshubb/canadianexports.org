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
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template')");

        Schema::create('faq', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('faq_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_id')->nullable()->constrained('faq')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('question', 500)->nullable();
            $table->longText('answer', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template')");
        Schema::dropIfExists('faq_detail');
        Schema::dropIfExists('faq');
    }
};
