<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\I2b;
use App\Models\Order;
use App\Traits\StatusResponser;

class DashboardController extends Controller
{
    use StatusResponser;

    // public function show()
    // {
    //     $data['business_profiles'] = CustomerProfile::whereHas('customer', function ($q) {
    //         $q->where('is_active', 1)->where('is_package_amount_paid', 1)->where('package_expiry_date', '>=', date('Y-m-d'))->where('type', 'customer');
    //     })->DISTINCT('customer_id')->count();

    //     $data['featured_exporters'] = CustomerProfile::whereHas('customer', function ($q) {
    //         $q->where('is_active', 1)->where('is_package_amount_paid', 1)->where('package_expiry_date', '>=', date('Y-m-d'))->where('type', 'customer');
    //     })->whereHas('customer.registrationPackage', function ($q) {
    //         $q->where('registration_packages.package_type', 'featured')->where('registration_packages.type', 'profile');
    //     })->DISTINCT('customer_id')->count();

    //     $data['i2b'] = I2b::whereDate('deadline_date', '>=', date('Y-m-d'))->count();
    //     $data['users'] = Customer::count();
    //     $data['orders'] = Order::limit(10)->with('customer:id,name,email,type')->with('registrationPackage.registrationPackageDetail')->latest()->get();

    //     return $this->successResponse($data, 'Data get successfully.');
    // }

    public function show()
    {
        $data['business_profiles'] = CustomerProfile::whereHas('customer', function ($q) {
            $q->where('is_active', 1)
              ->where('is_package_amount_paid', 1)
              ->where('package_expiry_date', '>=', date('Y-m-d'))
              ->where('type', 'customer');
        })->distinct('customer_id')->count();

        $data['featured_exporters'] = CustomerProfile::whereHas('customer', function ($q) {
            $q->where('is_active', 1)
              ->where('is_package_amount_paid', 1)
              ->where('package_expiry_date', '>=', date('Y-m-d'))
              ->where('type', 'customer');
        })->whereHas('customer.registrationPackage', function ($q) {
            $q->where('registration_packages.package_type', 'featured')
              ->where('registration_packages.type', 'profile');
        })->distinct('customer_id')->count();

        $data['i2b'] = I2b::whereDate('deadline_date', '>=', date('Y-m-d'))->count();
        $data['users'] = Customer::count();

        // Fetch both created and deleted orders
        $orders = Order::withTrashed()
            ->with(['customer' => function ($query) {
                $query->withTrashed();
            }])
            ->with('registrationPackage.registrationPackageDetail')
            ->latest()
            ->limit(10)
            ->get();

        // Create entries for both created and deleted status
        $orders = $orders->flatMap(function ($order) {
            $entries = [];

            // Created entry (always add if the order exists)
            $createdOrder = clone $order;
            $createdOrder->status = 'created';
            $entries[] = $createdOrder;

            // Deleted entry (only add if the order or customer is deleted)
            if ($order->trashed() || $order->customer->trashed()) {
                $deletedOrder = clone $order;
                $deletedOrder->status = 'deleted';
                $entries[] = $deletedOrder;
            }

            return $entries;
        });

        // Sort orders by the most recent action (created_at or deleted_at)
        $data['orders'] = $orders->sortByDesc(function ($order) {
            return $order->status === 'deleted' ? $order->deleted_at : $order->created_at;
        })->values(); // Reset keys after sorting

        return $this->successResponse($data, 'Data retrieved successfully.');
    }

}
