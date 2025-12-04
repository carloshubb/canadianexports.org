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
        Schema::table('rates_setting_detail', function (Blueprint $table) {
            $table->longText('price_table_pre_text')->nullable()->after('language_id');
            $table->longText('price_table_post_text')->nullable()->after('price_table_pre_text');
            $table->dropColumn('free_package_text');
            $table->dropColumn('featured_package_text');
            $table->dropColumn('premium_package_text');
            $table->dropColumn('free_package_btn_text');
            $table->dropColumn('featured_package_btn_text');
            $table->dropColumn('premium_package_btn_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rates_setting_detail', function (Blueprint $table) {
            $table->text('free_package_text', 500)->nullable();
            $table->text('featured_package_text', 500)->nullable();
            $table->text('premium_package_text', 500)->nullable();
            $table->text('free_package_btn_text', 500)->nullable();
            $table->text('featured_package_btn_text', 500)->nullable();
            $table->text('premium_package_btn_text', 500)->nullable();
            $table->dropColumn('price_table_pre_text');
            $table->dropColumn('price_table_post_text');
        });
    }
};
