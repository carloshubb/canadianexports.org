<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\HomePageSettingResource;
use App\Models\HomePageSetting;
use App\Traits\StatusResponser;

class HomePageSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $homePageSetting = HomePageSetting::query();

        if (isset($_GET['withHomePageSettingDetail']) && $_GET['withHomePageSettingDetail'] == '1') {
            $homePageSetting = $homePageSetting->with('homePageSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $homePageSetting = $homePageSetting->wherePageId($_GET['findByPageId']);
        }

        $homePageSetting = $homePageSetting->firstOrFail();

        return $this->successResponse(new HomePageSettingResource($homePageSetting), 'Data get successfully.');
    }
}
