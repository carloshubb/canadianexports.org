<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EventListingSettingResource;
use App\Models\EventListingSetting;
use App\Traits\StatusResponser;

class EventListingSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $eventListingSetting = EventListingSetting::query();

        if (isset($_GET['withEventListingSettingDetail']) && $_GET['withEventListingSettingDetail'] == '1') {
            $eventListingSetting = $eventListingSetting->with('eventListingSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $eventListingSetting = $eventListingSetting->wherePageId($_GET['findByPageId']);
        }

        $eventListingSetting = $eventListingSetting->first();

        return $this->successResponse(new EventListingSettingResource($eventListingSetting), 'Data get successfully.');
    }
}
