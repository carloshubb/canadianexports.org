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
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->boolean('is_event_enable')->default(0)->after('sorting_order');
            $table->string('events_allowed')->nullable()->after('is_event_enable');
            $table->boolean('is_i2b_enable')->default(0)->after('events_allowed');
            $table->string('i2b_allowed')->nullable()->after('is_i2b_enable');
        });
        \DB::statement("ALTER TABLE registration_packages MODIFY package_type ENUM('free','featured','premium', 'pay_to_go')");
        
        Schema::table('customers', function (Blueprint $table) {
            $table->string('events_allowed')->nullable()->after('package_expiry_date');
            $table->string('events_remaining')->nullable()->after('events_allowed');
            $table->string('i2b_allowed')->nullable()->after('events_remaining');
            $table->string('i2b_remaining')->nullable()->after('i2b_allowed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->dropColumn('is_event_enable');
            $table->dropColumn('events_allowed');
            $table->dropColumn('is_i2b_enable');
            $table->dropColumn('i2b_allowed');
        });
        \DB::statement("ALTER TABLE registration_packages MODIFY package_type ENUM('free','featured','premium')");
    }
};
