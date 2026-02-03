<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * type: 'main' = main event image(s), 'gallery' = photo gallery images (Premium 8, Featured 20).
     */
    public function up()
    {
        Schema::table('event_media', function (Blueprint $table) {
            $table->string('type', 32)->nullable()->default('main')->after('media_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('event_media', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
