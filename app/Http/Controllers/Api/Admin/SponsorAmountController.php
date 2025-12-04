<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorAmount;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SponsorAmountController extends Controller
{
    use StatusResponser;

    /**
     * Display a listing of sponsor amounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $amounts = SponsorAmount::orderBy('frequency')
                ->orderBy('sort_order')
                ->orderBy('amount')
                ->get();
            
            // Group by frequency for easier management
            $grouped = $amounts->groupBy('frequency');
            
            return response()->json([
                'status' => 'Success',
                'message' => 'Data retrieved successfully',
                'data' => $amounts,
                'grouped' => $grouped
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching sponsor amounts', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'Error',
                'message' => 'Error fetching sponsor amounts'
            ], 500);
        }
    }

    /**
     * Get available frequency options
     *
     * @return \Illuminate\Http\Response
     */
    public function getFrequencies()
    {
        return response()->json([
            'status' => 'Success',
            'message' => 'Frequencies retrieved successfully',
            'data' => SponsorAmount::$frequencies
        ]);
    }

    /**
     * Store a newly created sponsor amount.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'frequency' => 'required|in:one_time,monthly,quarterly,annually',
            'is_default' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $isDefault = $request->input('is_default', false);

            // If this is set as default, unset all other defaults for this frequency
            if ($isDefault) {
                SponsorAmount::where('frequency', $validated['frequency'])->update(['is_default' => false]);
            }

            $amount = SponsorAmount::create([
                'amount' => $validated['amount'],
                'frequency' => $validated['frequency'],
                'is_default' => $isDefault,
                'sort_order' => $validated['sort_order'] ?? 0,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'Success',
                'message' => 'Sponsor amount has been added successfully',
                'data' => $amount
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating sponsor amount', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'Error',
                'message' => 'Error creating sponsor amount: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified sponsor amount.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $amount = SponsorAmount::findOrFail($id);
            return response()->json([
                'status' => 'Success',
                'message' => 'Data retrieved successfully',
                'data' => $amount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Sponsor amount not found'
            ], 404);
        }
    }

    /**
     * Update the specified sponsor amount.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $amount = SponsorAmount::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'frequency' => 'required|in:one_time,monthly,quarterly,annually',
            'is_default' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $isDefault = $request->input('is_default', false);

            // If this is set as default, unset all other defaults for this frequency
            if ($isDefault) {
                SponsorAmount::where('frequency', $validated['frequency'])
                    ->where('id', '!=', $id)
                    ->update(['is_default' => false]);
            }

            $amount->update([
                'amount' => $validated['amount'],
                'frequency' => $validated['frequency'],
                'is_default' => $isDefault,
                'sort_order' => $validated['sort_order'] ?? $amount->sort_order,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'Success',
                'message' => 'Sponsor amount has been updated successfully',
                'data' => $amount
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating sponsor amount', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'Error',
                'message' => 'Error updating sponsor amount: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified sponsor amount.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $amount = SponsorAmount::findOrFail($id);
            $amount->delete();
            return response()->json([
                'status' => 'Success',
                'message' => 'Sponsor amount has been deleted successfully',
                'data' => $amount
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting sponsor amount', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'Error',
                'message' => 'Error deleting sponsor amount'
            ], 500);
        }
    }

    /**
     * Batch update sort order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function batchUpdate(Request $request)
    {
        $validated = $request->validate([
            'amounts' => 'required|array',
            'amounts.*.id' => 'required|exists:sponsor_amounts,id',
            'amounts.*.sort_order' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['amounts'] as $amountData) {
                SponsorAmount::where('id', $amountData['id'])->update([
                    'sort_order' => $amountData['sort_order'],
                ]);
            }

            DB::commit();

            $amounts = SponsorAmount::orderBy('sort_order')->orderBy('amount')->get();
            return response()->json([
                'status' => 'Success',
                'message' => 'Sort order updated successfully',
                'data' => $amounts
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error batch updating sponsor amounts', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'Error',
                'message' => 'Error updating sort order'
            ], 500);
        }
    }
}
