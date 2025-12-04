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
        Schema::create('menus', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_main_menu')->default(0);
            $table->boolean('is_footer_menu')->default(0);
            $table->timestamps();
        });
        Schema::create('menu_detail', function(Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->nullable()->constrained('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->json('menu_items')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("menu_detail");
        Schema::dropIfExists("menus");
    }
};
