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
            $table->string('email_error')->nullable()->after('email_label');
            $table->string('contact_number_error')->nullable()->after('contact_number_label');
            $table->string('message_error')->nullable()->after('message_label');
            $table->string('image_label')->nullable()->after('message_error');
            $table->string('image_error')->nullable()->after('image_label');
            $table->string('url_label')->nullable()->after('image_error');
            $table->string('url_error')->nullable()->after('url_label');
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
            $table->dropColumn('email_error');
            $table->dropColumn('contact_number_error');
            $table->dropColumn('message_error');
            $table->dropColumn('image_label');
            $table->dropColumn('image_error');
            $table->dropColumn('url_label');
            $table->dropColumn('url_error');
        });
    }
};
