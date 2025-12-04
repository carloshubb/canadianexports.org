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
        Schema::create('customer_inquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('i2b_id')->nullable()->constrained('i2b')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('registration_package_id')->nullable()->constrained('registration_packages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->longText('inquiry_detail')->nullable();
            $table->enum('inquiry_status', ['complete', 'pending'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('customer_inquiry_id')->nullable()->after('customer_id')->constrained('customer_inquiries')->onUpdate('cascade')->onDelete('cascade');
        });

        \DB::statement("ALTER TABLE orders MODIFY type ENUM('profile','event','i2b')");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_inquiries');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('customer_inquiry_id');
            $table->dropColumn('customer_inquiry_id');
        });
        \DB::statement("ALTER TABLE orders MODIFY type ENUM('profile','event')");
    }
};
