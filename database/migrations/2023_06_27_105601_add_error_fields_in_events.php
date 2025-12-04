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
        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->string('title_error')->nullable()->after('title_label');
            $table->string('country_error')->nullable()->after('title_error');
            $table->string('city_error')->nullable()->after('country_error');
            $table->string('street_name_error')->nullable()->after('city_error');
            $table->string('venue_error')->nullable()->after('street_name_error');
            $table->string('product_search_error')->nullable()->after('venue_error');
            $table->string('short_description_error')->nullable()->after('product_search_error');
            $table->string('description_error')->nullable()->after('short_description_error');
            $table->string('start_date_error')->nullable()->after('description_error');
            $table->string('end_date_error')->nullable()->after('start_date_error');
            $table->string('event_website_error')->nullable()->after('end_date_error');
            $table->string('exibitors_url_error')->nullable()->after('event_website_error');
            $table->string('visitors_error')->nullable()->after('exibitors_url_error');
            $table->string('press_url_error')->nullable()->after('visitors_error');
            $table->string('logo_error')->nullable()->after('press_url_error');
            $table->string('gallery_image_label')->nullable()->after('logo_error');
            $table->string('gallery_image_error')->nullable()->after('gallery_image_label');
            $table->string('video_url_label')->nullable()->after('gallery_image_error');
            $table->string('video_url_error')->nullable()->after('video_url_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->dropColumn('title_error');
            $table->dropColumn('country_error');
            $table->dropColumn('city_error');
            $table->dropColumn('street_name_error');
            $table->dropColumn('venue_error');
            $table->dropColumn('product_search_error');
            $table->dropColumn('short_description_error');
            $table->dropColumn('description_error');
            $table->dropColumn('start_date_error');
            $table->dropColumn('end_date_error');
            $table->dropColumn('event_website_error');
            $table->dropColumn('exibitors_url_error');
            $table->dropColumn('visitors_error');
            $table->dropColumn('press_url_error');
            $table->dropColumn('logo_error');
            $table->dropColumn('gallery_image_label');
            $table->dropColumn('gallery_image_error');
            $table->dropColumn('video_url_label');
            $table->dropColumn('video_url_error');
        });
    }
};
