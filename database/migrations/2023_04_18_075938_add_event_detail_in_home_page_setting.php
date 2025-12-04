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
        Schema::table('home_page_setting_detail', function (Blueprint $table) {
            $table->string('section2_category_label')->nullable()->after('section2_heading');
            $table->string('section2_country_label')->nullable()->after('section2_category_label');
            $table->string('section2_deadline_label')->nullable()->after('section2_country_label');
            $table->string('section2_estimated_value_label')->nullable()->after('section2_deadline_label');

            $table->string('section5_start_date_label')->nullable()->after('section5_heading');
            $table->string('section5_end_date_label')->nullable()->after('section5_start_date_label');
            $table->string('section5_venue_label')->nullable()->after('section5_end_date_label');
            $table->string('section5_city_label')->nullable()->after('section5_venue_label');
            $table->string('section5_country_label')->nullable()->after('section5_city_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('section2_category_label');
            $table->dropColumn('section2_country_label');
            $table->dropColumn('section2_deadline_label');
            $table->dropColumn('section2_estimated_value_label');

            $table->dropColumn('section5_start_date_label');
            $table->dropColumn('section5_end_date_label');
            $table->dropColumn('section5_venue_label');
            $table->dropColumn('section5_city_label');
            $table->dropColumn('section5_country_label');
        });
    }
};
