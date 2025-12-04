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
        Schema::table('event_signup_setting_detail', function (Blueprint $table) {
            $table->string('free_package_text')->nullable();
            $table->string('featured_package_text')->nullable();
            $table->string('premium_package_text')->nullable();
            $table->string('package_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_signup_setting_detail', function (Blueprint $table) {
            $table->dropColumn('free_package_text');
            $table->dropColumn('featured_package_text');
            $table->dropColumn('premium_package_text');
            $table->dropColumn('package_error');
        });
    }
};
