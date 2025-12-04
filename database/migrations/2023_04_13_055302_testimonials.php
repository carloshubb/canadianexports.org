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
        Schema::create('testimonials', function(Blueprint $table){
            $table->id();
            $table->foreignId('business_category_id')->nullable()->constrained('business_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('testimonial_detail', function(Blueprint $table){
            $table->id();
            $table->foreignId('testimonial_id')->nullable()->constrained('testimonials')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('place')->nullable();
            $table->text('comment', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testimonial_detail');
        Schema::dropIfExists('testimonials');
    }
};
