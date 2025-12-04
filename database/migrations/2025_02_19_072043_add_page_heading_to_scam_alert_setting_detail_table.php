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
        Schema::table('scam_alert_setting_detail', function (Blueprint $table) {
            $table->string('page_heading')->nullable()->after('scam_alert_setting_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scam_alert_setting_detail', function (Blueprint $table) {
            $table->dropColumn('page_heading');
        });
    }
};
