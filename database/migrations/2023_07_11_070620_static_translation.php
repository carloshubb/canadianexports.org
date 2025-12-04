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
        Schema::create('static_translation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('display_text');
            $table->string('type')->nullable();
            $table->timestamps();
        });
        Schema::create('static_translation_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('static_translation_id')->nullable()->constrained('static_translation')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('display_text');
            $table->string('key');
            $table->string('value')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('static_translation_detail');
        Schema::dropIfExists('static_translation');

    }
};
