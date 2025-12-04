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
            $table->text('event_section_heading', 500)->nullable()->after('package_section_heading');
            $table->text('contact_section_heading', 500)->nullable()->after('event_section_heading');
            $table->text('media_section_heading', 500)->nullable()->after('contact_section_heading');
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
            $table->dropColumn('media_section_heading');
            $table->dropColumn('contact_section_heading');
            $table->dropColumn('event_section_heading');
        });
    }
};
