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
        Schema::table('home_page_setting', function (Blueprint $table) {
            $table->string('number_of_featured_exporters')->nullable();
        });
        Schema::create('home_page_featured_exporters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('business_category_id')->nullable()->constrained('customer_profile')->onUpdate('set null')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page_setting', function (Blueprint $table) {
            $table->dropColumn('number_of_featured_exporters');
        });
        Schema::dropIfExists('home_page_featured_exporters');
    }
};
