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
        Schema::table('advertiser_setting_detail', function (Blueprint $table) {
            $table->string('send_me_a_copy_text')->nullable()->after('message_error');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertiser_setting_detail', function (Blueprint $table) {
            $table->dropColumn('send_me_a_copy_text');
        });
    }
};
