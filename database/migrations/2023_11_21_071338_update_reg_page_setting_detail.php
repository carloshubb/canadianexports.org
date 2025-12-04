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
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('profile_image_id')->nullable()->constrained('media')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->text('step_2_profile_image_label', 500)->nullable()->after('step_2_confirm_password_placeholder');
            $table->text('step_2_profile_image_placeholder', 500)->nullable()->after('step_2_profile_image_label');
            $table->text('step_2_profile_image_error', 500)->nullable()->after('step_2_profile_image_placeholder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('profile_image_id');
            $table->dropColumn('profile_image_id');
        });
        Schema::table('reg_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('step_2_profile_image_label');
            $table->dropColumn('step_2_profile_image_placeholder');
            $table->dropColumn('step_2_profile_image_error');
        });
    }
};
