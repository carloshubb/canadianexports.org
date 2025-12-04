<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_setting_detail', function (Blueprint $table) {
            $table->text('country_label')->nullable()->after('business_categories_all_text');
            $table->text('country_placeholder')->nullable()->after('country_label');
            $table->text('country_error')->nullable()->after('country_placeholder');
            $table->text('country_all_text')->nullable()->after('country_error');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_setting_detail', function (Blueprint $table) {
            $table->dropColumn(['country_label', 'country_placeholder', 'country_error', 'country_all_text']);
        });
    }
};
