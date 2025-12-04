<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coffee_wallet_beneficiary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coffee_wallet_id')
                ->constrained('coffee_wallets')
                ->cascadeOnDelete();
            $table->foreignId('beneficiary_id')
                ->constrained('coffee_wall_beneficiaries')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['coffee_wallet_id', 'beneficiary_id'], 'coffee_wallet_beneficiary_unique');
        });

        if (Schema::hasColumn('coffee_wallets', 'beneficiary_id')) {
            DB::table('coffee_wallets')
                ->whereNotNull('beneficiary_id')
                ->orderBy('id')
                ->chunkById(200, function ($wallets) {
                    $rows = [];
                    $now = now();

                    foreach ($wallets as $wallet) {
                        $rows[] = [
                            'coffee_wallet_id' => $wallet->id,
                            'beneficiary_id' => $wallet->beneficiary_id,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }

                    if (!empty($rows)) {
                        DB::table('coffee_wallet_beneficiary')->insertOrIgnore($rows);
                    }
                });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coffee_wallet_beneficiary');
    }
};

