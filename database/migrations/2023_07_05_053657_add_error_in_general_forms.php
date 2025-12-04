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
        Schema::table('contact_us_setting_detail', function (Blueprint $table) {
            $table->string('name_error')->nullable()->after('name_label');
            $table->string('email_error')->nullable()->after('email_label');
            $table->string('message_error')->nullable()->after('message_label');
        });
        Schema::table('event_signup_setting_detail', function (Blueprint $table) {
            $table->string('name_error')->nullable()->after('name_label');
            $table->string('email_error')->nullable()->after('email_label');
            $table->string('password_error')->nullable()->after('password_label');
            $table->string('confirm_password_error')->nullable()->after('confirm_password_label');
        });
        Schema::table('info_letter_setting_detail', function (Blueprint $table) {
            $table->string('company_name_error')->nullable()->after('company_name_label');
            $table->string('name_error')->nullable()->after('name_label');
            $table->string('email_error')->nullable()->after('email_label');
            $table->string('country_error')->nullable()->after('country_label');
        });
        Schema::table('login_page_setting_detail', function (Blueprint $table) {
            $table->string('email_error')->nullable()->after('email_label');
            $table->string('password_error')->nullable()->after('password_label');
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
            $table->dropColumn('name_error');
            $table->dropColumn('email_error');
            $table->dropColumn('message_error');
        });
        Schema::table('event_signup_setting_detail', function (Blueprint $table) {
            $table->dropColumn('name_error');
            $table->dropColumn('email_error');
            $table->dropColumn('password_error');
            $table->dropColumn('confirm_password_error');
        });
        Schema::table('info_letter_setting_detail', function (Blueprint $table) {
            $table->dropColumn('name_error');
            $table->dropColumn('email_error');
            $table->dropColumn('company_name_error');
            $table->dropColumn('country_error');
        });
        Schema::table('login_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('password_error');
            $table->dropColumn('email_error');
        });
    }
};
