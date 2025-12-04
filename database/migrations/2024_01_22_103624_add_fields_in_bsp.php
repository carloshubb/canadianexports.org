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
            $table->string('time_to_call_label')->nullable()->after('url_placeholder');
            $table->string('time_to_call_error')->nullable()->after('time_to_call_label');
            $table->string('time_to_call_am_label')->nullable()->after('time_to_call_error');
            $table->string('time_to_call_pm_label')->nullable()->after('time_to_call_am_label');
            $table->string('appointment_label')->nullable()->after('time_to_call_pm_label');
            $table->string('appointment_error')->nullable()->after('appointment_label');
            $table->string('appointment_yes_option')->nullable()->after('appointment_error');
            $table->string('appointment_no_option')->nullable()->after('appointment_yes_option');
            $table->string('appointment_date_label')->nullable()->after('appointment_no_option');
            $table->string('appointment_date_error')->nullable()->after('appointment_date_label');
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
            $table->dropColumn('time_to_call_label');
            $table->dropColumn('time_to_call_error');
            $table->dropColumn('time_to_call_am_label');
            $table->dropColumn('time_to_call_pm_label');
            $table->dropColumn('appointment_label');
            $table->dropColumn('appointment_error');
            $table->dropColumn('appointment_yes_option');
            $table->dropColumn('appointment_no_option');
            $table->dropColumn('appointment_date_label');
            $table->dropColumn('appointment_date_error');
        });
    }
};
