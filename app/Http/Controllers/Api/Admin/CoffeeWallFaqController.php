<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoffeeWallFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoffeeWallFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CoffeeWallFaq::query();

        // Filter by type if provided
        if ($request->has('type') && in_array($request->type, ['donor', 'beneficiary'])) {
            $query->where('type', $request->type);
        }

        // Order by sort_order
        $faqs = $query->orderBy('sort_order', 'asc')
                      ->orderBy('created_at', 'desc')
                      ->get();

        return response()->json([
            'status' => 'Success',
            'data' => $faqs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:donor,beneficiary',
            'question' => 'required|string',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $faq = CoffeeWallFaq::create([
            'type' => $request->type,
            'question' => $request->question,
            'answer' => $request->answer,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->is_active ?? true
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'FAQ created successfully',
            'data' => $faq
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $faq = CoffeeWallFaq::find($id);

        if (!$faq) {
            return response()->json([
                'status' => 'Error',
                'message' => 'FAQ not found'
            ], 404);
        }

        return response()->json([
            'status' => 'Success',
            'data' => $faq
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $faq = CoffeeWallFaq::find($id);

        if (!$faq) {
            return response()->json([
                'status' => 'Error',
                'message' => 'FAQ not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'nullable|in:donor,beneficiary',
            'question' => 'nullable|string',
            'answer' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $faq->update($request->only([
            'type',
            'question',
            'answer',
            'sort_order',
            'is_active'
        ]));

        return response()->json([
            'status' => 'Success',
            'message' => 'FAQ updated successfully',
            'data' => $faq
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $faq = CoffeeWallFaq::find($id);

        if (!$faq) {
            return response()->json([
                'status' => 'Error',
                'message' => 'FAQ not found'
            ], 404);
        }

        $faq->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'FAQ deleted successfully'
        ]);
    }
}

