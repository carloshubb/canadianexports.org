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
            $table->text('profile_section_heading', 500)->nullable()->after('language_id');
            $table->text('business_name_label', 500)->nullable()->after('name_error');
            $table->text('business_name_error', 500)->nullable()->after('business_name_label');
            $table->text('package_section_heading', 500)->nullable()->after('confirm_password_error');
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
            $table->dropColumn('profile_section_heading');
            $table->dropColumn('business_name_label');
            $table->dropColumn('business_name_error');
            $table->dropColumn('package_section_heading');
        });
    }
};
