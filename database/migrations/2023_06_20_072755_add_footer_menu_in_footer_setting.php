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
        Schema::table('footer_setting', function (Blueprint $table) {
            $table->foreignId('widget1_menu_id')->nullable()->after('id')->constrained('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('widget2_menu_id')->nullable()->after('widget1_menu_id')->constrained('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('widget3_menu_id')->nullable()->after('widget2_menu_id')->constrained('menus')->onUpdate('cascade')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('footer_setting', function (Blueprint $table) {
            $table->dropForeign('widget1_menu_id');
            $table->dropColumn('widget1_menu_id');
            $table->dropForeign('widget2_menu_id');
            $table->dropColumn('widget2_menu_id');
            $table->dropForeign('widget3_menu_id');
            $table->dropColumn('widget3_menu_id');
        });
    }
};
