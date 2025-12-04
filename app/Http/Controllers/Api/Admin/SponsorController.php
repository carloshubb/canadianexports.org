<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SponsorResource;
use App\Models\Sponsor;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SponsorController extends Controller
{
    use StatusResponser;

    /**
     * Display a listing of sponsors
     */
    public function index(Request $request)
    {
        try {
            $query = Sponsor::query();

            // Include relationships
            $query = $this->loadRelations($query);

            // Apply filters
            $query = $this->applyFilters($query, $request);

            // Apply search
            $query = $this->applySearch($query, $request);

            // Apply sorting and pagination
            $sponsors = $this->sortingAndLimit($query, $request);

            return $this->apiSuccessResponse(SponsorResource::collection($sponsors), 'Sponsors retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error fetching sponsors', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse('Error fetching sponsors');
        }
    }

    /**
     * Display the specified sponsor
     */
    public function show($id)
    {
        try {
            $sponsor = Sponsor::with(['logoMedia', 'featuredMedia', 'beneficiary', 'customer'])
                ->findOrFail($id);

            return $this->apiSuccessResponse(new SponsorResource($sponsor), 'Sponsor retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error fetching sponsor', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return $this->errorResponse('Sponsor not found', 404);
        }
    }

    /**
     * Update sponsor status (admin only)
     */
    public function update(Request $request, $id)
    {
        try {
            $sponsor = Sponsor::findOrFail($id);

            $validated = $request->validate([
                'status' => 'sometimes|in:active,inactive,pending',
                'is_visible' => 'sometimes|boolean',
            ]);

            $sponsor->update($validated);

            return $this->apiSuccessResponse(
                new SponsorResource($sponsor->load(['logoMedia', 'featuredMedia', 'beneficiary', 'customer'])),
                'Sponsor status updated successfully'
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse('Validation error', 422);
        } catch (\Exception $e) {
            Log::error('Error updating sponsor', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return $this->errorResponse('Error updating sponsor');
        }
    }

    /**
     * Remove the specified sponsor (soft delete)
     */
    public function destroy($id)
    {
        try {
            $sponsor = Sponsor::findOrFail($id);
            $sponsor->delete(); // Soft delete

            return $this->apiSuccessResponse(null, 'Sponsor deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting sponsor', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return $this->errorResponse('Error deleting sponsor');
        }
    }

    /**
     * Load necessary relationships
     */
    protected function loadRelations($query)
    {
        if (request()->has('withMedia') && request('withMedia') == '1') {
            $query->with(['logoMedia', 'featuredMedia']);
        }

        if (request()->has('withBeneficiary') && request('withBeneficiary') == '1') {
            $query->with(['beneficiaries', 'beneficiary']);
        }

        if (request()->has('withCustomer') && request('withCustomer') == '1') {
            $query->with('customer');
        }

        return $query;
    }

    /**
     * Apply filters to query
     */
    protected function applyFilters($query, $request)
    {
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by sponsorship type
        if ($request->has('sponsorship_type') && $request->sponsorship_type != '') {
            $query->where('sponsorship_type', $request->sponsorship_type);
        }

        // Filter by beneficiary
        if ($request->has('beneficiary_id') && $request->beneficiary_id != '') {
            $query->where(function ($beneficiaryQuery) use ($request) {
                $beneficiaryQuery->where('beneficiary_id', $request->beneficiary_id)
                    ->orWhereHas('beneficiaries', function ($relationQuery) use ($request) {
                        $relationQuery->where('coffee_wall_beneficiaries.id', $request->beneficiary_id);
                    });
            });
        }

        // Filter by visibility
        if ($request->has('is_visible') && $request->is_visible != '') {
            $query->where('is_visible', $request->is_visible);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }

    /**
     * Apply search to query
     */
    protected function applySearch($query, $request)
    {
        if ($request->has('searchParam') && $request->searchParam != '') {
            $search = $request->searchParam;
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%')
                  ->orWhere('contact_name', 'LIKE', '%' . $search . '%');
            });
        }

        return $query;
    }

    /**
     * Apply sorting and pagination
     */
    protected function sortingAndLimit($query, $request)
    {
        // Get all (no pagination) if requested
        if ($request->has('getAll') && $request->getAll == '1') {
            return $query->latest()->get();
        }

        // Sorting
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'business_name', 'email', 'status', 'payment_status', 'sponsorship_amount', 'created_at'];

        if ($request->has('sortBy') && $request->sortBy != '' && 
            $request->has('sortType') && $request->sortType != '' &&
            in_array($request->sortBy, $sortBy) && in_array($request->sortType, $sortType)) {
            $query->orderBy($request->sortBy, $request->sortType);
        } else {
            $query->latest(); // Default: newest first
        }

        // Pagination
        $limit = $request->has('limit') && $request->limit != '' ? $request->limit : 15;

        return $query->paginate($limit);
    }
}

