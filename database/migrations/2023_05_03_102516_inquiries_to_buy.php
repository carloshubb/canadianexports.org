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
        Schema::create('contact_us_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('contact_us_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_us_setting_id')->nullable()->constrained('contact_us_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('name_label', 500)->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('message_label', 500)->nullable();
            $table->text('button_text', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_us_setting_detail');
        Schema::dropIfExists('contact_us_setting');
    }
};
