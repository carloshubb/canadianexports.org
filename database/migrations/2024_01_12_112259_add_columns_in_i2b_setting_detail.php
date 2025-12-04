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
            $table->string('title_heading')->nullable()->after('search_button_text');
            $table->string('industry_heading')->nullable()->after('title_heading');
            $table->string('country_heading')->nullable()->after('industry_heading');
            $table->string('deadline_heading')->nullable()->after('country_heading');
            $table->string('estimated_value_heading')->nullable()->after('deadline_heading');
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
            $table->dropColumn('title_heading');
            $table->dropColumn('industry_heading');
            $table->dropColumn('country_heading');
            $table->dropColumn('deadline_heading');
            $table->dropColumn('estimated_value_heading');
        });
    }
};
