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
        Schema::create("banners", function (Blueprint $table) {
            $table->id();
            $table->enum("type", ["banners", "sponsor"]);
            $table->string("url")->nullable();
            $table->foreignId('media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists("banners");
    }
};
