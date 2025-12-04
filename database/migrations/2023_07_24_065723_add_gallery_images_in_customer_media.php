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
        Schema::create('customer_gallery_images', function (Blueprint $table) {
            $table->foreignId('customer_media_id')->nullable()->constrained('customer_media')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('media_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->string('step_5_gallery_image_label')->nullable()->after('step_5_video_placeholder');
            $table->string('step_5_gallery_image_error')->nullable()->after('step_5_gallery_image_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_gallery_images');
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('step_5_gallery_image_label');
            $table->dropColumn('step_5_gallery_image_error');
        });
    }
};
