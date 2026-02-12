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
            $table->text('add_another_sponsorship_btn')->nullable();
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
