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
        Schema::create('customer_media', function(Blueprint $table){
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('logo')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('image_1')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('image_2')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('image_3')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('image_4')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('video')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_media');
    }
};
