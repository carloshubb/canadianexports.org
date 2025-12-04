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
        Schema::create('event_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('event_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_setting_id')->nullable()->constrained('event_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('search_label', 500)->nullable();
            $table->text('search_placeholder', 500)->nullable();
            $table->text('search_error', 500)->nullable();
            $table->text('business_categories_label', 500)->nullable();
            $table->text('business_categories_placeholder', 500)->nullable();
            $table->text('business_categories_error', 500)->nullable();
            $table->text('business_categories_all_text', 500)->nullable();
            $table->text('search_button_text', 500)->nullable();
            $table->string('title_heading')->nullable();
            $table->string('industry_heading')->nullable();
            $table->string('country_heading')->nullable();
            $table->string('deadline_heading')->nullable();
            $table->string('estimated_value_heading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_setting_detail');
        Schema::dropIfExists('event_setting');
    }
};
