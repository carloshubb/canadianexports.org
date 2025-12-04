<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\I2BSettingResource;
use App\Models\I2BSetting;
use App\Traits\StatusResponser;

class I2BSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $i2BSetting = I2BSetting::query();

        if (isset($_GET['withI2BSettingDetail']) && $_GET['withI2BSettingDetail'] == '1') {
            $i2BSetting = $i2BSetting->with('i2BSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $i2BSetting = $i2BSetting->wherePageId($_GET['findByPageId']);
        }

        $i2BSetting = $i2BSetting->firstOrFail();

        return $this->successResponse(new I2BSettingResource($i2BSetting), 'Data get successfully.');
    }
}
