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
            $table->text('action_text', 500)->nullable()->after('title_text');
            $table->text('edit_button_text', 500)->nullable()->after('action_text');
            $table->text('start_at_end_at_text', 500)->nullable()->after('edit_button_text');
            $table->dropColumn('start_at_text');
            $table->dropColumn('end_at_text');
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
            $table->dropColumn('action_text');
            $table->dropColumn('edit_button_text');
            $table->text('start_at_text', 500)->nullable()->after('title_text');
            $table->text('end_at_text', 500)->nullable()->after('start_at_text');
        });
    }
};
