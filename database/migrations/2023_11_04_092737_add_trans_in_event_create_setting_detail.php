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
            $table->text('contact_info_tab_heading')->nullable();
            $table->text('delete_btn_text')->nullable();
            $table->text('add_new_contact_btn_text')->nullable();
            $table->text('social_media_tab_heading')->nullable();
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
            $table->dropColumn('contact_info_tab_heading');
            $table->dropColumn('delete_btn_text');
            $table->dropColumn('add_new_contact_btn_text');
            $table->dropColumn('social_media_tab_heading');
        });
    }
};
