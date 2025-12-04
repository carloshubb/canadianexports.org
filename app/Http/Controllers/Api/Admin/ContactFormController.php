<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ContactFormResource;
use App\Models\ContactForm;
use App\Traits\StatusResponser;

class ContactFormController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $contactForm = ContactForm::query();
        $contactForm = $contactForm->with(['emailSentByUser']);

        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $contactForm = $contactForm->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('message', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'email', 'message'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $contactForm = $contactForm->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        $contactForm = $contactForm->paginate($limit);


        return $this->successResponse(ContactFormResource::collection($contactForm), 'Data get successfully.');
    }
}
