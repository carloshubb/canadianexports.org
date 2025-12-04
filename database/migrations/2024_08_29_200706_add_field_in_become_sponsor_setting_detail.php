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
            $table->text('feature_image_label', 500)->nullable();
            $table->text('feature_image_error', 500)->nullable();
            $table->text('feature_image_placeholder', 500)->nullable();
            $table->text('summary_label', 500)->nullable();
            $table->text('summary_error', 500)->nullable();
            $table->text('summary_placeholder', 500)->nullable();
            $table->text('detail_description_label', 500)->nullable();
            $table->text('detail_description_error', 500)->nullable();
            $table->text('detail_description_placeholder', 500)->nullable();
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
            $table->dropColumn('feature_image_label');
            $table->dropColumn('feature_image_error');
            $table->dropColumn('feature_image_placeholder');
            $table->dropColumn('summary_label');
            $table->dropColumn('summary_error');
            $table->dropColumn('summary_placeholder');
            $table->dropColumn('detail_description_label');
            $table->dropColumn('detail_description_error');
            $table->dropColumn('detail_description_placeholder');
        });
    }
};
