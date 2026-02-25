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
        // Create webinar_setting table (page_id nullable for global/my-webinars use)
        Schema::create('webinar_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        // Create webinar_setting_detail table (per-language titles/labels)
        Schema::create('webinar_setting_detail', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('webinar_setting_id')
                ->constrained('webinar_setting')
                ->cascadeOnDelete();
        
            $table->foreignId('language_id')
                ->nullable()
                ->constrained('languages')
                ->cascadeOnDelete();
        
            // ======================
            // TEXT (messages / headings)
            // ======================
            $table->text('page_heading')->nullable();
            $table->text('no_webinars_message')->nullable();
            $table->text('fully_booked_message')->nullable();
            $table->text('registered_past_message')->nullable();
            $table->text('registered_upcoming_message')->nullable();
            $table->text('webinar_ended_message')->nullable();
            $table->text('no_questions_message')->nullable();
            $table->text('no_chat_message')->nullable();
            $table->text('private_message_intro')->nullable();
            $table->text('no_webinars_created_message')->nullable();
            $table->text('edit_webinar_heading')->nullable();
            $table->text('create_webinar_heading')->nullable();
            $table->text('description_label')->nullable();
            $table->text('presenter_bio_label')->nullable();
            $table->text('interaction_settings_heading')->nullable();
            $table->text('registrations_heading')->nullable();
            $table->text('no_registrations_message')->nullable();
            $table->text('qa_heading')->nullable();
            $table->text('no_questions_message_my')->nullable();
            $table->text('not_answered_message')->nullable();
            $table->text('delete_confirm_message')->nullable();
        
            // ======================
            // SHORT LABELS / BUTTONS
            // ======================
            $table->string('host_webinar_button', 100)->nullable();
            $table->string('past_badge', 50)->nullable();
            $table->string('upcoming_badge', 50)->nullable();
            $table->string('date_time_label', 100)->nullable();
            $table->string('duration_label', 100)->nullable();
            $table->string('seats_label', 100)->nullable();
            $table->string('unlimited_text', 100)->nullable();
            $table->string('remaining_text', 100)->nullable();
            $table->string('with_presenter_text', 100)->nullable();
        
            // Tabs
            $table->string('qa_tab', 50)->nullable();
            $table->string('chat_tab', 50)->nullable();
            $table->string('private_message_tab', 50)->nullable();
        
            // Q&A / Chat
            $table->string('ask_question_placeholder', 100)->nullable();
            $table->string('ask_anonymously', 100)->nullable();
            $table->string('submit_question_button', 100)->nullable();
            $table->string('sending_text', 100)->nullable();
            $table->string('answer_label', 100)->nullable();
            $table->string('type_message_placeholder', 100)->nullable();
            $table->string('send_button', 100)->nullable();
        
            // Private messages
            $table->string('you_label', 50)->nullable();
            $table->string('presenter_label', 50)->nullable();
            $table->string('private_message_placeholder', 100)->nullable();
            $table->string('send_private_message_button', 100)->nullable();
        
            // Registration
            $table->string('close_form_button', 100)->nullable();
            $table->string('register_button', 100)->nullable();
            $table->string('name_label', 100)->nullable();
            $table->string('email_label', 100)->nullable();
            $table->string('phone_label', 100)->nullable();
            $table->string('company_label', 100)->nullable();
            $table->string('submit_registration_button', 100)->nullable();
            $table->string('submitting_text', 100)->nullable();
        
            // Types
            $table->string('type_live_interactive', 100)->nullable();
            $table->string('type_live_viewonly', 100)->nullable();
            $table->string('type_recorded', 100)->nullable();
        
            // My webinars
            $table->string('my_webinars_heading', 100)->nullable();
            $table->string('host_webinar_button_my', 100)->nullable();
            $table->string('all_webinars_filter', 100)->nullable();
            $table->string('draft_filter', 100)->nullable();
            $table->string('published_filter', 100)->nullable();
            $table->string('completed_filter', 100)->nullable();
            $table->string('cancelled_filter', 100)->nullable();
            $table->string('loading_text', 100)->nullable();
            $table->string('create_first_webinar_button', 100)->nullable();
            $table->string('edit_button', 100)->nullable();
            $table->string('registrations_button', 100)->nullable();
            $table->string('qa_button', 100)->nullable();
            $table->string('delete_button', 100)->nullable();
        
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
        Schema::dropIfExists('webinar_setting_detail');
        Schema::dropIfExists('webinar_setting');
    }
};
