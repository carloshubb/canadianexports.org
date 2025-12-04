<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FaqImporterSettingResource;
use App\Models\FaqImporterSetting;
use App\Traits\StatusResponser;

class FaqImporterSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $faqImporterSetting = FaqImporterSetting::query();

        if (isset($_GET['withFaqImporterSettingDetail']) && $_GET['withFaqImporterSettingDetail'] == '1') {
            $faqImporterSetting = $faqImporterSetting->with('faqImporterSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $faqImporterSetting = $faqImporterSetting->wherePageId($_GET['findByPageId']);
        }

        $faqImporterSetting = $faqImporterSetting->firstOrFail();

        return $this->successResponse(new FaqImporterSettingResource($faqImporterSetting), 'Data get successfully.');
    }
}
