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
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->text('intro_subtitle')->nullable()->after('footer_text');
            $table->text('privacy_section_heading')->nullable()->after('intro_subtitle');
            $table->text('privacy_bullet_1')->nullable()->after('privacy_section_heading');
            $table->text('privacy_bullet_2')->nullable()->after('privacy_bullet_1');
            $table->text('privacy_bullet_3')->nullable()->after('privacy_bullet_2');
            $table->text('details_disclaimers_heading')->nullable()->after('privacy_bullet_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn([
                'intro_subtitle',
                'privacy_section_heading',
                'privacy_bullet_1',
                'privacy_bullet_2',
                'privacy_bullet_3',
                'details_disclaimers_heading',
            ]);
        });
    }
};
