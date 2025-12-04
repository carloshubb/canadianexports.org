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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            
            // Company & Contact Information
            $table->string('business_name');
            $table->string('slug')->unique();
            $table->string('contact_name');
            $table->string('email');
            $table->string('contact_number');
            $table->string('url')->nullable(); // Company website
            
            // Logo and Featured Image
            $table->foreignId('logo_media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('featured_media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('set null');
            
            // Descriptions
            $table->text('summary')->nullable(); // Short description
            $table->text('detail_description')->nullable(); // Detailed description
            $table->text('message')->nullable(); // Additional message
            
            // Sponsorship Type & Amount
            $table->enum('sponsorship_type', ['paid', 'talk_to_us'])->default('paid');
            $table->decimal('sponsorship_amount', 10, 2)->nullable(); // Custom amount entered
            
            // Talk to Us First - Contact Preferences
            $table->boolean('talk_to_us_first')->default(false);
            $table->string('preferred_call_time')->nullable(); // AM/PM or specific time
            $table->date('preferred_call_date')->nullable();
            $table->string('talk_to_us_name')->nullable();
            $table->string('talk_to_us_phone')->nullable();
            
            // Beneficiary (from coffee_wall_beneficiaries)
            $table->foreignId('beneficiary_id')->nullable()->constrained('coffee_wall_beneficiaries')->onUpdate('cascade')->onDelete('set null');
            
            // Payment Information
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'not_required'])->default('pending');
            $table->enum('payment_method', ['stripe', 'paypal'])->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->string('paypal_subscription_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            
            // Status & Visibility
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->boolean('is_visible')->default(false);
            
            // Link to Customer Account (for dashboard access)
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('set null');
            
            // Appointment Preferences (from old system)
            $table->enum('appointment', ['yes', 'no'])->nullable();
            $table->enum('time_to_call', ['am', 'pm'])->nullable();
            $table->date('appointment_date')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // For safe deletion
            
            // Indexes for performance
            $table->index('status');
            $table->index('payment_status');
            $table->index('customer_id');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponsors');
    }
};

