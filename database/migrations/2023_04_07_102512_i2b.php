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
        Schema::create('i2b', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_category_id')->nullable()->constrained('business_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->date('deadline_date')->nullable();
            $table->string('estimated_value')->nullable();
            $table->string('pdf_1')->nullable();
            $table->string('pdf_2')->nullable();
            $table->timestamps();
        });
        Schema::create('i2b_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('i2b_id')->nullable()->constrained('i2b')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('country_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('i2b_detail');
        Schema::dropIfExists('i2b');
    }
};
