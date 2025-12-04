<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $customers = DB::table('customer_profile')->get();

        foreach ($customers as $customer) {
            if (is_null($customer->slug)) {
                // Initial slug based on company name
                $slug = Str::slug($customer->company_name);
                $originalSlug = $slug; // Store the original slug
                $count = 1;

                // Check if the slug already exists in the database
                while (DB::table('customer_profile')->where('slug', $slug)->exists()) {
                    // Append a number to the slug if it already exists
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }

                // Update the customer with the new unique slug
                DB::table('customer_profile')
                    ->where('id', $customer->id)
                    ->update(['slug' => $slug]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_profile', function (Blueprint $table) {
            //
        });
    }
};
