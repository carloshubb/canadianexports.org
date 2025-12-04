<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\HolidayEmailResource;
use App\Models\HolidayEmail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class HolidayEmailController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $holidayEmails = HolidayEmail::query();

        $holidayEmails = $this->whereClause($holidayEmails);
        $holidayEmails = $this->sortingAndLimit($holidayEmails);

        return $this->apiSuccessResponse(HolidayEmailResource::collection($holidayEmails), 'Data Get Successfully!');
    }


    public function show(HolidayEmail $holidayEmail)
    {
        return $this->apiSuccessResponse(new HolidayEmailResource($holidayEmail), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email_subject' => ['required', 'string'],
            'email_content' => ['required', 'string'],
            'holidays_from' => ['required', 'date'],
            'holidays_to' => ['required', 'date'],
            'email_sent_date' => ['required', 'date', 'after:now'],
        ]);

        $holidayEmail = HolidayEmail::create([
            'name' => $request->name,
            'email_subject' => $request->email_subject,
            'email_content' => $request->email_content,
            'holidays_from' => $request->holidays_from,
            'holidays_to' => $request->holidays_to,
            'email_sent_date' => $request->email_sent_date,
        ]);

        if ($holidayEmail) {
            return $this->apiSuccessResponse(new HolidayEmailResource($holidayEmail), 'Holiday email has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, HolidayEmail $holidayEmail)
    {
        // dd($request->all());
        $rules = [
            'id' => ['required', 'exists:App\Models\HolidayEmail,id'],
            'name' => ['required', 'string'],
            'email_subject' => ['required', 'string'],
            'email_content' => ['required', 'string'],
            'holidays_from' => ['required', 'date'],
            'holidays_to' => ['required', 'date'],
            'email_sent_date' => ['required', 'date', 'after:now'],
        ];
        $this->validate($request, $rules);
        if ($request->email_sent_date != $holidayEmail->email_sent_date) {
            HolidayEmail::whereId($request->id)->update([
                'is_email_sent' => 0,
            ]);
        }
        $result = HolidayEmail::whereId($request->id)->update([
            'name' => $request->name,
            'email_subject' => $request->email_subject,
            'email_content' => $request->email_content,
            'holidays_from' => $request->holidays_from,
            'holidays_to' => $request->holidays_to,
            'email_sent_date' => $request->email_sent_date,
        ]);

        if ($result) {
            return $this->apiSuccessResponse(new HolidayEmailResource($holidayEmail), 'Holiday email has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, HolidayEmail $holidayEmail)
    {
        if ($holidayEmail->delete()) {
            return $this->apiSuccessResponse(new HolidayEmailResource($holidayEmail), 'Holiday email has been deleted successfully.');
        }
        return $this->errorResponse();
    }


    protected function sortingAndLimit($holidayEmails)
    {

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'email_subject', 'email_content'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $holidayEmails = $holidayEmails->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $holidayEmails->paginate($limit);
    }

    protected function whereClause($holidayEmails)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $holidayEmails = $holidayEmails->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email_subject', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email_content', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $holidayEmails;
    }
}
