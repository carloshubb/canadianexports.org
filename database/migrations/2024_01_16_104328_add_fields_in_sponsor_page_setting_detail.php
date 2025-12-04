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
            $table->string('name_placeholder')->nullable()->after('name_error');
            $table->string('company_name_placeholder')->nullable()->after('company_name_error');
            $table->string('email_placeholder')->nullable()->after('email_error');
            $table->string('contact_number_placeholder')->nullable()->after('contact_number_error');
            $table->string('url_placeholder')->nullable()->after('url_error');
            $table->string('message_placeholder')->nullable()->after('message_error');
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
            $table->dropColumn('name_placeholder');
            $table->dropColumn('company_name_placeholder');
            $table->dropColumn('email_placeholder');
            $table->dropColumn('contact_number_placeholder');
            $table->dropColumn('message_placeholder');
        });
    }
};
