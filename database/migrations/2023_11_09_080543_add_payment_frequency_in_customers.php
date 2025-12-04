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
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('payment_frequency', ['monthly', 'quarterly', 'semi_annually', 'annually'])->default('monthly');
            $table->dropColumn('i2b_allowed');
            $table->dropColumn('i2b_remaining');
            $table->dropColumn('free_subscription_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('payment_frequency');
            $table->string('i2b_allowed')->nullable()->after('events_remaining');
            $table->string('i2b_remaining')->nullable()->after('i2b_allowed');
            $table->integer('free_subscription_days')->default(0);
        });
    }
};
