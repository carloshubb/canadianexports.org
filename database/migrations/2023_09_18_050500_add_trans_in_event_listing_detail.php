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
        Schema::create('event_listing_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('event_listing_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_listing_setting_id')->nullable()->constrained('event_listing_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('event_heading_text', 500)->nullable();
            $table->text('add_event_btn_text', 500)->nullable();
            $table->text('search_placeholder_text', 500)->nullable();
            $table->text('show_text', 500)->nullable();
            $table->text('events_text', 500)->nullable();
            $table->text('title_text', 500)->nullable();
            $table->text('start_at_text', 500)->nullable();
            $table->text('end_at_text', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_listing_setting_detail');
        Schema::dropIfExists('event_listing_setting');
    }
};
