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
        Schema::create('reg_page_setting', function(Blueprint $table){
            $table->id();
            $table->timestamps();
        });
        Schema::create('reg_page_setting_detail', function(Blueprint $table){
            $table->id();
            $table->foreignId('reg_page_setting_id')->nullable()->constrained('reg_page_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('page_title', 500)->nullable();
            $table->longText('page_description')->nullable();
            
            $table->text('step_1_heading', 500)->nullable();
            $table->longText('step_1_description')->nullable();
            $table->text('step_1_auto_renew_label', 500)->nullable();

            $table->text('step_2_heading', 500)->nullable();
            $table->text('step_2_name_label', 500)->nullable();
            $table->text('step_2_name_placeholder', 500)->nullable();
            $table->text('step_2_email_label', 500)->nullable();
            $table->text('step_2_email_placeholder', 500)->nullable();
            $table->text('step_2_password_label', 500)->nullable();
            $table->text('step_2_password_placeholder', 500)->nullable();
            $table->text('step_2_confirm_password_label', 500)->nullable();
            $table->text('step_2_confirm_password_placeholder', 500)->nullable();

            $table->text('step_3_heading', 500)->nullable();
            $table->longText('step_3_description')->nullable();
            $table->text('step_3_business_categories_label', 500)->nullable();
            $table->text('step_3_business_categories_placeholder', 500)->nullable();

            $table->text('step_4_heading', 500)->nullable();
            $table->text('step_4_name_label', 500)->nullable();
            $table->text('step_4_name_placeholder', 500)->nullable();
            $table->text('step_4_email_label', 500)->nullable();
            $table->text('step_4_email_placeholder', 500)->nullable();
            $table->text('step_4_address_label', 500)->nullable();
            $table->text('step_4_address_placeholder', 500)->nullable();
            $table->text('step_4_phone_label', 500)->nullable();
            $table->text('step_4_phone_placeholder', 500)->nullable();
            $table->text('step_4_website_label', 500)->nullable();
            $table->text('step_4_website_placeholder', 500)->nullable();
            $table->text('step_4_short_description_label', 500)->nullable();
            $table->text('step_4_short_description_placeholder', 500)->nullable();
            $table->text('step_4_description_label', 500)->nullable();
            $table->text('step_4_description_placeholder', 500)->nullable();
            $table->text('step_4_keywords_label', 500)->nullable();
            $table->text('step_4_keywords_placeholder', 500)->nullable();
            
            $table->text('step_5_heading', 500)->nullable();
            $table->text('step_5_logo_label', 500)->nullable();
            $table->text('step_5_logo_placeholder', 500)->nullable();
            $table->text('step_5_video_label', 500)->nullable();
            $table->text('step_5_video_placeholder', 500)->nullable();
            $table->text('step_5_image_1_label', 500)->nullable();
            $table->text('step_5_image_1_placeholder', 500)->nullable();
            $table->text('step_5_image_2_label', 500)->nullable();
            $table->text('step_5_image_2_placeholder', 500)->nullable();
            $table->text('step_5_image_3_label', 500)->nullable();
            $table->text('step_5_image_3_placeholder', 500)->nullable();
            $table->text('step_5_image_4_label', 500)->nullable();
            $table->text('step_5_image_4_placeholder', 500)->nullable();

            
            $table->text('step_6_heading', 500)->nullable();
            $table->text('step_6_facebook_label', 500)->nullable();
            $table->text('step_6_facebook_placeholder', 500)->nullable();
            $table->text('step_6_twitter_label', 500)->nullable();
            $table->text('step_6_twitter_placeholder', 500)->nullable();
            $table->text('step_6_youtube_label', 500)->nullable();
            $table->text('step_6_youtube_placeholder', 500)->nullable();
            $table->text('step_6_linkedin_label', 500)->nullable();
            $table->text('step_6_linkedin_placeholder', 500)->nullable();
            
            $table->text('terms_and_conditions_label', 500)->nullable();
            $table->text('submit_button_text', 500)->nullable();
            $table->text('footer_text', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reg_page_setting_detail');
        Schema::dropIfExists('reg_page_setting');
    }
};
