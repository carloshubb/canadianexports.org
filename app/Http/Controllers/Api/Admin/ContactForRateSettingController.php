<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ContactForRateSettingResource;
use App\Models\ContactForRateSetting;
use App\Traits\StatusResponser;

class ContactForRateSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $contactForRateSetting = ContactForRateSetting::query();

        if (isset($_GET['withContactForRateSettingDetail']) && $_GET['withContactForRateSettingDetail'] == '1') {
            $contactForRateSetting = $contactForRateSetting->with('contactForRateSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $contactForRateSetting = $contactForRateSetting->wherePageId($_GET['findByPageId']);
        }

        $contactForRateSetting = $contactForRateSetting->firstOrFail();

        return $this->successResponse(new ContactForRateSettingResource($contactForRateSetting), 'Data get successfully.');
    }
}
