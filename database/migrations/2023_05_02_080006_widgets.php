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
        Schema::create('widgets', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_code');
            $table->enum('type', ['full_width', 'half_width_right_image', 'half_width_left_image'])->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
        Schema::create('widget_detail', function(Blueprint $table) {
            $table->id();
            $table->foreignId('widget_id')->nullable()->constrained('widgets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('text_detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("widgets");
        Schema::dropIfExists("widget_detail");
    }
};
