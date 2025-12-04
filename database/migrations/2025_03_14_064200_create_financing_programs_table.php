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
        // Create the financing_programs table
        Schema::create('financing_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_category_id')->nullable()->constrained('business_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        // Create the financing_program_details table
        Schema::create('financing_program_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financing_program_id')->nullable()->constrained('financing_programs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name_title')->nullable(); // Name/Title
            $table->string('email')->nullable(); // Email
            $table->string('business_name')->nullable(); // Business Name
            $table->string('zipcode')->nullable(); // Zipcode
            $table->string('incorporation')->nullable(); // Incorporation
            $table->string('full_time_employees')->nullable(); // Full-Time Employees
            $table->string('revenue_last_year')->nullable(); // Revenue Last Year
            $table->string('company_ownership')->nullable(); // Company Ownership
            $table->text('needs_intentions')->nullable(); // Needs/Intentions
            $table->string('primary_industry')->nullable(); // Primary Industry
            $table->string('business_categories')->nullable(); // Business Categories
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
        // Drop the tables in reverse order
        Schema::dropIfExists('financing_program_details');
        Schema::dropIfExists('financing_programs');
    }
};
