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
            $table->text('step_2_full_name_label')->nullable()->after('step_2_profile_image_error');
            $table->text('step_2_full_name_placeholder')->nullable()->after('step_2_full_name_label');
            $table->text('step_2_job_title_label')->nullable()->after('step_2_full_name_placeholder');
            $table->text('step_2_job_title_placeholder')->nullable()->after('step_2_job_title_label');
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
            $table->dropColumn([
                'step_2_full_name_label',
                'step_2_full_name_placeholder',
                'step_2_job_title_label',
                'step_2_job_title_placeholder',
            ]);
        });
    }
};
