<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ExportingFairSettingResource;
use App\Models\ExportingFairSetting;
use App\Traits\StatusResponser;

class ExportingFairSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $exportingFairSetting = ExportingFairSetting::query();

        if (isset($_GET['withExportingFairSettingDetail']) && $_GET['withExportingFairSettingDetail'] == '1') {
            $exportingFairSetting = $exportingFairSetting->with('exportingFairSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $exportingFairSetting = $exportingFairSetting->wherePageId($_GET['findByPageId']);
        }

        $exportingFairSetting = $exportingFairSetting->firstOrFail();

        return $this->successResponse(new ExportingFairSettingResource($exportingFairSetting), 'Data get successfully.');
    }
}
