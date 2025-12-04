<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CoffeeWalletsResource;
use App\Models\CoffeeWallet;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class CoffeeWalletsController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $coffee_wallets = CoffeeWallet::with(['userInfo:id,name,email', 'beneficiaries:id,name']);

        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $coffee_wallets = $coffee_wallets->whereHas('visitor', function ($q) {
                $q->where('name', 'like', '%' . $_GET['searchParam']);
                $q->orWhere('email', 'like', '%' . $_GET['searchParam']);
                $q->orWhere('phone', 'like', '%' . $_GET['searchParam']);
            });
            $coffee_wallets = $coffee_wallets->orWhereHas('userInfo', function ($q) {
                $q->where('name', 'like', '%' . $_GET['searchParam']. '%');
            });
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {

            $coffee_wallets = $coffee_wallets->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        $coffee_wallets = $coffee_wallets->paginate($limit);


        return $this->apiSuccessResponse(CoffeeWalletsResource::collection($coffee_wallets), 'Data get successfully.');
    }
}
