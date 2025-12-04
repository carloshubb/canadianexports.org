<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BusinessProfileStatsResource;
use App\Models\BusinessProfileStats;
use App\Models\CustomerProfile;
use App\Models\Customer;
use App\Traits\StatusResponser;
use Illuminate\Support\Facades\DB;
use App\Mail\VisitorInfoMail;
use Illuminate\Support\Facades\Mail;
use App\Models\VisitorInfo;
use Illuminate\Http\Request;

class BusinessProfileStatsController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $businessProfileStats = BusinessProfileStats::with(['visitor', 'customerProfile:id,company_name']);

        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $businessProfileStats = $businessProfileStats->whereHas('visitor', function ($q) {
                $q->where('ip_address', 'like', '%' . $_GET['searchParam']);
                $q->orWhere('country', 'like', '%' . $_GET['searchParam']);
                $q->orWhere('state', 'like', '%' . $_GET['searchParam']);
                $q->orWhere('city', 'like', '%' . $_GET['searchParam']);
            });
            $businessProfileStats = $businessProfileStats->orWhereHas('customerProfile', function ($q) {
                $q->where('company_name', 'like', '%' . $_GET['searchParam']. '%');
            });
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'company_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $businessProfileStats = $businessProfileStats->addSelect(['company_name' => CustomerProfile::whereColumn('business_profile_stats.customer_profile_id', 'customer_profile.id')->select('company_name')->limit(1)]);

            $businessProfileStats = $businessProfileStats->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        $businessProfileStats = $businessProfileStats->paginate($limit);


        return $this->apiSuccessResponse(BusinessProfileStatsResource::collection($businessProfileStats), 'Data get successfully.');
    }

    public function show($customerProfileId)
    {
        $businessProfileStats = BusinessProfileStats::with(['visitor', 'customerProfile:id,company_name'])->whereCustomerProfileId($customerProfileId);

        // if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
        //     $businessProfileStats = $businessProfileStats->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('message', 'LIKE', '%' . $_GET['searchParam'] . '%');
        // }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $businessProfileStats = $businessProfileStats->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        $businessProfileStats = BusinessProfileStatsResource::collection($businessProfileStats->paginate($limit));

        $data['stats'] = $businessProfileStats;

        $data['stats_summary'] = BusinessProfileStats::whereCustomerProfileId($customerProfileId)->select('type', DB::raw('count(*) as total'))->groupBy('type')->pluck('total', 'type');


        return $this->successResponse($data, 'Data get successfully.');
    }
    public function sendEmails(Request $request)
{
    // Fetch the stats data from the request
    $stats = $request->input('stats');

    // Fetch the stats summary data (you need to pass this from the frontend or calculate it here)
    $statsSummary = [
        'overview' => $request->input('stats_summary.overview', 0),
        'contact' => $request->input('stats_summary.contact', 0),
        'send_message' => $request->input('stats_summary.send_message', 0),
        'media' => $request->input('stats_summary.media', 0),
        'cta_click' => $request->input('stats_summary.cta_click', 0),
    ];

    // Fetch the authenticated user
    $user = $request->user();

    // Fetch the customer profile associated with the stats
    $customerProfile = CustomerProfile::find($stats[0]['customer_profile_id']);

    if ($customerProfile && $customerProfile->company_email) {
        // Send the email to the company's email address
        Mail::to($customerProfile->company_email)->send(new VisitorInfoMail($stats, $statsSummary));

        return response()->json([
            'status' => 'Success',
            'message' => 'Email sent successfully to ' . $customerProfile->company_email,
        ]);
    } else {
        return response()->json([
            'status' => 'Error',
            'message' => 'Company email not found.',
        ], 404);
    }
}
}
