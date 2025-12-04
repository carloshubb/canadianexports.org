<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SuccessStoriesSettingResource;
use App\Models\SuccessStoriesSetting;
use App\Traits\StatusResponser;

class SuccessStoriesSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $successStoriesSetting = SuccessStoriesSetting::query();

        if (isset($_GET['withSuccessStoriesSettingDetail']) && $_GET['withSuccessStoriesSettingDetail'] == '1') {
            $successStoriesSetting = $successStoriesSetting->with('successStoriesSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $successStoriesSetting = $successStoriesSetting->wherePageId($_GET['findByPageId']);
        }

        $successStoriesSetting = $successStoriesSetting->firstOrFail();

        return $this->successResponse(new SuccessStoriesSettingResource($successStoriesSetting), 'Data get successfully.');
    }
}
