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
        Schema::create('info_letter_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('info_letter_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('info_letter_setting_id')->nullable()->constrained('info_letter_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('company_name_label', 500)->nullable();
            $table->text('name_label', 500)->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('country_label', 500)->nullable();
            $table->text('button_text', 500)->nullable();
            $table->text('widget_name', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_letter_setting_detail');
        Schema::dropIfExists('info_letter_setting');
    }
};
