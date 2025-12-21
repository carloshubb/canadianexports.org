<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use App\Models\WebinarRegistration;
use App\Mail\WebinarRegistrationConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class WebinarRegistrationController extends Controller
{
    public function register(Request $request, $webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        // Check if webinar is published
        if ($webinar->status !== 'published') {
            return response()->json([
                'success' => false,
                'message' => 'This webinar is not available for registration'
            ], 400);
        }

        // Check if webinar is full
        if ($webinar->isFull()) {
            return response()->json([
                'success' => false,
                'message' => 'This webinar is fully booked'
            ], 400);
        }

        // Check if already registered
        $existingRegistration = WebinarRegistration::where('webinar_id', $webinarId)
            ->where('email', $request->email)
            ->first();

        if ($existingRegistration) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this webinar'
            ], 400);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
        ]);

        $validated['webinar_id'] = $webinarId;
        $validated['status'] = 'registered';

        $registration = WebinarRegistration::create($validated);

        // Send confirmation email
        try {
            Mail::to($registration->email)->send(new WebinarRegistrationConfirmation($webinar, $registration));
        } catch (\Exception $e) {
            Log::error('Failed to send webinar registration email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully registered for the webinar. A confirmation email has been sent.',
            'data' => $registration
        ], 201);
    }

    public function cancel(Request $request, $webinarId)
    {
        $registration = WebinarRegistration::where('webinar_id', $webinarId)
            ->where('email', $request->email)
            ->firstOrFail();

        $registration->cancel();

        return response()->json([
            'success' => true,
            'message' => 'Registration cancelled successfully'
        ]);
    }

    public function checkRegistration(Request $request, $webinarId)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $registration = WebinarRegistration::where('webinar_id', $webinarId)
            ->where('email', $request->email)
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'is_registered' => !!$registration,
                'registration' => $registration
            ]
        ]);
    }

    // Admin methods for managing registrations
    public function markAttended($id)
    {
        $registration = WebinarRegistration::findOrFail($id);
        $registration->markAsAttended();
        
        return response()->json([
            'success' => true,
            'message' => 'Marked as attended'
        ]);
    }

    public function cancelAdmin($id)
    {
        $registration = WebinarRegistration::findOrFail($id);
        $registration->cancel();
        
        return response()->json([
            'success' => true,
            'message' => 'Registration cancelled'
        ]);
    }
}
