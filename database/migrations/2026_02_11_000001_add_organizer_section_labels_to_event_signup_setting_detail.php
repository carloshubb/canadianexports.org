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
            $table->text('your_profile_heading', 500)->nullable()->after('organizer_website_label');
            $table->text('the_organizer_heading', 500)->nullable()->after('your_profile_heading');
            $table->text('contact_person_heading', 500)->nullable()->after('the_organizer_heading');
            $table->text('organizer_phone_label', 500)->nullable()->after('contact_person_heading');
            $table->text('mailing_address_label', 500)->nullable()->after('organizer_phone_label');
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
            $table->dropColumn([
                'your_profile_heading',
                'the_organizer_heading',
                'contact_person_heading',
                'organizer_phone_label',
                'mailing_address_label',
            ]);
        });
    }
};
