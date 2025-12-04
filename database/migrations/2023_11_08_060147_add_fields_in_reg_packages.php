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
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('discount_price');
            $table->dropColumn('discount_percentage');
            $table->dropColumn('free_subscription_days');
            $table->dropColumn('package_validity_days');
            $table->dropColumn('package_validity_months');
            $table->dropColumn('is_event_enable');
            $table->dropColumn('is_i2b_enable');
            $table->dropColumn('i2b_allowed');
            $table->dropColumn('stripe_price_id');
            $table->dropColumn('paypal_plan_id');
            $table->dropColumn('paypal_non_auto_plan_id');

            $table->float('monthly_price', 11, 2)->default(0)->after('package_type');
            $table->float('quarterly_price', 11, 2)->default(0)->after('monthly_price');
            $table->float('semi_annually_price', 11, 2)->default(0)->after('quarterly_price');
            $table->float('annually_price', 11, 2)->default(0)->after('semi_annually_price');

            $table->string('stripe_monthly_id')->nullable()->after('annually_price');
            $table->string('stripe_quarterly_id')->nullable()->after('stripe_monthly_id');
            $table->string('stripe_semi_annually_id')->nullable()->after('stripe_quarterly_id');
            $table->string('stripe_annually_id')->nullable()->after('stripe_semi_annually_id');

            $table->string('paypal_auto_renew_monthly_id')->nullable()->after('stripe_annually_id');
            $table->string('paypal_auto_renew_quarterly_id')->nullable()->after('paypal_auto_renew_monthly_id');
            $table->string('paypal_auto_renew_semi_annually_id')->nullable()->after('paypal_auto_renew_quarterly_id');
            $table->string('paypal_auto_renew_annually_id')->nullable()->after('paypal_auto_renew_semi_annually_id');

            $table->string('paypal_non_auto_renew_monthly_id')->nullable()->after('paypal_auto_renew_annually_id');
            $table->string('paypal_non_auto_renew_quarterly_id')->nullable()->after('paypal_non_auto_renew_monthly_id');
            $table->string('paypal_non_auto_renew_semi_annually_id')->nullable()->after('paypal_non_auto_renew_quarterly_id');
            $table->string('paypal_non_auto_renew_annually_id')->nullable()->after('paypal_non_auto_renew_semi_annually_id');
        });

        Schema::table('registration_package_detail', function (Blueprint $table) {
            $table->dropColumn('amount_pre_text');
            $table->dropColumn('amount_post_text');
            $table->text('short_description', 500)->nullable();
        });

        Schema::create('registration_package_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_package_id')->nullable()->constrained('registration_packages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->float('price', 11, 2)->default(0);
            $table->string('discount_price')->nullable()->after('price');
            $table->float('discount_percentage')->default(0)->after('price');
            $table->integer('free_subscription_days')->default(0);
            $table->float('package_validity_days')->default(0)->after('free_subscription_days');
            $table->string('package_validity_months')->nullable()->after('package_validity_days');
            $table->boolean('is_event_enable')->default(0)->after('sorting_order');
            $table->boolean('is_i2b_enable')->default(0)->after('events_allowed');
            $table->string('i2b_allowed')->nullable()->after('is_i2b_enable');
            $table->string('stripe_price_id')->nullable()->after('package_type');
            $table->string('paypal_plan_id')->nullable()->after('stripe_price_id');
            $table->string('paypal_non_auto_plan_id')->nullable()->after('paypal_plan_id');

            $table->dropColumn('monthly_price')->nullable()->after('package_type');
            $table->dropColumn('quarterly_price')->nullable()->after('monthly_price');
            $table->dropColumn('semi_annually_price')->nullable()->after('quarterly_price');
            $table->dropColumn('annually_price')->nullable()->after('semi_annually_price');

            $table->dropColumn('stripe_monthly_id')->nullable()->after('annually_price');
            $table->dropColumn('stripe_quarterly_id')->nullable()->after('stripe_monthly_id');
            $table->dropColumn('stripe_semi_annually_id')->nullable()->after('stripe_quarterly_id');
            $table->dropColumn('stripe_annually_id')->nullable()->after('stripe_semi_annually_id');

            $table->dropColumn('paypal_auto_renew_monthly_id')->nullable()->after('stripe_annually_id');
            $table->dropColumn('paypal_auto_renew_quarterly_id')->nullable()->after('paypal_auto_renew_monthly_id');
            $table->dropColumn('paypal_auto_renew_semi_annually_id')->nullable()->after('paypal_auto_renew_quarterly_id');
            $table->dropColumn('paypal_auto_renew_annually_id')->nullable()->after('paypal_auto_renew_semi_annually_id');

            $table->dropColumn('paypal_non_auto_renew_monthly_id')->nullable()->after('paypal_auto_renew_annually_id');
            $table->dropColumn('paypal_non_auto_renew_quarterly_id')->nullable()->after('paypal_non_auto_renew_monthly_id');
            $table->dropColumn('paypal_non_auto_renew_semi_annually_id')->nullable()->after('paypal_non_auto_renew_quarterly_id');
            $table->dropColumn('paypal_non_auto_renew_annually_id')->nullable()->after('paypal_non_auto_renew_semi_annually_id');
        });

        Schema::table('registration_package_detail', function (Blueprint $table) {
            $table->string('amount_pre_text')->nullable()->after('name');
            $table->string('amount_post_text')->nullable()->after('amount_pre_text');
            $table->dropColumn('short_description');
        });

        Schema::dropIfExists('registration_package_features');
    }
};
