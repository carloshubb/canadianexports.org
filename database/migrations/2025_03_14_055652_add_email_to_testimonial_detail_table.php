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
        Schema::table('testimonial_detail', function (Blueprint $table) {
            $table->string('email')->nullable()->after('comment'); // Add the `email` column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('testimonial_detail', function (Blueprint $table) {
            $table->dropColumn('email'); // Remove the `email` column if the migration is rolled back
        });
    }
};
