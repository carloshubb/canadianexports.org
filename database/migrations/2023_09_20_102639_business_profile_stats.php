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
        Schema::create('visitor_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('platform')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });

        Schema::create('business_profile_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('customer_profile_id')->nullable()->constrained('customer_profile')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('visitor_info_id')->nullable()->constrained('visitor_info')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type', ['overview', 'contact', 'media', 'send_message'])->nullable();
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_profile_stats');
        Schema::dropIfExists('visitor_info');
    }
};
