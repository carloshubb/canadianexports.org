<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ContactUsSettingResource;
use App\Models\ContactUsSetting;
use App\Traits\StatusResponser;

class ContactUsSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $contactUsSetting = ContactUsSetting::query();

        if (isset($_GET['withContactUsSettingDetail']) && $_GET['withContactUsSettingDetail'] == '1') {
            $contactUsSetting = $contactUsSetting->with('contactUsSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $contactUsSetting = $contactUsSetting->wherePageId($_GET['findByPageId']);
        }

        $contactUsSetting = $contactUsSetting->firstOrFail();

        return $this->successResponse(new ContactUsSettingResource($contactUsSetting), 'Data get successfully.');
    }
}
