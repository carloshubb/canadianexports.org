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
            $table->foreignId('facebook_media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade')->after('slug');
            $table->foreignId('twitter_media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade')->after('facebook_media_id');
            $table->foreignId('linkedin_media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade')->after('twitter_media_id');
        });
        Schema::table('page_detail', function (Blueprint $table) {
            $table->string('meta_keywords')->nullable();
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
            $table->dropForeign('facebook_media_id');
            $table->dropForeign('twitter_media_id');
            $table->dropForeign('linkedin_media_id');
            $table->dropColumn('facebook_media_id');
            $table->dropColumn('twitter_media_id');
            $table->dropColumn('linkedin_media_id');
        });
        Schema::table('page_detail', function (Blueprint $table) {
            $table->dropColumn('meta_keywords');
        });
    }
};
