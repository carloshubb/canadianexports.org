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
        Schema::create('footer_setting', function (Blueprint $table) {
            $table->id();
            $table->string('fb_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('google_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
        Schema::create('footer_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_setting_id')->nullable()->constrained('footer_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('widget1')->nullable();
            $table->longText('widget2')->nullable();
            $table->longText('widget3')->nullable();
            $table->string('copyright_text', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('footer_setting_detail');
        Schema::dropIfExists('footer_setting');
    }
};
