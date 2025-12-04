<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdvertiserContactFormResource;
use App\Models\AdvertiserContactForm;
use App\Traits\StatusResponser;

class AdvertiserFormController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $advertiserContactForm = AdvertiserContactForm::query();
        $advertiserContactForm = $advertiserContactForm->with(['emailSentByUser', 'customerProfile.customer']);

        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $advertiserContactForm = $advertiserContactForm->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('message', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'email', 'message'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $advertiserContactForm = $advertiserContactForm->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        $advertiserContactForm = $advertiserContactForm->paginate($limit);


        return $this->successResponse(AdvertiserContactFormResource::collection($advertiserContactForm), 'Data get successfully.');
    }
}
