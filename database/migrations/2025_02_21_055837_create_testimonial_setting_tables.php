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
        // Create testimonial_setting table
        Schema::create('testimonial_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        // Create testimonial_setting_detail table
        Schema::create('testimonial_setting_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('testimonial_setting_id');
            $table->foreign('testimonial_setting_id', 'testimonial_setting_detail_testimonial_id_foreign')
                  ->references('id')->on('testimonial_setting')
                  ->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('required_fields_text', 500)->nullable();
            $table->text('name_label', 500)->nullable();
            $table->text('name_placeholder', 500)->nullable();
            $table->text('name_error', 500)->nullable();
            $table->text('company_name_label', 500)->nullable();
            $table->text('company_name_placeholder', 500)->nullable();
            $table->text('company_name_error', 500)->nullable();
            $table->text('business_categories_label', 500)->nullable();
            $table->text('business_categories_placeholder', 500)->nullable();
            $table->text('business_categories_error', 500)->nullable();
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
        // Drop testimonial_setting_detail table
        Schema::dropIfExists('testimonial_setting_detail');

        // Drop testimonial_setting table
        Schema::dropIfExists('testimonial_setting');
    }
};
