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
            $table->enum('subscription_status', ['cancel', 'ok'])->nullable()->after('is_auto_renew');
            $table->string('subscription_id')->nullable()->after('is_auto_renew');
            $table->string('payment_method')->nullable()->after('is_auto_renew');
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
            $table->dropColumn('subscription_status');
            $table->dropColumn('subscription_id');
            $table->dropColumn('payment_method');
        });
    }
};
