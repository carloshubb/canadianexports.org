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
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->float('event_price', 11, 2)->default(0)->after('events_allowed');
            $table->string('event_stripe_id')->nullable()->after('event_price');
            $table->string('event_paypal_id')->nullable()->after('event_stripe_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->dropColumn('event_price');
            $table->dropColumn('event_stripe_id');
            $table->dropColumn('event_paypal_id');
        });
    }
};
