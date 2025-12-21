<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use App\Models\WebinarQuestion;
use App\Models\WebinarRegistration;
use App\Mail\WebinarQuestionAnswered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class WebinarQuestionController extends Controller
{
    /**
     * Get all approved questions for a webinar (public view)
     */
    public function index($webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        if (!$webinar->allow_qa) {
            return response()->json([
                'success' => false,
                'message' => 'Q&A is not enabled for this webinar'
            ], 400);
        }

        $questions = $webinar->approvedQuestions()
            ->with(['registration:id,name'])
            ->get()
            ->map(function ($q) {
                return [
                    'id' => $q->id,
                    'question' => $q->question,
                    'asker_name' => $q->display_name,
                    'answer' => $q->answer,
                    'is_answered' => $q->is_answered,
                    'is_featured' => $q->is_featured,
                    'upvotes' => $q->upvotes,
                    'answered_at' => $q->answered_at,
                    'created_at' => $q->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }

    /**
     * Submit a new question
     */
    public function store(Request $request, $webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        if (!$webinar->allow_qa) {
            return response()->json([
                'success' => false,
                'message' => 'Q&A is not enabled for this webinar'
            ], 400);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'question' => 'required|string|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        // Check if user is registered
        $registration = WebinarRegistration::where('webinar_id', $webinarId)
            ->where('email', $validated['email'])
            ->first();

        $question = WebinarQuestion::create([
            'webinar_id' => $webinarId,
            'registration_id' => $registration?->id,
            'asker_name' => $validated['name'],
            'asker_email' => $validated['email'],
            'question' => $validated['question'],
            'is_anonymous' => $validated['is_anonymous'] ?? false,
            'is_public' => true,
            'status' => 'pending', // Requires approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your question has been submitted and is pending approval',
            'data' => [
                'id' => $question->id,
                'question' => $question->question,
                'status' => $question->status,
            ]
        ], 201);
    }

    /**
     * Upvote a question
     */
    public function upvote(Request $request, $webinarId, $questionId)
    {
        $question = WebinarQuestion::where('webinar_id', $webinarId)
            ->findOrFail($questionId);

        $request->validate([
            'email' => 'required|email',
        ]);

        $registration = WebinarRegistration::where('webinar_id', $webinarId)
            ->where('email', $request->email)
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'You must be registered to upvote questions'
            ], 403);
        }

        $upvoted = $question->upvote($registration);

        return response()->json([
            'success' => true,
            'message' => $upvoted ? 'Question upvoted' : 'Already upvoted',
            'data' => [
                'upvotes' => $question->fresh()->upvotes
            ]
        ]);
    }

    /**
     * Remove upvote from a question
     */
    public function removeUpvote(Request $request, $webinarId, $questionId)
    {
        $question = WebinarQuestion::where('webinar_id', $webinarId)
            ->findOrFail($questionId);

        $request->validate([
            'email' => 'required|email',
        ]);

        $registration = WebinarRegistration::where('webinar_id', $webinarId)
            ->where('email', $request->email)
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'You must be registered'
            ], 403);
        }

        $removed = $question->removeUpvote($registration);

        return response()->json([
            'success' => true,
            'message' => $removed ? 'Upvote removed' : 'Not upvoted',
            'data' => [
                'upvotes' => $question->fresh()->upvotes
            ]
        ]);
    }

    /**
     * Get user's own questions for a webinar
     */
    public function myQuestions(Request $request, $webinarId)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $questions = WebinarQuestion::where('webinar_id', $webinarId)
            ->where('asker_email', $request->email)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($q) {
                return [
                    'id' => $q->id,
                    'question' => $q->question,
                    'answer' => $q->answer,
                    'is_answered' => $q->is_answered,
                    'status' => $q->status,
                    'upvotes' => $q->upvotes,
                    'created_at' => $q->created_at,
                    'answered_at' => $q->answered_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }

    // ==================== ADMIN METHODS ====================

    /**
     * Get all questions for admin (including pending)
     */
    public function adminIndex($webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        $questions = $webinar->questions()
            ->with(['registration:id,name,email'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }

    /**
     * Approve a question
     */
    public function approve($questionId)
    {
        $question = WebinarQuestion::findOrFail($questionId);
        $question->approve();

        return response()->json([
            'success' => true,
            'message' => 'Question approved'
        ]);
    }

    /**
     * Reject a question
     */
    public function reject($questionId)
    {
        $question = WebinarQuestion::findOrFail($questionId);
        $question->reject();

        return response()->json([
            'success' => true,
            'message' => 'Question rejected'
        ]);
    }

    /**
     * Answer a question
     */
    public function answer(Request $request, $questionId)
    {
        $request->validate([
            'answer' => 'required|string|max:2000',
        ]);

        $question = WebinarQuestion::findOrFail($questionId);
        $question->markAsAnswered(
            $request->answer,
            auth()->id()
        );

        // Send email notification to the question asker
        $this->sendQuestionAnsweredEmail($question);

        return response()->json([
            'success' => true,
            'message' => 'Question answered'
        ]);
    }

    /**
     * Mark question as answered (without written answer - answered live)
     */
    public function markAnswered($questionId)
    {
        $question = WebinarQuestion::findOrFail($questionId);
        $question->markAsAnswered(null, auth()->id());

        // Send email notification
        $this->sendQuestionAnsweredEmail($question);

        return response()->json([
            'success' => true,
            'message' => 'Question marked as answered'
        ]);
    }

    /**
     * Send email notification when question is answered
     */
    private function sendQuestionAnsweredEmail(WebinarQuestion $question)
    {
        try {
            $webinar = $question->webinar;
            Mail::to($question->asker_email)->send(new WebinarQuestionAnswered($webinar, $question));
        } catch (\Exception $e) {
            Log::error('Failed to send question answered email: ' . $e->getMessage());
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($questionId)
    {
        $question = WebinarQuestion::findOrFail($questionId);
        $question->toggleFeatured();

        return response()->json([
            'success' => true,
            'message' => $question->is_featured ? 'Question featured' : 'Question unfeatured',
            'data' => ['is_featured' => $question->is_featured]
        ]);
    }

    /**
     * Delete a question (admin)
     */
    public function destroy($questionId)
    {
        $question = WebinarQuestion::findOrFail($questionId);
        $question->update(['status' => 'deleted']);
        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question deleted'
        ]);
    }
}

