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
        Schema::table('i2b_setting_detail', function (Blueprint $table) {
            $table->text('country_label', 500)->nullable()->after('business_categories_all_text');
            $table->text('country_placeholder', 500)->nullable()->after('country_label');
            $table->text('country_error', 500)->nullable()->after('country_placeholder');
            $table->text('country_all_text', 500)->nullable()->after('country_error');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('i2b_setting_detail', function (Blueprint $table) {
            $table->dropColumn('country_label');
            $table->dropColumn('country_placeholder');
            $table->dropColumn('country_error');
        });
    }
};
