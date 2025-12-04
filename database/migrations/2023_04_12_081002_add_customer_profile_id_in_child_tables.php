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
        Schema::table('customer_business_categories', function (Blueprint $table) {
            $table->foreignId('customer_profile_id')->nullable()->constrained('customer_profile')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('customer_media', function (Blueprint $table) {
            $table->foreignId('customer_profile_id')->nullable()->constrained('customer_profile')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('customer_social_media', function (Blueprint $table) {
            $table->foreignId('customer_profile_id')->nullable()->constrained('customer_profile')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('customer_profile', function (Blueprint $table) {
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
        Schema::table('customer_business_categories', function (Blueprint $table) {
            $table->dropForeign(['customer_profile_id']);
            $table->dropColumn('customer_profile_id');
        });
        Schema::table('customer_media', function (Blueprint $table) {
            $table->dropForeign(['customer_profile_id']);
            $table->dropColumn('customer_profile_id');
        });
        Schema::table('customer_social_media', function (Blueprint $table) {
            $table->dropForeign(['customer_profile_id']);
            $table->dropColumn('customer_profile_id');
        });
    }
};
