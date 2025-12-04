<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FinancingProgramSettingResource;
use App\Models\FinancingProgramSetting;
use App\Traits\StatusResponser;

class FinancingProgramSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $financingProgramSetting = FinancingProgramSetting::query();

        if (isset($_GET['withFinancingProgramSettingDetail']) && $_GET['withFinancingProgramSettingDetail'] == '1') {
            $financingProgramSetting = $financingProgramSetting->with('financingProgramSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $financingProgramSetting = $financingProgramSetting->wherePageId($_GET['findByPageId']);
        }

        $financingProgramSetting = $financingProgramSetting->firstOrFail();

        return $this->successResponse(new FinancingProgramSettingResource($financingProgramSetting), 'Data get successfully.');
    }
}
