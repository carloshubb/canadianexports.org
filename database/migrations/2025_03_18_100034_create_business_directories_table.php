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
        Schema::create('business_directories', function (Blueprint $table) {
            $table->id();
            $table->text('address')->nullable();
            $table->text('city')->nullable();
            $table->text('province')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('phone')->nullable();
            $table->text('fax')->nullable();
            $table->text('industry')->nullable();
            $table->text('status')->nullable();
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
        Schema::dropIfExists('business_directories');
    }
};
