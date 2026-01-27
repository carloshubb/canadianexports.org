<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Stores title, email and opinion when a user submits to close their account.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('close_account_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('email');
            $table->text('opinion')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('close_account_requests');
    }
};
