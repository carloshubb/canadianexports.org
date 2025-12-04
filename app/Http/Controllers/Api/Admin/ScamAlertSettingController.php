<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ScamAlertSettingResource;
use App\Models\ScamAlertSetting;
use App\Traits\StatusResponser;

class ScamAlertSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $scamAlertSetting = ScamAlertSetting::query();

        if (isset($_GET['withScamAlertSettingDetail']) && $_GET['withScamAlertSettingDetail'] == '1') {
            $scamAlertSetting = $scamAlertSetting->with('scamAlertSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $scamAlertSetting = $scamAlertSetting->wherePageId($_GET['findByPageId']);
        }

        $scamAlertSetting = $scamAlertSetting->firstOrFail();

        return $this->successResponse(new ScamAlertSettingResource($scamAlertSetting), 'Data get successfully.');
    }
}
