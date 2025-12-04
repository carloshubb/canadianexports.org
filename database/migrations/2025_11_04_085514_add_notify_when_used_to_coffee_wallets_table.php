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
        Schema::table('coffee_wallets', function (Blueprint $table) {
            $table->boolean('notify_when_used')->default(false)->after('anonymous');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coffee_wallets', function (Blueprint $table) {
            $table->dropColumn('notify_when_used');
        });
    }
};
