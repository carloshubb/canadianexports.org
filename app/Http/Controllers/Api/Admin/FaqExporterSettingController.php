<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FaqExporterSettingResource;
use App\Models\FaqExporterSetting;
use App\Traits\StatusResponser;

class FaqExporterSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $faqExporterSetting = FaqExporterSetting::query();

        if (isset($_GET['withFaqExporterSettingDetail']) && $_GET['withFaqExporterSettingDetail'] == '1') {
            $faqExporterSetting = $faqExporterSetting->with('faqExporterSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            // dd($faqExporterSetting);
            $faqExporterSetting = $faqExporterSetting->wherePageId($_GET['findByPageId']);
        }

        $faqExporterSetting = $faqExporterSetting->first();


        return $this->successResponse(new FaqExporterSettingResource($faqExporterSetting), 'Data get successfully.');
    }
}
