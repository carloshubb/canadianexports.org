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
        Schema::table('reg_page_setting_detail', function(Blueprint $table){
            $table->text('step_2_name_error', 500)->nullable()->after('step_2_name_label');
            $table->text('step_2_email_error', 500)->nullable()->after('step_2_email_label');
            $table->text('step_2_password_error', 500)->nullable()->after('step_2_password_label');
            $table->text('step_2_confirm_password_error', 500)->nullable()->after('step_2_confirm_password_label');
            $table->text('terms_and_conditions_error', 500)->nullable()->after('terms_and_conditions_label');
            $table->text('step_3_business_categories_error', 500)->nullable()->after('step_3_business_categories_label');
            $table->text('step_4_address_error', 500)->nullable()->after('step_4_address_label');
            $table->text('step_4_email_error', 500)->nullable()->after('step_4_email_label');
            $table->text('step_4_name_error', 500)->nullable()->after('step_4_name_label');
            $table->text('step_4_description_error', 500)->nullable()->after('step_4_description_label');
            $table->text('step_4_keywords_error', 500)->nullable()->after('step_4_keywords_label');
            $table->text('step_4_phone_error', 500)->nullable()->after('step_4_phone_label');
            $table->text('step_4_short_description_error', 500)->nullable()->after('step_4_short_description_label');
            $table->text('step_4_website_error', 500)->nullable()->after('step_4_website_label');
            $table->text('step_5_video_error', 500)->nullable()->after('step_5_video_label');
            $table->text('step_5_image_1_error', 500)->nullable()->after('step_5_image_1_label');
            $table->text('step_5_image_2_error', 500)->nullable()->after('step_5_image_2_label');
            $table->text('step_5_image_3_error', 500)->nullable()->after('step_5_image_3_label');
            $table->text('step_5_image_4_error', 500)->nullable()->after('step_5_image_4_label');
            $table->text('step_5_logo_error', 500)->nullable()->after('step_5_logo_label');
            $table->text('step_6_facebook_error', 500)->nullable()->after('step_6_facebook_label');
            $table->text('step_6_linkedin_error', 500)->nullable()->after('step_6_linkedin_label');
            $table->text('step_6_twitter_error', 500)->nullable()->after('step_6_twitter_label');
            $table->text('step_6_youtube_error', 500)->nullable()->after('step_6_youtube_label');
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
            $table->dropColumn('step_2_name_error');
            $table->dropColumn('step_2_email_error');
            $table->dropColumn('step_2_password_error');
            $table->dropColumn('step_2_confirm_password_error');
            $table->dropColumn('terms_and_conditions_error');
            $table->dropColumn('step_3_business_categories_error');
            $table->dropColumn('step_4_address_error');
            $table->dropColumn('step_4_email_error');
            $table->dropColumn('step_4_name_error');
            $table->dropColumn('step_4_description_error');
            $table->dropColumn('step_4_keywords_error');
            $table->dropColumn('step_4_phone_error');
            $table->dropColumn('step_4_short_description_error');
            $table->dropColumn('step_4_website_error');
            $table->dropColumn('step_5_video_error');
            $table->dropColumn('step_5_image_1_error');
            $table->dropColumn('step_5_image_2_error');
            $table->dropColumn('step_5_image_3_error');
            $table->dropColumn('step_5_image_4_error');
            $table->dropColumn('step_5_logo_error');
            $table->dropColumn('step_6_facebook_error');
            $table->dropColumn('step_6_linkedin_error');
            $table->dropColumn('step_6_twitter_error');
            $table->dropColumn('step_6_youtube_error');
        });
    }
};
