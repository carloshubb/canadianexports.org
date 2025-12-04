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
            $table->longText('terms_and_conditions_label')->nullable();
            $table->text('terms_and_conditions_error', 500)->nullable();
            $table->longText('post_submit_button_text')->nullable();
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
            $table->dropColumn('terms_and_conditions_label');
            $table->dropColumn('terms_and_conditions_error');
            $table->dropColumn('post_submit_button_text');
        });
    }
};
