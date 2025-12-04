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
        Schema::table('become_sponsor_setting_detail', function (Blueprint $table) {
            $table->text('name_label', 500)->nullable();
            $table->text('name_error', 500)->nullable();
            $table->text('company_name_label', 500)->nullable();
            $table->text('company_name_error', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('become_sponsor_setting_detail', function (Blueprint $table) {
            $table->dropColumn('name_label');
            $table->dropColumn('name_error');
            $table->dropColumn('company_name_label');
            $table->dropColumn('company_name_error');
        });
    }
};
