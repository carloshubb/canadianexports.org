<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\InfoLetterResource;
use App\Models\InfoLetter;
use App\Traits\StatusResponser;

class InfoLetterController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $infoLetter = InfoLetter::query();
        $infoLetter = $infoLetter->with(['emailSentByUser']);

        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $infoLetter = $infoLetter->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('company_name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('country', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'email', 'message'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $infoLetter = $infoLetter->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        $infoLetter = $infoLetter->paginate($limit);


        return $this->successResponse(InfoLetterResource::collection($infoLetter), 'Data get successfully.');
    }
}
