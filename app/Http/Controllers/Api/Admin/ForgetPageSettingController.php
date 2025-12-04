<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ForgetPageSettingResource;
use App\Models\ForgetPageSetting;
use App\Traits\StatusResponser;

class ForgetPageSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $forgetPageSetting = ForgetPageSetting::query();

        if (isset($_GET['withForgetPageSettingDetail']) && $_GET['withForgetPageSettingDetail'] == '1') {
            $forgetPageSetting = $forgetPageSetting->with('forgetPageSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $forgetPageSetting = $forgetPageSetting->wherePageId($_GET['findByPageId']);
        }

        $forgetPageSetting = $forgetPageSetting->firstOrFail();

        return $this->successResponse(new ForgetPageSettingResource($forgetPageSetting), 'Data get successfully.');
    }
}
