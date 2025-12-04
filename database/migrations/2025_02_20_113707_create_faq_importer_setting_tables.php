<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create faq_importer_setting table
        Schema::create('faq_importer_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        // Create faq_importer_setting_detail table
        Schema::create('faq_importer_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faq_importer_setting_id');
            $table->foreign('faq_importer_setting_id', 'faq_importer_setting_detail_faq_importer_id_foreign')
                  ->references('id')->on('faq_importer_setting')
                  ->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('required_fields_text', 500)->nullable();
            $table->text('name_label', 500)->nullable();
            $table->text('name_placeholder', 500)->nullable();
            $table->text('name_error', 500)->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('email_placeholder', 500)->nullable();
            $table->text('email_error', 500)->nullable();
            $table->text('message_label', 500)->nullable();
            $table->text('message_placeholder', 500)->nullable();
            $table->text('message_error', 500)->nullable();
            $table->text('button_text', 500)->nullable();
            $table->string('page_heading')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop faq_importer_setting_detail table
        Schema::dropIfExists('faq_importer_setting_detail');

        // Drop faq_importer_setting table
        Schema::dropIfExists('faq_importer_setting');
    }
};
