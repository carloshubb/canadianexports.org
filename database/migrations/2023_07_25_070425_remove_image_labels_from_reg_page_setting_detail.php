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
            $table->dropColumn('step_5_image_1_label');
            $table->dropColumn('step_5_image_1_error');
            $table->dropColumn('step_5_image_1_placeholder');
            $table->dropColumn('step_5_image_2_label');
            $table->dropColumn('step_5_image_2_error');
            $table->dropColumn('step_5_image_2_placeholder');
            $table->dropColumn('step_5_image_3_label');
            $table->dropColumn('step_5_image_3_error');
            $table->dropColumn('step_5_image_3_placeholder');
            $table->dropColumn('step_5_image_4_label');
            $table->dropColumn('step_5_image_4_error');
            $table->dropColumn('step_5_image_4_placeholder');
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
            $table->text('step_5_image_1_label', 500)->nullable();
            $table->text('step_5_image_1_placeholder', 500)->nullable();
            $table->text('step_5_image_2_label', 500)->nullable();
            $table->text('step_5_image_2_placeholder', 500)->nullable();
            $table->text('step_5_image_3_label', 500)->nullable();
            $table->text('step_5_image_3_placeholder', 500)->nullable();
            $table->text('step_5_image_4_label', 500)->nullable();
            $table->text('step_5_image_4_placeholder', 500)->nullable();
        });
    }
};
