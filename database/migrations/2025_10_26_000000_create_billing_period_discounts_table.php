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
        Schema::create('billing_period_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('period_type')->unique(); // quarterly, semi_annually, annually
            $table->decimal('discount_percentage', 5, 2)->default(0); // percentage value (e.g., 10.00 for 10%)
            $table->decimal('multiplier', 5, 4)->default(1.0000); // calculated multiplier (e.g., 0.9 for 10% discount)
            $table->integer('months')->default(1); // number of months for this period
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
        Schema::dropIfExists('billing_period_discounts');
    }
};
