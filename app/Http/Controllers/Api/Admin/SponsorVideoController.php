<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorVideo;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SponsorVideoController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        $videos = SponsorVideo::with(['customer', 'sponsor'])
            ->orderByDesc('created_at')
            ->paginate($request->integer('per_page', 20));
        return $this->successResponse($videos);
    }

    public function show(SponsorVideo $sponsorVideo)
    {
        $sponsorVideo->load(['customer', 'sponsor']);
        return $this->successResponseArray($sponsorVideo);
    }

    public function update(Request $request, SponsorVideo $sponsorVideo)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);
        $sponsorVideo->update($data);
        return $this->successResponseArray($sponsorVideo->fresh(['customer', 'sponsor']), 'Video updated');
    }
}
