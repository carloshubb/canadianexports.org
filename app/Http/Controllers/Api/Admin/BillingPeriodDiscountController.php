<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingPeriodDiscount;
use App\Services\BillingDiscountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillingPeriodDiscountController extends Controller
{
    /**
     * Display a listing of the billing period discounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = BillingPeriodDiscount::orderBy('months', 'asc')->get();
        
        return response()->json([
            'data' => $discounts,
            'status' => 'Success'
        ]);
    }

    /**
     * Update the specified billing period discount.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'Error'
            ], 422);
        }

        $discount = BillingPeriodDiscount::findOrFail($id);
        
        $discount->discount_percentage = $request->discount_percentage;
        $discount->updateMultiplier();
        $discount->save();

        // Clear cache
        BillingDiscountService::clearCache();

        return response()->json([
            'data' => $discount,
            'status' => 'Success',
            'message' => 'Discount updated successfully'
        ]);
    }

    /**
     * Batch update multiple discounts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function batchUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discounts' => 'required|array',
            'discounts.*.id' => 'required|exists:billing_period_discounts,id',
            'discounts.*.discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'Error'
            ], 422);
        }

        $updatedDiscounts = [];

        foreach ($request->discounts as $discountData) {
            $discount = BillingPeriodDiscount::find($discountData['id']);
            if ($discount) {
                $discount->discount_percentage = $discountData['discount_percentage'];
                $discount->updateMultiplier();
                $discount->save();
                $updatedDiscounts[] = $discount;
            }
        }

        // Clear cache
        BillingDiscountService::clearCache();

        return response()->json([
            'data' => $updatedDiscounts,
            'status' => 'Success',
            'message' => 'Discounts updated successfully'
        ]);
    }
}
