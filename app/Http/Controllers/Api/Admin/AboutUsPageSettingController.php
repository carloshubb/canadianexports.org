<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AboutUsPageSettingResource;
use App\Models\AboutUsPageSetting;
use App\Traits\StatusResponser;

class AboutUsPageSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $aboutUsPageSetting = AboutUsPageSetting::query();

        if (isset($_GET['withAboutUsPageSettingDetail']) && $_GET['withAboutUsPageSettingDetail'] == '1') {
            $aboutUsPageSetting = $aboutUsPageSetting->with('aboutUsPageSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $aboutUsPageSetting = $aboutUsPageSetting->wherePageId($_GET['findByPageId']);
        }

        $aboutUsPageSetting = $aboutUsPageSetting->firstOrFail();

        return $this->successResponse(new AboutUsPageSettingResource($aboutUsPageSetting), 'Data get successfully.');
    }
}
