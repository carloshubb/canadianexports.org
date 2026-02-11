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
        Schema::table('event_signup_setting_detail', function (Blueprint $table) {
            $table->text('main_event_image_label', 500)->nullable()->after('contact_photo_tooltip');
            $table->text('main_event_image_hint', 500)->nullable()->after('main_event_image_label');
            $table->text('photo_gallery_heading', 500)->nullable()->after('main_event_image_hint');
            $table->text('photo_gallery_label', 500)->nullable()->after('photo_gallery_heading');
            $table->text('photo_gallery_subtitle_featured', 500)->nullable()->after('photo_gallery_label');
            $table->text('photo_gallery_subtitle_premium', 500)->nullable()->after('photo_gallery_subtitle_featured');
            $table->text('update_btn_text', 500)->nullable()->after('photo_gallery_subtitle_premium');
            $table->text('privacy_heading', 500)->nullable()->after('update_btn_text');
            $table->text('privacy_bullet_1', 500)->nullable()->after('privacy_heading');
            $table->text('privacy_bullet_2', 500)->nullable()->after('privacy_bullet_1');
            $table->text('privacy_bullet_3', 500)->nullable()->after('privacy_bullet_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_signup_setting_detail', function (Blueprint $table) {
            $table->dropColumn([
                'main_event_image_label',
                'main_event_image_hint',
                'photo_gallery_heading',
                'photo_gallery_label',
                'photo_gallery_subtitle_featured',
                'photo_gallery_subtitle_premium',
                'update_btn_text',
                'privacy_heading',
                'privacy_bullet_1',
                'privacy_bullet_2',
                'privacy_bullet_3',
            ]);
        });
    }
};
