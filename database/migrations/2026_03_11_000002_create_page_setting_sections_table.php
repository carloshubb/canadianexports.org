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
        Schema::create('page_setting_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_setting_id')->nullable()->constrained('page_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('section_name')->default('Page Setting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_setting_sections');
    }
};

