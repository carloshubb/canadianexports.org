<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use App\Models\WebinarMessage;
use App\Models\WebinarRegistration;
use Illuminate\Http\Request;

class WebinarMessageController extends Controller
{
    /**
     * Get conversation messages for an attendee
     */
    public function getConversation(Request $request, $webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        if (!$webinar->allow_private_messages) {
            return response()->json([
                'success' => false,
                'message' => 'Private messages are not enabled for this webinar'
            ], 400);
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        $registration = WebinarRegistration::where('webinar_id', $webinarId)
            ->where('email', $request->email)
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'You must be registered to view messages'
            ], 403);
        }

        $messages = WebinarMessage::where('webinar_id', $webinarId)
            ->where(function ($query) use ($registration) {
                $query->where('registration_id', $registration->id)
                    ->orWhere(function ($q) use ($registration) {
                        $q->where('sender_type', '!=', 'attendee')
                            ->whereHas('parent', function ($sq) use ($registration) {
                                $sq->where('registration_id', $registration->id);
                            });
                    });
            })
            ->where('status', 'active')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'sender_name' => $m->sender_name,
                    'sender_type' => $m->sender_type,
                    'message' => $m->message,
                    'is_read' => $m->is_read,
                    'created_at' => $m->created_at,
                ];
            });

        // Mark messages as read
        WebinarMessage::where('webinar_id', $webinarId)
            ->where('registration_id', $registration->id)
            ->where('sender_type', '!=', 'attendee')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Send a private message (attendee to presenter)
     */
    public function send(Request $request, $webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        if (!$webinar->allow_private_messages) {
            return response()->json([
                'success' => false,
                'message' => 'Private messages are not enabled for this webinar'
            ], 400);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $registration = WebinarRegistration::where('webinar_id', $webinarId)
            ->where('email', $validated['email'])
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'You must be registered to send messages'
            ], 403);
        }

        $message = WebinarMessage::create([
            'webinar_id' => $webinarId,
            'registration_id' => $registration->id,
            'sender_name' => $validated['name'],
            'sender_email' => $validated['email'],
            'sender_type' => 'attendee',
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent',
            'data' => [
                'id' => $message->id,
                'message' => $message->message,
                'created_at' => $message->created_at,
            ]
        ], 201);
    }

    /**
     * Delete own message (attendee)
     */
    public function deleteOwn(Request $request, $webinarId, $messageId)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $message = WebinarMessage::where('webinar_id', $webinarId)
            ->where('id', $messageId)
            ->where('sender_email', $request->email)
            ->where('sender_type', 'attendee')
            ->firstOrFail();

        $message->softDeleteByUser();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted'
        ]);
    }

    // ==================== ADMIN/PRESENTER METHODS ====================

    /**
     * Get all conversations for admin/presenter
     */
    public function adminIndex($webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        // Get unique conversations (grouped by registration)
        $conversations = WebinarMessage::where('webinar_id', $webinarId)
            ->where('sender_type', 'attendee')
            ->with(['registration:id,name,email'])
            ->select('registration_id')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->selectRaw('COUNT(*) as message_count')
            ->selectRaw('SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) as unread_count')
            ->groupBy('registration_id')
            ->orderByDesc('last_message_at')
            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $conversations
        ]);
    }

    /**
     * Get conversation with specific attendee (admin view)
     */
    public function adminConversation($webinarId, $registrationId)
    {
        $messages = WebinarMessage::where('webinar_id', $webinarId)
            ->where(function ($query) use ($registrationId) {
                $query->where('registration_id', $registrationId)
                    ->orWhere(function ($q) use ($registrationId) {
                        $q->where('sender_type', '!=', 'attendee')
                            ->whereHas('parent', function ($sq) use ($registrationId) {
                                $sq->where('registration_id', $registrationId);
                            });
                    });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark attendee messages as read
        WebinarMessage::where('webinar_id', $webinarId)
            ->where('registration_id', $registrationId)
            ->where('sender_type', 'attendee')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Reply to attendee (presenter/admin)
     */
    public function reply(Request $request, $webinarId, $registrationId)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $registration = WebinarRegistration::where('webinar_id', $webinarId)
            ->findOrFail($registrationId);

        // Find the last message from this attendee to use as parent
        $lastAttendeeMessage = WebinarMessage::where('webinar_id', $webinarId)
            ->where('registration_id', $registrationId)
            ->where('sender_type', 'attendee')
            ->orderBy('created_at', 'desc')
            ->first();

        $message = WebinarMessage::create([
            'webinar_id' => $webinarId,
            'registration_id' => $registrationId,
            'sender_name' => 'Presenter', // Or use auth user name
            'sender_email' => auth()->user()?->email ?? 'presenter@webinar.com',
            'sender_type' => 'presenter',
            'message' => $validated['message'],
            'parent_id' => $lastAttendeeMessage?->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reply sent',
            'data' => $message
        ], 201);
    }

    /**
     * Delete message (admin)
     */
    public function adminDelete($webinarId, $messageId)
    {
        $message = WebinarMessage::where('webinar_id', $webinarId)
            ->findOrFail($messageId);

        $message->softDeleteByAdmin(auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Message deleted by admin'
        ]);
    }

    /**
     * Get all messages for a webinar (admin - for oversight)
     */
    public function adminAllMessages($webinarId)
    {
        $messages = WebinarMessage::where('webinar_id', $webinarId)
            ->with(['registration:id,name,email'])
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }
}

