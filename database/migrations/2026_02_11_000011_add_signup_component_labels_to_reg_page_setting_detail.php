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
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->text('contact_person_heading')->nullable()->after('details_disclaimers_heading');
            $table->text('company_location_heading')->nullable()->after('contact_person_heading');
            $table->text('company_profile_heading')->nullable()->after('company_location_heading');
            $table->text('password_hint')->nullable()->after('company_profile_heading');
            $table->text('short_summary_hint')->nullable()->after('password_hint');
            $table->text('full_description_hint')->nullable()->after('short_summary_hint');
            $table->text('cta_btn_hint')->nullable()->after('full_description_hint');
            $table->text('mailing_address_lines_error')->nullable()->after('cta_btn_hint');
            $table->text('payment_frequency_legend')->nullable()->after('mailing_address_lines_error');
            $table->text('most_popular_label')->nullable()->after('payment_frequency_legend');
            $table->text('downgrade_message')->nullable()->after('most_popular_label');
            $table->text('step_5_title_hint')->nullable()->after('downgrade_message');
            $table->text('step_5_description_hint')->nullable()->after('step_5_title_hint');
            $table->text('step_5_logo_format_hint')->nullable()->after('step_5_description_hint');
            $table->text('step_5_gallery_format_hint')->nullable()->after('step_5_logo_format_hint');
            $table->text('select_payment_method_heading')->nullable()->after('step_5_gallery_format_hint');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn([
                'contact_person_heading',
                'company_location_heading',
                'company_profile_heading',
                'password_hint',
                'short_summary_hint',
                'full_description_hint',
                'cta_btn_hint',
                'mailing_address_lines_error',
                'payment_frequency_legend',
                'most_popular_label',
                'downgrade_message',
                'step_5_title_hint',
                'step_5_description_hint',
                'step_5_logo_format_hint',
                'step_5_gallery_format_hint',
                'select_payment_method_heading',
            ]);
        });
    }
};
