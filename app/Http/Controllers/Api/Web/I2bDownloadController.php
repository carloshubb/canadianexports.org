<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\CustomerInquiry;
use App\Models\I2b;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class I2bDownloadController extends Controller
{
    /**
     * Download I2B PDF file securely
     * 
     * @param Request $request
     * @param int $inquiryId
     * @param string $pdfNumber (pdf_1, pdf_2, or pdf_3)
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function download(Request $request, $inquiryId, $pdfNumber)
    {
        // Validate pdfNumber
        if (!in_array($pdfNumber, ['pdf_1', 'pdf_2', 'pdf_3'])) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid PDF number'
            ], 400);
        }

        // Get customer_id from signed URL parameters
        $customerId = $request->query('customer_id');
        if (!$customerId) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid download link'
            ], 400);
        }

        // Get the inquiry
        $inquiry = I2b::find($inquiryId);
        if (!$inquiry) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Inquiry not found'
            ], 404);
        }

        // Check if PDF exists for this inquiry
        $pdfPath = $inquiry->$pdfNumber;
        if (empty($pdfPath)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'PDF file not found for this inquiry'
            ], 404);
        }

        // Verify user has access to this inquiry (they must have requested it)
        $customerInquiry = CustomerInquiry::where('i2b_id', $inquiryId)
            ->where('customer_id', $customerId)
            ->first();

        if (!$customerInquiry) {
            return response()->json([
                'status' => 'Error',
                'message' => 'You do not have access to this inquiry'
            ], 403);
        }

        // Verify the customer exists and has Featured or Premium package
        $customer = \App\Models\Customer::with('registrationPackage')->find($customerId);
        if (!$customer) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid customer'
            ], 404);
        }

        $packageType = $customer->registrationPackage ? $customer->registrationPackage->package_type : null;
        if (!in_array($packageType, ['featured', 'premium'])) {
            return response()->json([
                'status' => 'Error',
                'message' => 'This feature is only available for Featured and Premium members'
            ], 403);
        }

        // Determine file path - check both old public path and new storage path
        $filePath = null;
        
        // First check if it's in the new storage location (storage/app/i2b-pdfs)
        if (Storage::disk('local')->exists('i2b-pdfs/' . basename($pdfPath))) {
            $filePath = storage_path('app/i2b-pdfs/' . basename($pdfPath));
        }
        // Fallback to old public path for backward compatibility
        elseif (file_exists(public_path($pdfPath))) {
            $filePath = public_path($pdfPath);
        }
        // Try direct path from database
        elseif (file_exists(storage_path('app/' . $pdfPath))) {
            $filePath = storage_path('app/' . $pdfPath);
        }

        if (!$filePath || !file_exists($filePath)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'PDF file not found on server'
            ], 404);
        }

        // Log the download
        \Log::info('I2B PDF downloaded', [
            'inquiry_id' => $inquiryId,
            'pdf_number' => $pdfNumber,
            'customer_id' => $customerId,
            'customer_email' => $customer->email,
            'timestamp' => now()
        ]);

        // Return file download
        return response()->download($filePath, basename($pdfPath), [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Generate signed download URL for email
     * 
     * @param int $inquiryId
     * @param string $pdfNumber
     * @param int $customerId
     * @return string
     */
    public static function generateDownloadUrl($inquiryId, $pdfNumber, $customerId)
    {
        // Create a signed URL that expires in 7 days
        $expires = Carbon::now()->addDays(7);
        
        return URL::temporarySignedRoute(
            'i2b.download',
            $expires,
            [
                'inquiryId' => $inquiryId,
                'pdfNumber' => $pdfNumber,
                'customer_id' => $customerId
            ]
        );
    }
}
