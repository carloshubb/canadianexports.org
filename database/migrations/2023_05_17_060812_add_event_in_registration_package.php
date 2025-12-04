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
            $table->enum('type', ['profile', 'event'])->default('profile')->after('id');
            $table->float('package_validity_days')->default(0)->after('free_subscription_days');
            $table->float('discount_percentage')->default(0)->after('price');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('type', ['customer', 'event'])->default('customer')->after('email');
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
            $table->dropColumn('type');
            $table->dropColumn('package_validity_days');
            $table->dropColumn('discount_percentage');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
