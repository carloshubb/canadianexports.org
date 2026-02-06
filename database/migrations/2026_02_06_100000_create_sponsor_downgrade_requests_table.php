<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sponsor_downgrade_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->decimal('current_amount', 10, 2);
            $table->string('current_frequency', 20);
            $table->decimal('requested_amount', 10, 2);
            $table->string('requested_frequency', 20);
            $table->date('current_period_end')->nullable();
            $table->timestamp('requested_at');
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();

            $table->index(['sponsor_id', 'applied_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_downgrade_requests');
    }
};
