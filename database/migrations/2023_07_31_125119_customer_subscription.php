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
        Schema::create('customer_subscription', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('plan_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_plan_price_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->string('default_payment_method')->nullable();
            $table->string('default_source')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('paid_amount_currency')->nullable();
            $table->string('plan_interval')->nullable();
            $table->string('plan_interval_count')->nullable();
            $table->string('plan_period_start')->nullable();
            $table->string('plan_period_end')->nullable();
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
        Schema::dropIfExists('customer_subscription');
    }
};
