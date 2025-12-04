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
        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->text('product_search_placeholder')->after('product_search_label')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->dropColumn(['product_search_placeholder']);
        });
    }
};
