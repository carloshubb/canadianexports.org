<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoffeeWallBeneficiariesTable extends Migration
{
    public function up()
    {
        Schema::create('coffee_wall_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coffee_wall_beneficiaries');
    }
}
