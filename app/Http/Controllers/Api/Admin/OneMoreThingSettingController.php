<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OneMoreThingSettingResource;
use App\Models\OneMoreThingSetting;
use App\Traits\StatusResponser;

class OneMoreThingSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $oneMoreThingSetting = OneMoreThingSetting::query();

        if (isset($_GET['withOneMoreThingSettingDetail']) && $_GET['withOneMoreThingSettingDetail'] == '1') {
            $oneMoreThingSetting = $oneMoreThingSetting->with('oneMoreThingSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $oneMoreThingSetting = $oneMoreThingSetting->wherePageId($_GET['findByPageId']);
        }

        $oneMoreThingSetting = $oneMoreThingSetting->firstOrFail();

        return $this->successResponse(new OneMoreThingSettingResource($oneMoreThingSetting), 'Data get successfully.');
    }
}
