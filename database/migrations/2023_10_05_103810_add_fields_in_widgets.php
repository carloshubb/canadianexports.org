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
        Schema::table('widget_detail', function (Blueprint $table) {
            $table->text('button_text', 500)->nullable();
            $table->text('button_link', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('widget_detail', function (Blueprint $table) {
            $table->dropColumn('button_text');
            $table->dropColumn('button_link');
        });
    }
};
