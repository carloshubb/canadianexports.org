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
        Schema::table('i2b', function (Blueprint $table) {
            $table->foreignId('business_category_id_2')->nullable()->constrained('business_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('business_category_id_3')->nullable()->constrained('business_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('pdf_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('i2b', function (Blueprint $table) {
            $table->dropForeign('business_category_id_2');
            $table->dropColumn('business_category_id_2');
            $table->dropForeign('business_category_id_3');
            $table->dropColumn('business_category_id_3');
            $table->dropColumn('pdf_3');
        });
    }
};
