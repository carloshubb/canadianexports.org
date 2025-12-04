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
        Schema::table('contact_form', function (Blueprint $table) {
            $table->enum('type', ['comments', 'contact'])->nullable();
        });
        Schema::table('contact_us_setting_detail', function (Blueprint $table) {
            $table->longText('page_heading')->nullable();
            $table->longText('page_description')->nullable();
            $table->longText('mail_address_label')->nullable();
            $table->longText('mail_address')->nullable();
            $table->longText('website_label')->nullable();
            $table->longText('website')->nullable();
            $table->longText('toll_free_label')->nullable();
            $table->longText('toll_free')->nullable();
            $table->longText('general_inquires_label')->nullable();
            $table->longText('general_inquires')->nullable();
            $table->longText('telephone_label')->nullable();
            $table->longText('telephone')->nullable();
            $table->longText('sales_department_label')->nullable();
            $table->longText('sales_department')->nullable();
            $table->longText('fax_label')->nullable();
            $table->longText('fax')->nullable();
            $table->longText('job_at_canadian_exporters_label')->nullable();
            $table->longText('job_at_canadian_exporters')->nullable();
            $table->longText('e_mail_label')->nullable();
            $table->longText('e_mail')->nullable();
            $table->longText('office_hours_label')->nullable();
            $table->longText('office_hours')->nullable();
            $table->longText('heading')->nullable();
            $table->longText('required_field_text')->nullable();
        });

        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template', 'rates_template', 'one_more_thing_template', 'exporting_fair_template', 'comments_template')");

        Schema::create('comments_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('comments_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comments_setting_id')->nullable()->constrained('comments_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('page_heading')->nullable();
            $table->longText('page_description')->nullable();
            $table->longText('heading')->nullable();
            $table->longText('required_field_text')->nullable();
            $table->text('name_label', 500)->nullable();
            $table->text('name_error', 500)->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('email_error', 500)->nullable();
            $table->text('message_label', 500)->nullable();
            $table->text('message_error', 500)->nullable();
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
        Schema::table('contact_us_setting_detail', function (Blueprint $table) {
            $table->dropColumn('page_heading');
            $table->dropColumn('page_description');
            $table->dropColumn('mail_address_label');
            $table->dropColumn('mail_address');
            $table->dropColumn('website_label');
            $table->dropColumn('website');
            $table->dropColumn('toll_free_label');
            $table->dropColumn('toll_free');
            $table->dropColumn('general_inquires_label');
            $table->dropColumn('general_inquires');
            $table->dropColumn('telephone_label');
            $table->dropColumn('telephone');
            $table->dropColumn('sales_department_label');
            $table->dropColumn('sales_department');
            $table->dropColumn('fax_label');
            $table->dropColumn('fax');
            $table->dropColumn('job_at_canadian_exporters_label');
            $table->dropColumn('job_at_canadian_exporters');
            $table->dropColumn('e_mail_label');
            $table->dropColumn('e_mail');
            $table->dropColumn('office_hours_label');
            $table->dropColumn('office_hours');
            $table->dropColumn('heading');
            $table->dropColumn('required_field_text');
        });
        \DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template', 'event_signup_template', 'event_create_template', 'faq_template', 'event_listing_template', 'become_sponsor_template', 'magazine_template', 'forget_page_template', 'advertiser_page_template', 'close_account_template', 'rates_template', 'one_more_thing_template', 'exporting_fair_template')");
        Schema::dropIfExists('comments_setting_detail');
        Schema::dropIfExists('comments_setting');
        Schema::table('contact_form', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
