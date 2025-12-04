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
        Schema::create('business_categories', function(Blueprint $table){
            $table->id();
            $table->timestamps();
        });
        Schema::create('business_category_detail', function(Blueprint $table){
            $table->id();
            $table->foreignId('business_category_id')->nullable()->constrained('business_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_category_detail');
        Schema::dropIfExists('business_categories');
    }
};
