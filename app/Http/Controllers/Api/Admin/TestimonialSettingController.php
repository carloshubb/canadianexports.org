<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TestimonialSettingResource;
use App\Models\TestimonialSetting;
use App\Traits\StatusResponser;

class TestimonialSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $testimonialSetting = TestimonialSetting::query();

        if (isset($_GET['withTestimonialSettingDetail']) && $_GET['withTestimonialSettingDetail'] == '1') {
            $testimonialSetting = $testimonialSetting->with('testimonialSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $testimonialSetting = $testimonialSetting->wherePageId($_GET['findByPageId']);
        }

        $testimonialSetting = $testimonialSetting->firstOrFail();

        return $this->successResponse(new TestimonialSettingResource($testimonialSetting), 'Data get successfully.');
    }
}
