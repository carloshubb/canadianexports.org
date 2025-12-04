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
            $table->string('step1_free_pkg_text')->nullable()->after('step_1_auto_renew_label');
            $table->string('step1_feature_pkg_text')->nullable()->after('step1_free_pkg_text');
            $table->string('step1_premium_pkg_text')->nullable()->after('step1_feature_pkg_text');
            $table->string('step_5_title_label')->nullable()->after('step_5_heading');
            $table->string('step_5_title_error')->nullable()->after('step_5_title_label');
            $table->string('step_5_description_label')->nullable()->after('step_5_title_error');
            $table->string('step_5_description_error')->nullable()->after('step_5_description_label');
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
            $table->dropColumn('step1_free_pkg_text');
            $table->dropColumn('step1_feature_pkg_text');
            $table->dropColumn('step1_premium_pkg_text');
            $table->dropColumn('step_5_title_label');
            $table->dropColumn('step_5_title_error');
            $table->dropColumn('step_5_description_label');
            $table->dropColumn('step_5_description_error');
        });
    }
};
