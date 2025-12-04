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
        Schema::table('home_page_setting_detail', function (Blueprint $table) {
            $table->string('sponsor_value_button_text')->nullable()->after('section3_button_url');
            $table->string('sponsor_value_button_url')->nullable()->after('sponsor_value_button_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('sponsor_value_button_text');
            $table->dropColumn('sponsor_value_button_url');
        });
    }
};
