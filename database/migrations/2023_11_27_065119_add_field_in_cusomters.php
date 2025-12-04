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
            $table->string('temp_payment_frequency')->nullable()->after('temp_registration_package_id');
            $table->string('temp_is_auto_renew')->nullable()->after('temp_payment_frequency');
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
            $table->dropColumn('temp_payment_frequency');
            $table->dropColumn('temp_is_auto_renew');
        });
    }
};
