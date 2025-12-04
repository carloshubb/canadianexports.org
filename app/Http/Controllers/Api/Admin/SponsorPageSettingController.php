<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SponsorPageSettingResource;
use App\Models\SponsorPageSetting;
use App\Traits\StatusResponser;

class SponsorPageSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $sponsorPageSetting = SponsorPageSetting::query();

        if (isset($_GET['withSponsorPageSettingDetail']) && $_GET['withSponsorPageSettingDetail'] == '1') {
            $sponsorPageSetting = $sponsorPageSetting->with('sponsorPageSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $sponsorPageSetting = $sponsorPageSetting->wherePageId($_GET['findByPageId']);
        }

        $sponsorPageSetting = $sponsorPageSetting->firstOrFail();

        return $this->successResponse(new SponsorPageSettingResource($sponsorPageSetting), 'Data get successfully.');
    }
}
