<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use App\Models\WebinarChatMessage;
use App\Models\WebinarRegistration;
use Illuminate\Http\Request;

class WebinarChatController extends Controller
{
    /**
     * Get recent chat messages
     */
    public function index($webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        if (!$webinar->allow_chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat is not enabled for this webinar'
            ], 400);
        }

        $messages = WebinarChatMessage::where('webinar_id', $webinarId)
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get()
            ->reverse()
            ->values()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'sender_name' => $m->sender_name,
                    'message' => $m->message,
                    'created_at' => $m->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Get new messages since a specific message ID (for polling)
     */
    public function getNew($webinarId, $lastMessageId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        if (!$webinar->allow_chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat is not enabled for this webinar'
            ], 400);
        }

        $messages = WebinarChatMessage::where('webinar_id', $webinarId)
            ->where('id', '>', $lastMessageId)
            ->active()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'sender_name' => $m->sender_name,
                    'message' => $m->message,
                    'created_at' => $m->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Send a chat message
     */
    public function send(Request $request, $webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        if (!$webinar->allow_chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat is not enabled for this webinar'
            ], 400);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:500',
        ]);

        // Verify registration
        $registration = WebinarRegistration::where('webinar_id', $webinarId)
            ->where('email', $validated['email'])
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'You must be registered to chat'
            ], 403);
        }

        $message = WebinarChatMessage::create([
            'webinar_id' => $webinarId,
            'registration_id' => $registration->id,
            'sender_name' => $validated['name'],
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $message->id,
                'sender_name' => $message->sender_name,
                'message' => $message->message,
                'created_at' => $message->created_at,
            ]
        ], 201);
    }

    // ==================== ADMIN METHODS ====================

    /**
     * Get all chat messages for admin
     */
    public function adminIndex($webinarId)
    {
        $messages = WebinarChatMessage::where('webinar_id', $webinarId)
            ->with(['registration:id,name,email'])
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Delete chat message (admin)
     */
    public function adminDelete($webinarId, $messageId)
    {
        $message = WebinarChatMessage::where('webinar_id', $webinarId)
            ->findOrFail($messageId);

        $message->deleteByAdmin(auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Chat message deleted'
        ]);
    }

    /**
     * Send message as presenter/admin
     */
    public function adminSend(Request $request, $webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        $validated = $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = WebinarChatMessage::create([
            'webinar_id' => $webinarId,
            'registration_id' => null,
            'sender_name' => 'Presenter', // Or auth user name
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $message->id,
                'sender_name' => $message->sender_name,
                'message' => $message->message,
                'created_at' => $message->created_at,
            ]
        ], 201);
    }
}

