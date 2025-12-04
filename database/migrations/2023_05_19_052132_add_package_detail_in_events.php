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
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('registration_package_id')->nullable()->after('press_url')->constrained('registration_packages')->onUpdate('cascade')->onDelete('cascade');
            $table->float('package_price', 11, 2)->default(0)->after('registration_package_id');
            $table->integer('free_subscription_days')->default(0)->after('package_price');
            $table->date('package_subscribed_date')->nullable()->after('free_subscription_days');
            $table->date('package_expiry_date')->nullable()->after('package_subscribed_date');
            $table->boolean('is_package_amount_paid')->default(0)->after('package_expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['registration_package_id']);
            $table->dropColumn('registration_package_id');
            $table->dropColumn('package_price');
            $table->dropColumn('free_subscription_days');
            $table->dropColumn('package_subscribed_date');
            $table->dropColumn('package_expiry_date');
            $table->dropColumn('is_package_amount_paid');
        });
    }
};
