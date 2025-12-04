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
            $table->text('image_placeholder', 500)->nullable()->after('image_label');
        });
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->text('step_5_gallery_image_placeholder', 500)->nullable()->after('step_5_gallery_image_label');
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
            $table->dropColumn('image_placeholder');
        });
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('step_5_gallery_image_placeholder');
        });
    }
};
