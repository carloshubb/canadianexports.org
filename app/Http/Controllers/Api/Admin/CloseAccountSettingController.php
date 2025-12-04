<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CloseAccountSettingResource;
use App\Models\CloseAccountSetting;
use App\Traits\StatusResponser;

class CloseAccountSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $closeAccountSetting = CloseAccountSetting::query();

        if (isset($_GET['withCloseAccountSettingDetail']) && $_GET['withCloseAccountSettingDetail'] == '1') {
            $closeAccountSetting = $closeAccountSetting->with('closeAccountSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $closeAccountSetting = $closeAccountSetting->wherePageId($_GET['findByPageId']);
        }

        $closeAccountSetting = $closeAccountSetting->firstOrFail();
        return $this->successResponse(new CloseAccountSettingResource($closeAccountSetting), 'Data get successfully.');
    }
}
