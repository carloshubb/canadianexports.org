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
        Schema::table('holiday_emails', function (Blueprint $table) {
            $table->boolean('is_subscribe')->default(1)->after('is_email_sent');
            $table->string('subscribe_hash')->nullable()->after('is_subscribe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('holiday_emails', function (Blueprint $table) {
            $table->dropColumn('is_subscribe');
            $table->dropColumn('subscribe_hash');
        });
    }
};
