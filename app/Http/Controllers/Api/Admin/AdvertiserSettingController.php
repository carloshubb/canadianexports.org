<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdvertiserSettingResource;
use App\Models\AdvertiserSetting;
use App\Traits\StatusResponser;

class AdvertiserSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $advertiserSetting = AdvertiserSetting::query();

        if (isset($_GET['withAdvertiserSettingDetail']) && $_GET['withAdvertiserSettingDetail'] == '1') {
            $advertiserSetting = $advertiserSetting->with('advertiserSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $advertiserSetting = $advertiserSetting->wherePageId($_GET['findByPageId']);
        }

        $advertiserSetting = $advertiserSetting->firstOrFail();

        return $this->successResponse(new AdvertiserSettingResource($advertiserSetting), 'Data get successfully.');
    }
}
