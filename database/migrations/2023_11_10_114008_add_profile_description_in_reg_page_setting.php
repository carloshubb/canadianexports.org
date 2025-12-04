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
            $table->longText('step_2_acc_description')->nullable()->after('step_2_acc_heading');
        });
        Schema::table('event_listing_setting_detail', function (Blueprint $table) {
            $table->text('no_event_found_text', 500)->nullable()->after('event_heading_text');
            $table->text('user_has_events_text', 500)->nullable()->after('event_heading_text');
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
            $table->dropColumn('step_2_acc_description');
        });
        Schema::table('event_listing_setting_detail', function (Blueprint $table) {
            $table->dropColumn('no_event_found_text');
            $table->dropColumn('user_has_events_text');
        });
    }
};
