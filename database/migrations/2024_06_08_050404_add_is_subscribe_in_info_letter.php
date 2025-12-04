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
        Schema::table('info_letter', function (Blueprint $table) {
            $table->boolean('is_subscribe')->default(0);
            $table->string('subscribe_hash')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('info_letter', function (Blueprint $table) {
            $table->dropColumn('is_subscribe');
            $table->dropColumn('subscribe_hash');
        });
    }
};
