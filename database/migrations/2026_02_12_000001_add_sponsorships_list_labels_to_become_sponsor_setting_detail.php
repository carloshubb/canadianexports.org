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
            $table->text('manage_sponsorship_heading')->nullable();
            $table->text('manage_sponsorship_subtitle')->nullable();
            $table->text('manage_sponsorship_thanks')->nullable();
            $table->string('add_new_sponsorship')->nullable();
            $table->string('add_new_sponsorship_subtitle')->nullable();
            $table->string('choose_your_option')->nullable();
            $table->string('enter_your_amount')->nullable();
            $table->string('enter_your_amount_desc')->nullable();
            $table->string('sponsorship_details')->nullable();
            $table->string('enter_sponsorship_amount')->nullable();
            $table->string('select_beneficiary')->nullable();
            $table->string('contact_preferences')->nullable();
            $table->string('select_time_placeholder')->nullable();
            $table->string('preferred_call_date_optional')->nullable();
            $table->string('contact_information')->nullable();
            $table->string('from_your_account')->nullable();
            $table->string('contact_number_help')->nullable();
            $table->string('sponsorship_information')->nullable();
            $table->string('company_business_name')->nullable();
            $table->string('company_business_name_help')->nullable();
            $table->string('brief_description')->nullable();
            $table->string('brief_description_placeholder')->nullable();
            $table->string('detailed_description')->nullable();
            $table->string('detailed_description_placeholder')->nullable();
            $table->string('additional_message_optional')->nullable();
            $table->string('additional_message_placeholder')->nullable();
            $table->string('images_optional')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('pay_with_credit_card')->nullable();
            $table->string('cardholder_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('back_to_my_sponsorships')->nullable();
            $table->string('processing')->nullable();
            $table->string('submit_contact_request')->nullable();
            $table->string('complete_payment_add_sponsorship')->nullable();
            $table->string('company_website')->nullable();
            $table->text('add_new_sponsorship_btn')->nullable();
            $table->text('loading_sponsorships')->nullable();
            $table->text('no_sponsorships_heading')->nullable();
            $table->text('no_sponsorships_message')->nullable();
            $table->text('create_first_sponsorship_btn')->nullable();
            $table->text('status_active')->nullable();
            $table->text('status_pending')->nullable();
            $table->text('status_inactive')->nullable();
            $table->text('change_frequency_btn')->nullable();
            $table->text('collapse_btn')->nullable();
            $table->text('payment_status_paid')->nullable();
            $table->text('payment_status_pending')->nullable();
            $table->text('payment_status_not_required')->nullable();
            $table->text('payment_status_failed')->nullable();
            $table->text('payment_status_refunded')->nullable();
            $table->text('label_amount')->nullable();
            $table->text('label_beneficiary')->nullable();
            $table->text('label_created')->nullable();
            $table->text('label_payment_method')->nullable();
            $table->text('edit_btn')->nullable();
            $table->text('reactivation_panel_message')->nullable();
            $table->text('next_billing_date_label')->nullable();
            $table->text('upgrade_btn')->nullable();
            $table->text('reactivate_heading')->nullable();
            $table->text('loading_overlay_text')->nullable();
            $table->text('payment_method_ending_in')->nullable();
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
                'manage_sponsorship_heading',
                'manage_sponsorship_subtitle',
                'manage_sponsorship_thanks',
                'add_another_sponsorship_btn',
                'loading_sponsorships',
                'no_sponsorships_heading',
                'no_sponsorships_message',
                'create_first_sponsorship_btn',
                'status_active',
                'status_pending',
                'status_inactive',
                'change_frequency_btn',
                'collapse_btn',
                'payment_status_paid',
                'payment_status_pending',
                'payment_status_not_required',
                'payment_status_failed',
                'payment_status_refunded',
                'label_amount',
                'label_beneficiary',
                'label_created',
                'label_payment_method',
                'edit_btn',
                'reactivation_panel_message',
                'next_billing_date_label',
                'upgrade_btn',
                'reactivate_heading',
                'loading_overlay_text',
                'payment_method_ending_in',
            ]);
        });
    }
};
