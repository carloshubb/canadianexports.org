<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\CustomerPaymentMethodResource;
use App\Models\CustomerPaymentMethod;
use App\Traits\StatusResponser;
use Illuminate\Support\Facades\Auth;

class CustomerPaymentMethodController extends Controller
{
    use StatusResponser;


    public function index()
    {
        $methods = [];
        if (Auth::guard('customers')->check()) {
            $methods = CustomerPaymentMethod::whereCustomerId(Auth::guard('customers')->user()->id)->get();
        }
        $data = [];
        $data['methods'] = CustomerPaymentMethodResource::collection($methods);
        $data['payment_setting'] = getI2bModalSetting(null, ['payment_setting']);

        return $this->successResponse($data, 'Data get successfully.');
    }
}
