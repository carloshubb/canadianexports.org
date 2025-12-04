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
        Schema::table('home_page_setting_detail', function (Blueprint $table) {
            $table->string('section5_add_event_text')->nullable()->after('section5_see_all_button_text');
            $table->string('section5_add_event_url')->nullable()->after('section5_add_event_text');
            $table->string('section5_see_all_button_url')->nullable()->after('section5_see_all_button_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('section5_add_event_text');
            $table->dropColumn('section5_add_event_url');
            $table->dropColumn('section5_see_all_button_url');
        });
    }
};
