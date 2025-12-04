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
        Schema::create('success_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_category_id')->nullable()->constrained('business_categories')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('success_stories_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('success_stories_id')->nullable()->constrained('success_stories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('message', 500)->nullable();
            $table->string('company_name')->nullable();
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
        Schema::dropIfExists('success_story_details');
        Schema::dropIfExists('success_stories');
    }
};
