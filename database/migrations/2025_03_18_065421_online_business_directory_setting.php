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

        Schema::create('online_business_directory_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('online_business_directory_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('online_business_directory_setting_id');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('keyword_label', 500)->nullable();
            $table->text('keyword_placeholder', 500)->nullable();
            $table->text('keyword_error', 500)->nullable();
            $table->text('city_label', 500)->nullable();
            $table->text('city_placeholder', 500)->nullable();
            $table->text('city_error', 500)->nullable();
            $table->text('province_label', 500)->nullable();
            $table->text('province_placeholder', 500)->nullable();
            $table->text('province_error', 500)->nullable();
            $table->text('industry_label', 500)->nullable();
            $table->text('industry_placeholder', 500)->nullable();
            $table->text('industry_error', 500)->nullable();
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
    }
};
