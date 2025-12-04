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
        Schema::table('customer_profile', function (Blueprint $table) {
            $table->string('cta_btn')->nullable();
            $table->string('cta_link', 500)->nullable();
        });
    }

    public function down()
    {
        Schema::table('customer_profile', function (Blueprint $table) {
            $table->dropColumn(['cta_btn', 'cta_link']);
        });
    }
};
