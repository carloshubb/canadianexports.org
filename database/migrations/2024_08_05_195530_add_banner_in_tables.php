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
        Schema::table('pages', function (Blueprint $table) {
            $table->foreignId('after_header_widget_id')->nullable()->constrained('widgets')->onUpdate('set null')->onDelete('set null')->after('slug');
            $table->foreignId('before_footer_widget_id')->nullable()->constrained('widgets')->onUpdate('set null')->onDelete('set null')->after('after_header_widget_id');
        });
        Schema::table('home_page_setting', function (Blueprint $table) {
            $table->foreignId('header_widget_id')->nullable()->constrained('widgets')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('business_category_widget_id')->nullable()->constrained('widgets')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('i2b_widget_id')->nullable()->constrained('widgets')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('sponsor_widget_id')->nullable()->constrained('widgets')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('business_widget_id')->nullable()->constrained('widgets')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('events_widget_id')->nullable()->constrained('widgets')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('magazine_widget_id')->nullable()->constrained('widgets')->onUpdate('set null')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign('after_header_widget_id');
            $table->dropForeign('before_footer_widget_id');
            $table->dropColumn('after_header_widget_id');
            $table->dropColumn('before_footer_widget_id');
        });
    }
};
