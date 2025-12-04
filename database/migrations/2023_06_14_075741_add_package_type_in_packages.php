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
            $table->enum('package_type', ['free', 'featured', 'premium'])->nullable()->after('type');
        });
        \DB::statement("ALTER TABLE registration_packages MODIFY type ENUM('profile','event','i2b')");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->dropColumn('package_type');
        });
        \DB::statement("ALTER TABLE registration_packages MODIFY type ENUM('profile','event')");

    }
};
