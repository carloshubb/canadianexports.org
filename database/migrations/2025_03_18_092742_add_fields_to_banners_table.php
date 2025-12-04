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
        Schema::table('banners', function (Blueprint $table) {
        $table->string('contact_number')->nullable();
        $table->enum('time_to_call', ['am', 'pm'])->default('am');
        $table->enum('appointment', ['yes', 'no'])->default('yes');
        $table->enum('is_active', ['active', 'inactive'])->default('inactive');
        $table->string('appointment_date')->nullable();
        $table->string('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn([
                'contact_number',
                'time_to_call',
                'appointment',
                'appointment_date',
                'message','is_active'
            ]);
        });
    }
};
