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
        // Add webinar_type to webinars table
        Schema::table('webinars', function (Blueprint $table) {
            $table->enum('webinar_type', ['live_interactive', 'live_viewonly', 'recorded'])
                ->default('live_interactive')
                ->after('status');
            $table->boolean('allow_qa')->default(true)->after('webinar_type');
            $table->boolean('allow_chat')->default(true)->after('allow_qa');
            $table->boolean('allow_private_messages')->default(true)->after('allow_chat');
            $table->foreignId('host_user_id')->nullable()->after('id'); // null = admin, otherwise member
            $table->string('embed_code')->nullable()->after('recording_url'); // For embedded videos
        });

        // Q&A Questions table
        Schema::create('webinar_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_id')->nullable()->constrained('webinar_registrations')->onDelete('cascade');
            $table->string('asker_name');
            $table->string('asker_email');
            $table->text('question');
            $table->text('answer')->nullable();
            $table->foreignId('answered_by')->nullable(); // Admin/presenter user ID
            $table->timestamp('answered_at')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_public')->default(true); // Show to all attendees or just presenter
            $table->boolean('is_answered')->default(false);
            $table->boolean('is_featured')->default(false); // Highlighted by presenter
            $table->integer('upvotes')->default(0);
            $table->enum('status', ['pending', 'approved', 'answered', 'rejected', 'deleted'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['webinar_id', 'status']);
            $table->index(['webinar_id', 'is_answered']);
        });

        // Private Messages table (Attendee <-> Presenter)
        Schema::create('webinar_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_id')->nullable()->constrained('webinar_registrations')->onDelete('cascade');
            $table->string('sender_name');
            $table->string('sender_email');
            $table->enum('sender_type', ['attendee', 'presenter', 'admin'])->default('attendee');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->foreignId('parent_id')->nullable(); // For threading/replies
            $table->enum('status', ['active', 'deleted_by_user', 'deleted_by_admin'])->default('active');
            $table->foreignId('deleted_by')->nullable(); // Who deleted it
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->index(['webinar_id', 'registration_id']);
            $table->index(['webinar_id', 'sender_type']);
            $table->index(['webinar_id', 'status']);
        });

        // Chat Room Messages (Public chat during live webinars)
        Schema::create('webinar_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_id')->nullable()->constrained('webinar_registrations')->onDelete('cascade');
            $table->string('sender_name');
            $table->text('message');
            $table->enum('status', ['active', 'deleted_by_admin'])->default('active');
            $table->foreignId('deleted_by')->nullable();
            $table->timestamps();

            $table->index(['webinar_id', 'created_at']);
            $table->index(['webinar_id', 'status']);
        });

        // Question upvotes tracking (prevent duplicate votes)
        Schema::create('webinar_question_upvotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('webinar_questions')->onDelete('cascade');
            $table->foreignId('registration_id')->constrained('webinar_registrations')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['question_id', 'registration_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webinar_question_upvotes');
        Schema::dropIfExists('webinar_chat_messages');
        Schema::dropIfExists('webinar_messages');
        Schema::dropIfExists('webinar_questions');

        Schema::table('webinars', function (Blueprint $table) {
            $table->dropColumn([
                'webinar_type',
                'allow_qa',
                'allow_chat',
                'allow_private_messages',
                'host_user_id',
                'embed_code',
            ]);
        });
    }
};

