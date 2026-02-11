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
        Schema::table('become_sponsor_setting_detail', function (Blueprint $table) {
            $table->text('sponsorship_section_heading', 500)->nullable();
            $table->text('enter_amount_placeholder', 500)->nullable();
            $table->text('talk_to_us_first_label', 500)->nullable();
            $table->text('talk_to_us_first_description', 500)->nullable();
            $table->text('no_amounts_message', 500)->nullable();
            $table->text('contact_preferences_heading', 500)->nullable();
            $table->text('best_time_to_call_label', 500)->nullable();
            $table->text('preferred_date_label', 500)->nullable();
            $table->text('call_time_morning', 500)->nullable();
            $table->text('call_time_afternoon', 500)->nullable();
            $table->text('call_time_evening', 500)->nullable();
            $table->text('account_details_heading', 500)->nullable();
            $table->text('contact_name_placeholder', 500)->nullable();
            $table->text('email_hint', 500)->nullable();
            $table->text('password_label', 500)->nullable();
            $table->text('password_hint', 500)->nullable();
            $table->text('confirm_password_label', 500)->nullable();
            $table->text('optional_text', 500)->nullable();
            $table->text('brand_story_heading', 500)->nullable();
            $table->text('featured_image_hint', 500)->nullable();
            $table->text('logo_hint', 500)->nullable();
            $table->text('summary_placeholder_long', 500)->nullable();
            $table->text('detail_description_placeholder_long', 500)->nullable();
            $table->text('message_placeholder_long', 500)->nullable();
            $table->text('featured_image_idle', 500)->nullable();
            $table->text('logo_idle', 500)->nullable();
            $table->text('payment_method_heading', 500)->nullable();
            $table->text('debit_credit_label', 500)->nullable();
            $table->text('cardholder_name_label', 500)->nullable();
            $table->text('terms_privacy_label', 500)->nullable();
            $table->text('donation_non_refundable_label', 500)->nullable();
            $table->text('processing_text', 500)->nullable();
            $table->text('reactivate_btn_text', 500)->nullable();
            $table->text('become_sponsor_btn_text', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('become_sponsor_setting_detail', function (Blueprint $table) {
            $table->dropColumn([
                'sponsorship_section_heading',
                'enter_amount_placeholder',
                'talk_to_us_first_label',
                'talk_to_us_first_description',
                'no_amounts_message',
                'contact_preferences_heading',
                'best_time_to_call_label',
                'preferred_date_label',
                'call_time_morning',
                'call_time_afternoon',
                'call_time_evening',
                'account_details_heading',
                'contact_name_placeholder',
                'email_hint',
                'password_label',
                'password_hint',
                'confirm_password_label',
                'optional_text',
                'brand_story_heading',
                'featured_image_hint',
                'logo_hint',
                'summary_placeholder_long',
                'detail_description_placeholder_long',
                'message_placeholder_long',
                'featured_image_idle',
                'logo_idle',
                'payment_method_heading',
                'debit_credit_label',
                'cardholder_name_label',
                'terms_privacy_label',
                'donation_non_refundable_label',
                'processing_text',
                'reactivate_btn_text',
                'become_sponsor_btn_text',
            ]);
        });
    }
};
