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
            $table->boolean('first_pkg_expiry_mail')->default(0);
            $table->boolean('second_pkg_expiry_mail')->default(0);
            $table->boolean('third_pkg_expiry_mail')->default(0);
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
            $table->dropColumn('first_pkg_expiry_mail');
            $table->dropColumn('second_pkg_expiry_mail');
            $table->dropColumn('third_pkg_expiry_mail');
        });
    }
};
