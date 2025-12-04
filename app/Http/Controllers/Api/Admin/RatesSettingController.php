<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RatesSettingResource;
use App\Models\RatesSetting;
use App\Traits\StatusResponser;

class RatesSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $ratesSetting = RatesSetting::query();

        if (isset($_GET['withRatesSettingDetail']) && $_GET['withRatesSettingDetail'] == '1') {
            $ratesSetting = $ratesSetting->with('ratesSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $ratesSetting = $ratesSetting->wherePageId($_GET['findByPageId']);
        }

        $ratesSetting = $ratesSetting->firstOrFail();

        return $this->successResponse(new RatesSettingResource($ratesSetting), 'Data get successfully.');
    }
}
