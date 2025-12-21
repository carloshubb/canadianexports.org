<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WebinarController extends Controller
{
    public function index(Request $request)
    {
        $query = Webinar::query();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('presenter_name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('scheduled_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('scheduled_at', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'scheduled_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 15);
        $webinars = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $webinars
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:webinars,slug',
            'description' => 'nullable|string',
            'presenter_name' => 'nullable|string|max:255',
            'presenter_bio' => 'nullable|string',
            'presenter_image' => 'nullable|string',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'meeting_link' => 'nullable|url',
            'meeting_platform' => 'nullable|string|in:zoom,teams,youtube,custom',
            'cover_image' => 'nullable|string',
            'max_attendees' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,completed,cancelled',
            'webinar_type' => 'required|in:live_interactive,live_viewonly,recorded',
            'allow_qa' => 'boolean',
            'allow_chat' => 'boolean',
            'allow_private_messages' => 'boolean',
            'is_recorded' => 'boolean',
            'recording_url' => 'nullable|url',
            'embed_code' => 'nullable|string',
            'keywords' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $webinar = Webinar::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Webinar created successfully',
            'data' => $webinar
        ], 201);
    }

    public function show($id)
    {
        $webinar = Webinar::with('registrations')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $webinar
        ]);
    }

    public function update(Request $request, $id)
    {
        $webinar = Webinar::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('webinars')->ignore($id)],
            'description' => 'nullable|string',
            'presenter_name' => 'nullable|string|max:255',
            'presenter_bio' => 'nullable|string',
            'presenter_image' => 'nullable|string',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'meeting_link' => 'nullable|url',
            'meeting_platform' => 'nullable|string|in:zoom,teams,youtube,custom',
            'cover_image' => 'nullable|string',
            'max_attendees' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,completed,cancelled',
            'webinar_type' => 'required|in:live_interactive,live_viewonly,recorded',
            'allow_qa' => 'boolean',
            'allow_chat' => 'boolean',
            'allow_private_messages' => 'boolean',
            'is_recorded' => 'boolean',
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

    public function destroy($id)
    {
        $webinar = Webinar::findOrFail($id);
        $webinar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Webinar deleted successfully'
        ]);
    }

    public function registrations($id)
    {
        $webinar = Webinar::findOrFail($id);
        $registrations = $webinar->registrations()
            ->orderBy('registered_at', 'desc')
            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $registrations
        ]);
    }
}