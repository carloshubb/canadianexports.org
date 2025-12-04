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
        // Create scam_alert_setting table
        Schema::create('scam_alert_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        // Create scam_alert_setting_detail table
        Schema::create('scam_alert_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scam_alert_setting_id');
            $table->foreign('scam_alert_setting_id', 'scam_alert_setting_detail_scam_alert_id_foreign')
                  ->references('id')->on('scam_alert_setting')
                  ->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('required_fields_text', 500)->nullable();
            $table->text('name_label', 500)->nullable();
            $table->text('name_placeholder', 500)->nullable();
            $table->text('name_error', 500)->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('email_placeholder', 500)->nullable();
            $table->text('email_error', 500)->nullable();
            $table->text('message_label', 500)->nullable();
            $table->text('message_placeholder', 500)->nullable();
            $table->text('message_error', 500)->nullable();
            $table->text('button_text', 500)->nullable();
            $table->timestamps();
        });

\DB::statement("ALTER TABLE `pages` CHANGE `template` `template` ENUM('login_template','register_template','home_template','about_us_template','contact_us_template','inquiries_to_buy_template','testimonial_template','info_letter_template','event_template','sponsor_template','event_signup_template','event_create_template','faq_template','event_listing_template','become_sponsor_template','magazine_template','forget_page_template','advertiser_page_template','close_account_template','rates_template','one_more_thing_template','exporting_fair_template','comments_template','faq_exporter_template','faq_importer_template','financing_program_template','sponsor_listing', 'contact_for_rates_template', 'scam_alert_template') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop scam_alert_setting_detail table
        Schema::dropIfExists('scam_alert_setting_detail');

        // Drop scam_alert_setting table
        Schema::dropIfExists('scam_alert_setting');

        \DB::statement("ALTER TABLE `pages` CHANGE `template` `template` ENUM('login_template','register_template','home_template','about_us_template','contact_us_template','inquiries_to_buy_template','testimonial_template','info_letter_template','event_template','sponsor_template','event_signup_template','event_create_template','faq_template','event_listing_template','become_sponsor_template','magazine_template','forget_page_template','advertiser_page_template','close_account_template','rates_template','one_more_thing_template','exporting_fair_template','comments_template','faq_exporter_template','faq_importer_template','financing_program_template','sponsor_listing','contact_for_rates_template') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");

    }
};
