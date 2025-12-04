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
        Schema::create('coffee_wall_packages', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->string('custom')->default(0);
            $table->string('is_default')->default(0);
            $table->string('stripe_product_id')->nullable();
            $table->string('stripe_price_id')->nullable();
            $table->string('paypal_product_id')->nullable();
            $table->string('paypal_price_id')->nullable();
            $table->timestamps();
        });
        Schema::create('coffee_wall_package_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')
                ->constrained()
                ->on('coffee_wall_packages')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('language_id')
                ->constrained()
                ->on('languages')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name')->nullable();
            $table->text('short_description')->nullable();
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
        Schema::dropIfExists('coffee_wall_package_details');
        Schema::dropIfExists('coffee_wall_packages');
    }
};
