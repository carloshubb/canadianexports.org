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
        Schema::create('coffee_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('anonymous')->default('0');
            $table->integer('package_id')->nullable();
            $table->string('frequency')->nullable();
            $table->foreignId('customer_id')->nullable()
                ->constrained()
                ->on('customers')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('dr_amount', 18,2)->default('0.00');
            $table->decimal('cr_amount', 18,2)->default('0.00');
            $table->string('paypal_id')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('coffee_wallets');
    }
};
