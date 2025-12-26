<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberWebinarController extends Controller
{
    /**
     * Get all webinars hosted by the current member
     */
    public function index(Request $request)
    {
        $customerId = auth('customers')->id();
        
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $webinars = Webinar::where('host_user_id', $customerId)
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $webinars
        ]);
    }

    /**
     * Create a new webinar as a member
     */
    public function store(Request $request)
    {
        $customerId = auth('customers')->id();
        
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'presenter_name' => 'nullable|string|max:255',
            'presenter_bio' => 'nullable|string',
            'presenter_image' => 'nullable|string',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'meeting_link' => 'nullable|url',
            'meeting_platform' => 'nullable|string|in:zoom,teams,youtube,custom',
            'cover_image' => 'nullable|string',
            'max_attendees' => 'nullable|integer|min:1',
            'webinar_type' => 'required|in:live_interactive,live_viewonly,recorded',
            'allow_qa' => 'boolean',
            'allow_chat' => 'boolean',
            'allow_private_messages' => 'boolean',
            'keywords' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['host_user_id'] = $customerId;
        $validated['status'] = 'draft'; // Member webinars start as draft, need admin approval

        $webinar = Webinar::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Webinar created successfully. It will be published after admin approval.',
            'data' => $webinar
        ], 201);
    }

    /**
     * Get a specific webinar
     */
    public function show($id)
    {
        $customerId = auth('customers')->id();
        
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $webinar = Webinar::where('host_user_id', $customerId)
            ->with('registrations')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $webinar
        ]);
    }

    /**
     * Update a webinar
     */
    public function update(Request $request, $id)
    {
        $customerId = auth('customers')->id();
        
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $webinar = Webinar::where('host_user_id', $customerId)->findOrFail($id);

        // Don't allow editing if webinar has already happened
        if ($webinar->scheduled_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot edit a past webinar'
            ], 400);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'presenter_name' => 'nullable|string|max:255',
            'presenter_bio' => 'nullable|string',
            'presenter_image' => 'nullable|string',
            'scheduled_at' => 'sometimes|required|date|after:now',
            'duration_minutes' => 'sometimes|required|integer|min:15|max:480',
            'meeting_link' => 'nullable|url',
            'meeting_platform' => 'nullable|string|in:zoom,teams,youtube,custom',
            'cover_image' => 'nullable|string',
            'max_attendees' => 'nullable|integer|min:1',
            'webinar_type' => 'sometimes|in:live_interactive,live_viewonly,recorded',
            'allow_qa' => 'boolean',
            'allow_chat' => 'boolean',
            'allow_private_messages' => 'boolean',
            'recording_url' => 'nullable|url',
            'embed_code' => 'nullable|string',
            'keywords' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $webinar->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Webinar updated successfully',
            'data' => $webinar
        ]);
    }

    /**
     * Delete a webinar
     */
    public function destroy($id)
    {
        $customerId = auth('customers')->id();
        
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $webinar = Webinar::where('host_user_id', $customerId)->findOrFail($id);

        // Don't allow deleting if webinar has registrations
        if ($webinar->registrations()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete a webinar with registrations. Please cancel the webinar instead.'
            ], 400);
        }

        $webinar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Webinar deleted successfully'
        ]);
    }

    /**
     * Cancel a webinar
     */
    public function cancel($id)
    {
        $customerId = auth('customers')->id();
        
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $webinar = Webinar::where('host_user_id', $customerId)->findOrFail($id);

        $webinar->update(['status' => 'cancelled']);

        // TODO: Send cancellation emails to all registered attendees

        return response()->json([
            'success' => true,
            'message' => 'Webinar cancelled successfully'
        ]);
    }

    /**
     * Get registrations for a webinar
     */
    public function registrations($id)
    {
        $customerId = auth('customers')->id();
        
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $webinar = Webinar::where('host_user_id', $customerId)->findOrFail($id);

        $registrations = $webinar->registrations()
            ->orderBy('registered_at', 'desc')
            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $registrations
        ]);
    }

    /**
     * Get questions for a webinar (host can see all)
     */
    public function questions($id)
    {
        $customerId = auth('customers')->id();
        
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $webinar = Webinar::where('host_user_id', $customerId)->findOrFail($id);

        $questions = $webinar->questions()
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }
}

