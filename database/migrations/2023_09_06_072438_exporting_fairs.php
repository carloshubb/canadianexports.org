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
        Schema::create('exporting_fairs', function (Blueprint $table) {
            $table->id();
            $table->string('zipcode')->nullable();
            $table->foreignId('media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('event_website')->nullable();
            $table->string('exibitors_url')->nullable();
            $table->string('visitors_url')->nullable();
            $table->string('press_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_designation')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('pintrest_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('snapchat_url')->nullable();
            $table->timestamps();
        });

        Schema::create('exporting_fair_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exporting_fair_id')->nullable()->constrained('exporting_fairs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('street_name')->nullable();
            $table->string('venue')->nullable();
            $table->string('product_search')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exporting_fair_detail');
        Schema::dropIfExists('exporting_fair');
    }
};
