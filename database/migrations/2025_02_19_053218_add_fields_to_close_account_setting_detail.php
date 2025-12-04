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
        Schema::table('close_account_setting_detail', function (Blueprint $table) {
            $table->string('page_heading')->nullable();
            $table->text('name_label', 500)->nullable();
            $table->text('name_placeholder', 500)->nullable();
            $table->text('name_error', 500)->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('email_placeholder', 500)->nullable();
            $table->text('email_error', 500)->nullable();
            $table->text('message_label', 500)->nullable();
            $table->text('message_placeholder', 500)->nullable();
            $table->text('message_error', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('close_account_setting_detail', function (Blueprint $table) {
            $table->dropColumn([
                'page_heading',
                'name_label',
                'name_placeholder',
                'name_error',
                'email_label',
                'email_placeholder',
                'email_error',
                'message_label',
                'message_placeholder',
                'message_error',
            ]);
        });
    }
};
