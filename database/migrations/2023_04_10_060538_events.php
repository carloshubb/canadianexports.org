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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('zipcode')->nullable();
            $table->foreignId('media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('event_website')->nullable();
            $table->string('exibitors_url')->nullable();
            $table->string('visitors_url')->nullable();
            $table->string('press_url')->nullable();
            $table->timestamps();
        });
        Schema::create('event_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained('events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('street_name')->nullable();
            $table->string('venue')->nullable();
            $table->string('product_search')->nullable();
            $table->string('short_description')->nullable();
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("event_detail");
        Schema::dropIfExists("events");
    }
};
