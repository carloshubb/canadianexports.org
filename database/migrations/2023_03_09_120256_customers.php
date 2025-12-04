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
        Schema::create('customers', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('registration_package_id')->nullable()->constrained('registration_packages')->onUpdate('cascade')->onDelete('cascade');
            $table->float('package_price', 11, 2)->default(0);
            $table->integer('free_subscription_days')->default(0);
            $table->date('package_subscribed_date')->nullable();
            $table->date('package_expiry_date')->nullable();
            $table->boolean('is_package_amount_paid')->default(0);
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
        Schema::dropIfExists('customers');
    }
};
