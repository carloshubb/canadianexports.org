<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RegPageSettingResource;
use App\Models\RegPageSetting;
use App\Traits\StatusResponser;

class RegPageSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $regPageSetting = RegPageSetting::query();

        if (isset($_GET['withRegPageSettingDetail']) && $_GET['withRegPageSettingDetail'] == '1') {
            $regPageSetting = $regPageSetting->with('regPageSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $regPageSetting = $regPageSetting->wherePageId($_GET['findByPageId']);
        }

        $regPageSetting = $regPageSetting->firstOrFail();

        return $this->successResponse(new RegPageSettingResource($regPageSetting), 'Data get successfully.');
    }
}
