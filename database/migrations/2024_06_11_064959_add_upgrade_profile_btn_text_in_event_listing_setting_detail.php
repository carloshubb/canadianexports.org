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
        Schema::table('event_listing_setting_detail', function (Blueprint $table) {
            $table->string('upgrade_profile_btn_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_listing_setting_detail', function (Blueprint $table) {
            $table->dropColumn('upgrade_profile_btn_text');
        });
    }
};
