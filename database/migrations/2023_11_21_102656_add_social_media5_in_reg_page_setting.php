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
            $table->text('step_6_social_media5_label', 500)->nullable()->after('step_6_linkedin_placeholder');
            $table->text('step_6_social_media5_placeholder', 500)->nullable()->after('step_6_social_media5_label');
            $table->text('step_6_social_media5_error', 500)->nullable()->after('step_6_social_media5_placeholder');
        });
        Schema::table('customer_social_media', function (Blueprint $table) {
            $table->string('social_media5', 500)->nullable();
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
            $table->dropColumn('step_6_social_media5_label');
            $table->dropColumn('step_6_social_media5_placeholder');
            $table->dropColumn('step_6_social_media5_error');
        });
        Schema::table('customer_social_media', function (Blueprint $table) {
            $table->dropColumn('social_media5');
        });
    }
};
