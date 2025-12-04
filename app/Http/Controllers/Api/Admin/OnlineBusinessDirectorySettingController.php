<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OnlineBusinessDirectorySettingResource;
use App\Models\OnlineBusinessDirectorySetting;
use App\Traits\StatusResponser;

class OnlineBusinessDirectorySettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $OnlineBusinessDirectorySetting = OnlineBusinessDirectorySetting::with('onlineBusinessDirectorySettingDetail');

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $OnlineBusinessDirectorySetting = $OnlineBusinessDirectorySetting->wherePageId($_GET['findByPageId']);
        }

        $OnlineBusinessDirectorySetting = $OnlineBusinessDirectorySetting->firstOrFail();

        return $this->successResponse(new OnlineBusinessDirectorySettingResource($OnlineBusinessDirectorySetting), 'Data get successfully.');
    }
}
