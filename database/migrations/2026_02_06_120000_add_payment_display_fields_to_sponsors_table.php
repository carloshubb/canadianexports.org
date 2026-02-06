<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            if (!Schema::hasColumn('sponsors', 'paypal_email')) {
                $table->string('paypal_email')->nullable()->after('paypal_subscription_id');
            }
            if (!Schema::hasColumn('sponsors', 'card_brand')) {
                $table->string('card_brand')->nullable()->after('paypal_email');
            }
            if (!Schema::hasColumn('sponsors', 'card_last4')) {
                $table->string('card_last4')->nullable()->after('card_brand');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn(['paypal_email', 'card_brand', 'card_last4']);
        });
    }
};
