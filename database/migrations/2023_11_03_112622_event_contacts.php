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
        Schema::create('event_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained('events')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('designation')->nullable();
            $table->string('image_path')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_designation');
        });
        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->string('profile_image_label')->nullable()->after('contact_designation_error');
            $table->string('profile_image_error')->nullable()->after('profile_image_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_contacts');

        Schema::table('events', function (Blueprint $table) {
            $table->string('contact_name')->nullable()->after('video_url');
            $table->string('contact_email')->nullable()->after('contact_name');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->string('contact_designation')->nullable()->after('contact_phone');
        });

        Schema::table('event_create_setting_detail', function (Blueprint $table) {
            $table->dropColumn('profile_image_label');
            $table->dropColumn('profile_image_error');
        });
    }
};
