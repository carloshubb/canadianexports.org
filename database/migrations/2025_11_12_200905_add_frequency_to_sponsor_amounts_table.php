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
        Schema::table('sponsor_amounts', function (Blueprint $table) {
            $table->string('frequency')->default('one_time')->after('amount'); // one_time, monthly, quarterly, annually
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsor_amounts', function (Blueprint $table) {
            $table->dropColumn('frequency');
        });
    }
};
