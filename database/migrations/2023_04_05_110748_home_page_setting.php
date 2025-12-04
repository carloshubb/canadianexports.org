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
        Schema::create('home_page_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('home_page_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_page_setting_id')->nullable()->constrained('home_page_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('slider_heading', 500)->nullable();
            $table->text('slider_description', 500)->nullable();
            $table->text('slider_search_placeholder', 500)->nullable();
            $table->text('slider_advance_search_text', 500)->nullable();
            $table->text('slider_image', 200)->nullable();
            $table->text('section1_heading', 500)->nullable()->comment('business category listing section');
            $table->longText('section1_description')->nullable()->comment('business category listing section');
            $table->text('section1_business_category', 500)->nullable()->comment('business category listing section');
            $table->text('section1_business_category_url', 500)->nullable()->comment('business category listing section');
            $table->text('section2_heading', 500)->nullable()->comment('Inquiries to buy section');
            $table->text('section2_i2b_button_text', 500)->nullable()->comment('Inquiries to buy section');
            $table->text('section2_button_text', 500)->nullable()->comment('Inquiries to buy section');
            $table->text('section2_button_url', 500)->nullable()->comment('Inquiries to buy section');
            $table->text('section3_heading', 500)->nullable()->comment('Our sponsors section');
            $table->text('section3_button_text', 500)->nullable()->comment('Our sponsors section');
            $table->text('section3_button_url', 500)->nullable()->comment('Our sponsors section');
            $table->text('section4_heading', 500)->nullable()->comment('Featured businesses section');
            $table->text('section5_heading', 500)->nullable()->comment('Featured events section');
            $table->text('section5_event_detail_button_text', 500)->nullable()->comment('Featured events section');
            $table->text('section5_website_button_text', 500)->nullable()->comment('Featured events section');
            $table->text('section5_see_all_button_text', 500)->nullable()->comment('Featured events section');
            $table->text('section6_heading', 500)->nullable()->comment('Canadian Exports magazine');
            $table->longText('section6_description')->nullable()->comment('Canadian Exports magazine');
            $table->text('section6_see_all_button', 500)->nullable()->comment('Canadian Exports magazine');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_page_setting_detail');
        Schema::dropIfExists('home_page_setting');
    }
};
