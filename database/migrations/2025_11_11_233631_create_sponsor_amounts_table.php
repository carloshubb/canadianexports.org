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
        Schema::create('sponsor_amounts', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->string('frequency')->default('one_time'); // one_time, monthly, quarterly, annually
            $table->boolean('is_default')->default(0);
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('sponsor_amounts');
    }
};
