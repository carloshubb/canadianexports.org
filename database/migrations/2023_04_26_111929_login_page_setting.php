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
        Schema::create('login_page_setting', function(Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('login_page_setting_detail', function(Blueprint $table) {
            $table->id();
            $table->foreignId('login_page_setting_id')->nullable()->constrained('login_page_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('main_heading')->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('email_help', 500)->nullable();
            $table->text('password_label', 500)->nullable();
            $table->text('remeber_me_label', 500)->nullable();
            $table->text('forgot_password_text', 500)->nullable();
            $table->text('signin_btn_text', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("login_page_setting_detail");
        Schema::dropIfExists("login_page_setting");
    }
};
