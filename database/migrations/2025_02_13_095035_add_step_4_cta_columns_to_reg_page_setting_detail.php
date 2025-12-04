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
            $table->text('step_4_cta_link_label', 500)->nullable()->after('step_4_keywords_placeholder');
            $table->text('step_4_cta_link_placeholder', 500)->nullable()->after('step_4_cta_link_label');
            $table->text('step_4_cta_btn_label', 500)->nullable()->after('step_4_cta_link_placeholder');
            $table->text('step_4_cta_btn_placeholder', 500)->nullable()->after('step_4_cta_btn_label');
            $table->text('step_4_cta_btn_error', 500)->nullable()->after('step_4_website_label');
            $table->text('step_4_cta_link_error', 500)->nullable()->after('step_4_website_label');

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
                'step_4_cta_link_label',
                'step_4_cta_link_placeholder',
                'step_4_cta_btn_label',
                'step_4_cta_btn_placeholder',
                'step_4_cta_link_error',
                'step_4_cta_btn_error',
            ]);
        });
    }
};
