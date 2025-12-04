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
        Schema::table('events', function (Blueprint $table) {
            $table->string('contact_name')->nullable()->after('video_url');
            $table->string('contact_email')->nullable()->after('contact_name');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->string('contact_designation')->nullable()->after('contact_phone');
            $table->string('facebook_url')->nullable()->after('contact_designation');
            $table->string('twitter_url')->nullable()->after('facebook_url');
            $table->string('linkedin_url')->nullable()->after('twitter_url');
            $table->string('youtube_url')->nullable()->after('linkedin_url');
            $table->string('pintrest_url')->nullable()->after('youtube_url');
            $table->string('instagram_url')->nullable()->after('pintrest_url');
            $table->string('snapchat_url')->nullable()->after('instagram_url');
        });

        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->string('contact_name_label')->nullable()->after('logo_label');
            $table->string('contact_name_error')->nullable()->after('contact_name_label');
            $table->string('contact_email_label')->nullable()->after('contact_name_error');
            $table->string('contact_email_error')->nullable()->after('contact_email_label');
            $table->string('contact_phone_label')->nullable()->after('contact_email_error');
            $table->string('contact_phone_error')->nullable()->after('contact_phone_label');
            $table->string('contact_designation_label')->nullable()->after('contact_phone_error');
            $table->string('contact_designation_error')->nullable()->after('contact_designation_label');
            $table->string('facebook_url_label')->nullable()->after('contact_designation_error');
            $table->string('facebook_url_error')->nullable()->after('facebook_url_label');
            $table->string('twitter_url_label')->nullable()->after('facebook_url_error');
            $table->string('twitter_url_error')->nullable()->after('twitter_url_label');
            $table->string('linkedin_url_label')->nullable()->after('twitter_url_error');
            $table->string('linkedin_url_error')->nullable()->after('linkedin_url_label');
            $table->string('youtube_url_label')->nullable()->after('linkedin_url_error');
            $table->string('youtube_url_error')->nullable()->after('youtube_url_label');
            $table->string('pintrest_url_label')->nullable()->after('youtube_url_error');
            $table->string('pintrest_url_error')->nullable()->after('pintrest_url_label');
            $table->string('instagram_url_label')->nullable()->after('pintrest_url_error');
            $table->string('instagram_url_error')->nullable()->after('instagram_url_label');
            $table->string('snapchat_url_label')->nullable()->after('instagram_url_error');
            $table->string('snapchat_url_error')->nullable()->after('snapchat_url_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_designation');
            $table->dropColumn('facebook_url');
            $table->dropColumn('twitter_url');
            $table->dropColumn('linkedin_url');
            $table->dropColumn('youtube_url');
            $table->dropColumn('pintrest_url');
            $table->dropColumn('instagram_url');
            $table->dropColumn('snapchat_url');
        });
        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->dropColumn('contact_name_label');
            $table->dropColumn('contact_name_error');
            $table->dropColumn('contact_email_label');
            $table->dropColumn('contact_email_error');
            $table->dropColumn('contact_phone_label');
            $table->dropColumn('contact_phone_error');
            $table->dropColumn('contact_designation_label');
            $table->dropColumn('contact_designation_error');
            $table->dropColumn('facebook_url_label');
            $table->dropColumn('facebook_url_error');
            $table->dropColumn('twitter_url_label');
            $table->dropColumn('twitter_url_error');
            $table->dropColumn('linkedin_url_label');
            $table->dropColumn('linkedin_url_error');
            $table->dropColumn('youtube_url_label');
            $table->dropColumn('youtube_url_error');
            $table->dropColumn('pintrest_url_label');
            $table->dropColumn('pintrest_url_error');
            $table->dropColumn('instagram_url_label');
            $table->dropColumn('instagram_url_error');
            $table->dropColumn('snapchat_url_label');
            $table->dropColumn('snapchat_url_error');
        });
    }
};
