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
        Schema::create('advertiser_contact_form', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('email_sent_by')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('customer_profile_id')->nullable()->constrained('customer_profile')->onUpdate('cascade')->onDelete('cascade')->comment('email sent to');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('company_name')->nullable();
            $table->longText('message')->nullable();
            $table->timestamps();
        });
        Schema::table('info_letter', function (Blueprint $table) {
            $table->foreignId('email_sent_by')->nullable()->after('id')->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('contact_form', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('email_sent_by')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->longText('message')->nullable();
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
        Schema::dropIfExists('advertiser_contact_form');
        Schema::dropIfExists('contact_form');
        Schema::table('info_letter', function (Blueprint $table) {
            $table->dropForeign('email_sent_by');
            $table->dropColumn('email_sent_by');
        });
    }
};
