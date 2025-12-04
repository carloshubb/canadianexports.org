<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE business_profile_stats MODIFY COLUMN type ENUM('overview', 'contact', 'media', 'send_message', 'cta_click') NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE business_profile_stats MODIFY COLUMN type ENUM('overview', 'contact', 'media', 'send_message') NULL;");
    }
};
