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
        Schema::create('financing_program_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('financing_program_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('financing_program_id')->nullable()->constrained('financing_program_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->string('required_fields_text', 500)->nullable();
            $table->string('zipcode_label', 500)->nullable();
            $table->string('zipcode_placeholder', 500)->nullable();
            $table->string('zipcode_error', 500)->nullable();
            $table->string('incorporation_label', 500)->nullable();
            $table->string('incorporation_placeholder', 500)->nullable();
            $table->string('incorporation_error', 500)->nullable();
            $table->string('full_time_employees_label', 500)->nullable();
            $table->string('full_time_employees_placeholder', 500)->nullable();
            $table->string('full_time_employees_error', 500)->nullable();
            $table->string('revenue_last_year_label', 500)->nullable();
            $table->string('revenue_last_year_placeholder', 500)->nullable();
            $table->string('revenue_last_year_error', 500)->nullable();
            $table->string('company_ownership_label', 500)->nullable();
            $table->string('company_ownership_placeholder', 500)->nullable();
            $table->string('company_ownership_error', 500)->nullable();
            $table->string('needs_intentions_label', 500)->nullable();
            $table->string('needs_intentions_placeholder', 500)->nullable();
            $table->string('needs_intentions_error', 500)->nullable();
            $table->string('primary_industry_label', 500)->nullable();
            $table->string('primary_industry_placeholder', 500)->nullable();
            $table->string('primary_industry_error', 500)->nullable();
            $table->string('submit_button_text', 500)->nullable();
        });
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template', 'rates_template', 'one_more_thing_template', 'exporting_fair_template', 'comments_template', 'faq_exporter_template', 'faq_importer_template', 'financing_program_template')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financing_program_setting_detail');
        Schema::dropIfExists('financing_program_setting');
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template', 'rates_template', 'one_more_thing_template', 'exporting_fair_template', 'comments_template', 'faq_exporter_template', 'faq_importer_template')");
    }
};
