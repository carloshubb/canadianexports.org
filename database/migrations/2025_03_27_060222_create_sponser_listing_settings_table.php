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
            Schema::create('sponser_listing_setting', function (Blueprint $table) {
                $table->id();
                $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
            });

            Schema::create('sponser_listing_setting_detail', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sponser_list_setting_id')->nullable()->constrained('sponser_listing_setting')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
                $table->text('sponser_heading_text')->nullable();
                $table->text('no_sponser_found_text')->nullable();
                $table->text('user_has_sponser_text')->nullable();
                $table->text('add_sponser_btn_text')->nullable();
                $table->text('search_placeholder_text')->nullable();
                $table->text('show_text')->nullable();
                $table->text('sponser_text')->nullable();
                $table->text('title_text')->nullable();
                $table->text('action_text')->nullable();
                $table->text('edit_button_text')->nullable();
                $table->text('start_at_end_at_text')->nullable();
                $table->text('start_at_text')->nullable();
                $table->text('end_at_text')->nullable();
                $table->string('upgrade_profile_btn_text')->nullable();
            });
        }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponser_listing_setting_detail');

        Schema::dropIfExists('sponser_listing_setting');
    }
};
