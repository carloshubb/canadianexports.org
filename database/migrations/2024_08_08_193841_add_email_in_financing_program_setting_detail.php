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
        Schema::table('financing_program_setting_detail', function (Blueprint $table) {
            $table->string('email_label')->nullable()->after('name_title_error');
            $table->string('email_placeholder')->nullable()->after('email_label');
            $table->string('email_error')->nullable()->after('email_placeholder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financing_program_setting_detail', function (Blueprint $table) {
            $table->dropColumn('email_label');
            $table->dropColumn('email_placeholder');
            $table->dropColumn('email_error');
        });
    }
};
