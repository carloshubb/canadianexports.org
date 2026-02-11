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
        Schema::table('event_signup_setting_detail', function (Blueprint $table) {
            $table->text('contact_name_label', 500)->nullable()->after('mailing_address_label');
            $table->text('contact_phone_label', 500)->nullable()->after('contact_name_label');
            $table->text('contact_phone_hint', 500)->nullable()->after('contact_phone_label');
            $table->text('contact_email_label', 500)->nullable()->after('contact_phone_hint');
            $table->text('contact_email_hint', 500)->nullable()->after('contact_email_label');
            $table->text('contact_photo_label', 500)->nullable()->after('contact_email_hint');
            $table->text('contact_photo_tooltip', 500)->nullable()->after('contact_photo_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_signup_setting_detail', function (Blueprint $table) {
            $table->dropColumn([
                'contact_name_label',
                'contact_phone_label',
                'contact_phone_hint',
                'contact_email_label',
                'contact_email_hint',
                'contact_photo_label',
                'contact_photo_tooltip',
            ]);
        });
    }
};
