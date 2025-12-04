<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('import_temp_files', function (Blueprint $table) {
            $table->boolean('created_chunk')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('import_temp_files', function (Blueprint $table) {
            $table->dropColumn(['created_chunk']);
        });
    }
};
