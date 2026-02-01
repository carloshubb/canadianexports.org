<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds role flags so a customer can have multiple roles (Exporter, Event, Sponsor).
     * Landing dashboard is determined by priority: Exporter > Event > Sponsor.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('is_exporter')->default(false)->after('type');
            $table->boolean('is_event')->default(false)->after('is_exporter');
            $table->boolean('is_sponsor')->default(false)->after('is_event');
        });

        // Backfill from existing type column
        DB::table('customers')->where('type', 'customer')->update(['is_exporter' => true]);
        DB::table('customers')->where('type', 'event')->update(['is_event' => true]);
        DB::table('customers')->where('type', 'sponsor')->update(['is_sponsor' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['is_exporter', 'is_event', 'is_sponsor']);
        });
    }
};
