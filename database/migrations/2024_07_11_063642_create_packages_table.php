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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['profile', 'event', 'i2b'])->nullable();
            $table->enum('package_type', ['free', 'featured', 'premium', 'pay_to_go'])->nullable();
            $table->decimal('monthly_price', 8, 2)->nullable();
            $table->decimal('quarterly_price', 8, 2)->nullable();
            $table->decimal('semi_annual_price', 8, 2)->nullable();
            $table->decimal('annual_price', 8, 2)->nullable();
            $table->decimal('event_price', 8, 2)->nullable();
            $table->string('images_allowed')->nullable();
            $table->string('events_allowed')->nullable();
            $table->string('sorting_order')->nullable();
            $table->boolean('is_default')->default(0);
            $table->string('stripe_product_id')->nullable();
            $table->string('monthly_stripe_price_id')->nullable();
            $table->string('quarterly_stripe_price_id')->nullable();
            $table->string('semi_annual_stripe_price_id')->nullable();
            $table->string('annual_stripe_price_id')->nullable();
            $table->string('paypal_plan_id')->nullable();
            $table->string('par_monthly_id')->nullable();
            $table->string('pnar_monthly_id')->nullable();
            $table->string('par_quaterly_id')->nullable();
            $table->string('pnar_quaterly_id')->nullable();
            $table->string('par_semi_annual_id')->nullable();
            $table->string('pnar_semi_annual_id')->nullable();
            $table->string('par_annual_id')->nullable();
            $table->string('pnar_annual_id')->nullable();
            $table->timestamps();
        });
        Schema::create('package_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->nullable()->constrained('packages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->longText('short_description');
            $table->timestamps();
        });
        Schema::create('package_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->nullable()->constrained('packages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
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
        Schema::dropIfExists('package_features');
        Schema::dropIfExists('package_detail');
        Schema::dropIfExists('packages');
    }
};
