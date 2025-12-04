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
        Schema::create('registration_packages', function(Blueprint $table){
            $table->id();
            $table->float('price', 11, 2)->default(0);
            $table->integer('free_subscription_days')->default(0);
            $table->boolean('is_default')->default(0);
            $table->timestamps();
        });
        
        Schema::create('registration_package_detail', function(Blueprint $table){
            $table->id();
            $table->foreignId('registration_package_id')->nullable()->constrained('registration_packages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration_package_detail');
        Schema::dropIfExists('registration_packages');
    }
};
