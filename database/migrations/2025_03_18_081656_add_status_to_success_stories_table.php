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
        Schema::table('success_stories', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('inactive')->after('business_category_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('success_stories', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
