<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BecomeSponsorSettingResource;
use App\Models\BecomeSponsorSetting;
use App\Traits\StatusResponser;

class BecomeSponsorSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $becomeSponsorSetting = BecomeSponsorSetting::query();

        if (isset($_GET['withBecomeSponsorSettingDetail']) && $_GET['withBecomeSponsorSettingDetail'] == '1') {
            $becomeSponsorSetting = $becomeSponsorSetting->with('becomeSponsorSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $becomeSponsorSetting = $becomeSponsorSetting->wherePageId($_GET['findByPageId']);
        }

        $becomeSponsorSetting = $becomeSponsorSetting->firstOrFail();

        return $this->successResponse(new BecomeSponsorSettingResource($becomeSponsorSetting), 'Data get successfully.');
    }
}
