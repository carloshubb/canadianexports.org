<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SponserListingSettingResource;
use App\Models\SponserListingSetting;
use Illuminate\Http\Request;
use App\Traits\StatusResponser;

class SponserListingSettingController extends Controller
{
    use StatusResponser;
    public function show()
    {
        $sponserListingSetting = SponserListingSetting::query();

        if (isset($_GET['withSponserListingSettingDetail']) && $_GET['withSponserListingSettingDetail'] == '1') {
            $sponserListingSetting = $sponserListingSetting->with('sponserListingSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $sponserListingSetting = $sponserListingSetting->wherePageId($_GET['findByPageId']);
        }

        $sponserListingSetting = $sponserListingSetting->firstOrFail();

        return $this->successResponse(new SponserListingSettingResource($sponserListingSetting), 'Data get successfully.');
    }
}
