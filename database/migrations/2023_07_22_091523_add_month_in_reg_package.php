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
            $table->string('package_validity_months')->nullable()->after('package_validity_days');
            $table->string('discount_price')->nullable()->after('price');
            $table->string('images_allowed')->nullable()->after('package_validity_months');
        });
        Schema::table('registration_package_detail', function (Blueprint $table) {
            $table->string('amount_pre_text')->nullable()->after('name');
            $table->string('amount_post_text')->nullable()->after('amount_pre_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reg_package', function (Blueprint $table) {
            $table->dropColumn('package_validity_months');
        });
        Schema::table('registration_package_detail', function (Blueprint $table) {
            $table->dropColumn('amount_pre_text');
            $table->dropColumn('amount_post_text');
        });
    }
};
