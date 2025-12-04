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
        Schema::table('financing_program_setting_detail', function (Blueprint $table) {
            $table->string('business_name_label')->nullable();
            $table->string('business_name_placeholder')->nullable();
            $table->string('business_name_error')->nullable();
            $table->string('name_title_label')->nullable();
            $table->string('name_title_placeholder')->nullable();
            $table->string('name_title_error')->nullable();
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
