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
        Schema::create('page_setting_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_section_id')->nullable()->constrained('page_setting_sections')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('text')->nullable();
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
        Schema::dropIfExists('page_setting_contents');
    }
};

