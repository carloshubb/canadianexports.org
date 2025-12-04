<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EventCreateSettingResource;
use App\Models\EventCreateSetting;
use App\Traits\StatusResponser;

class EventCreateSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $eventCreateSetting = EventCreateSetting::query();

        if (isset($_GET['withEventCreateSettingDetail']) && $_GET['withEventCreateSettingDetail'] == '1') {
            $eventCreateSetting = $eventCreateSetting->with('eventCreateSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $eventCreateSetting = $eventCreateSetting->wherePageId($_GET['findByPageId']);
        }

        $eventCreateSetting = $eventCreateSetting->firstOrFail();

        return $this->successResponse(new EventCreateSettingResource($eventCreateSetting), 'Data get successfully.');
    }
}
