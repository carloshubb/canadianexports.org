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
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('presenter_name')->nullable();
            $table->text('presenter_bio')->nullable();
            $table->string('presenter_image')->nullable();
            $table->dateTime('scheduled_at');
            $table->integer('duration_minutes')->default(60); // Duration in minutes
            $table->string('meeting_link')->nullable(); // Zoom/Teams/YouTube link
            $table->string('meeting_platform')->default('zoom'); // zoom, teams, youtube, custom
            $table->string('cover_image')->nullable();
            $table->integer('max_attendees')->nullable(); // null = unlimited
            $table->enum('status', ['draft', 'published', 'completed', 'cancelled'])->default('draft');
            $table->boolean('is_recorded')->default(false);
            $table->string('recording_url')->nullable();
            $table->json('keywords')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('webinar_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->enum('status', ['registered', 'attended', 'cancelled'])->default('registered');
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamp('attended_at')->nullable();
            $table->timestamps();
            
            $table->unique(['webinar_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webinar_registrations');
        Schema::dropIfExists('webinars');
    }
};