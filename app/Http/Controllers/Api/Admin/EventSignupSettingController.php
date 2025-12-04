<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EventSignupSettingResource;
use App\Models\EventSignupSetting;
use App\Traits\StatusResponser;

class EventSignupSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $eventSignup = EventSignupSetting::query();

        if (isset($_GET['withEventSignupSettingDetail']) && $_GET['withEventSignupSettingDetail'] == '1') {
            $eventSignup = $eventSignup->with('eventSignupSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $eventSignup = $eventSignup->wherePageId($_GET['findByPageId']);
        }

        $eventSignup = $eventSignup->firstOrFail();

        return $this->successResponse(new EventSignupSettingResource($eventSignup), 'Data get successfully.');
    }
}
