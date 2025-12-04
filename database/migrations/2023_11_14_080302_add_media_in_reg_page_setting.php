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
            $table->longText('pre_media_tab_description')->nullable()->after('step_4_keywords_placeholder');
            $table->text('step_5_title_placeholder', 500)->nullable()->after('step_5_title_error');
            $table->text('step_5_description_placeholder', 500)->nullable()->after('step_5_description_error');
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
            $table->dropColumn('pre_media_tab_description');
            $table->dropColumn('step_5_title_placeholder');
            $table->dropColumn('step_5_description_placeholder');
        });
    }
};
