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
        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->text('short_description_placeholder')->after('short_description_label')->nullable();
            $table->text('description_placeholder')->after('description_label')->nullable();
            $table->text('event_website_placeholder')->after('event_website_label')->nullable();
            $table->text('exibitors_url_placeholder')->after('exibitors_url_label')->nullable();
            $table->text('visitors_placeholder')->after('visitors_label')->nullable();
            $table->text('press_url_placeholder')->after('press_url_label')->nullable();
            $table->text('video_url_placeholder')->after('video_url_label')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->dropColumn(['video_url_placeholder', 'press_url_placeholder', 'visitors_placeholder', 'exibitors_url_placeholder', 'event_website_placeholder', 'description_placeholder', 'short_description_placeholder']);
        });
    }
};
