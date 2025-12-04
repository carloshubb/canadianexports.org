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
            $table->text('step_6_acc_heading', 500)->nullable()->after('step_6_heading');
            $table->text('step_5_acc_heading', 500)->nullable()->after('step_5_heading');
            $table->text('step_4_acc_heading', 500)->nullable()->after('step_4_heading');
            $table->text('step_3_acc_heading', 500)->nullable()->after('step_3_heading');
            $table->text('step_2_acc_heading', 500)->nullable()->after('step_2_heading');
            $table->text('step_1_acc_heading', 500)->nullable()->after('step_1_heading');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_media', function (Blueprint $table) {
            $table->dropColumn('video_frame');
        });

        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('step_6_acc_heading');
            $table->dropColumn('step_5_acc_heading');
            $table->dropColumn('step_4_acc_heading');
            $table->dropColumn('step_3_acc_heading');
            $table->dropColumn('step_2_acc_heading');
            $table->dropColumn('step_1_acc_heading');
        });
    }
};
