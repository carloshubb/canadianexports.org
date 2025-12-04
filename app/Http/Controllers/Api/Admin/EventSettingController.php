<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EventSettingResource;
use App\Models\EventSetting;
use App\Traits\StatusResponser;

class EventSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $eventSetting = EventSetting::query();

        if (isset($_GET['withEventSettingDetail']) && $_GET['withEventSettingDetail'] == '1') {
            $eventSetting = $eventSetting->with('eventSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $eventSetting = $eventSetting->wherePageId($_GET['findByPageId']);
        }

        $eventSetting = $eventSetting->firstOrFail();

        return $this->successResponse(new EventSettingResource($eventSetting), 'Data get successfully.');
    }
}
