<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('sponsor_beneficiary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('beneficiary_id')->constrained('coffee_wall_beneficiaries')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['sponsor_id', 'beneficiary_id']);
        });

        // Backfill existing sponsor beneficiary relationships
        $existing = DB::table('sponsors')
            ->whereNotNull('beneficiary_id')
            ->select('id', 'beneficiary_id')
            ->get();

        if ($existing->isNotEmpty()) {
            $now = now();
            $rows = $existing->map(function ($record) use ($now) {
                return [
                    'sponsor_id' => $record->id,
                    'beneficiary_id' => $record->beneficiary_id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->all();

            DB::table('sponsor_beneficiary')->insert($rows);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponsor_beneficiary');
    }
};


