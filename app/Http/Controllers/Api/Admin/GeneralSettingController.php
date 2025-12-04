<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\GeneralSettingResource;
use App\Models\GeneralSetting;
use App\Models\Media;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
class GeneralSettingController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function index()
    {
        $generalSetting = GeneralSetting::query();
        if (isset($_GET['onlyMediaSetting']) && $_GET['onlyMediaSetting'] == '1') {
            $generalSetting = $generalSetting->whereType('media');
        }
        if (isset($_GET['onlyEmailSetting']) && $_GET['onlyEmailSetting'] == '1') {
            $generalSetting = $generalSetting->whereType('email');
        }
        if (isset($_GET['onlyPackageSetting']) && $_GET['onlyPackageSetting'] == '1') {
            $generalSetting = $generalSetting->whereType('package');
        }
        if (isset($_GET['onlyMetaTagsSetting']) && $_GET['onlyMetaTagsSetting'] == '1') {
            $generalSetting = $generalSetting->whereType('meta_tags');
        }
        // if (isset($_GET['onlyGeneralSetting']) && $_GET['onlyGeneralSetting'] == '1') {
        //     $generalSetting = $generalSetting->whereNull('type');
        // }
        if (isset($_GET['onlyGeneralSetting']) && $_GET['onlyGeneralSetting'] == '1') {
            $generalSetting = $generalSetting->where(function($query) {
                $query->whereNull('type')
                      ->orWhere('type', 'pages_setting');
            });
        }
        return $this->successResponse(GeneralSettingResource::collection($generalSetting->get()), 'Data get successfully.');
    }

    public function store(Request $request)
    {
        $fileds = $request->all();

        foreach ($fileds as $setting) {
            $generalSetting = GeneralSetting::where('key', $setting['key'])->first();
            if ($generalSetting) {
                $generalSetting->value = $setting['value'];
                $generalSetting->save();
            }
        }

        return $this->successResponse([], 'Setting has been updated successfully.');
    }

    function saveMetaTagsSetting(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $validationRule = array_merge($validationRule, ['facebook_media_id' => ['nullable', 'string']]);
        $niceName = [];
        $niceName['facebook_media_id'] = 'Facebook media';
        $this->validate(
            $request,
            $validationRule,
            $errorMessages,
            $niceName
        );

        $setting = GeneralSetting::where('type', 'meta_tags')->pluck('value', 'key');

        if(isset($request->facebook_media_id)){
            $media = json_decode($request->facebook_media_id, 1);
            $media_id = $setting['facebook_meta_image'];
            $mediaRes = $media_id ? Media::whereId($media_id)->first() : null;
            if((isset($media, $media[0], $mediaRes) && $mediaRes->path != $media[0]) || (isset($media, $media[0]) && !isset($mediaRes))){
                $facebook = $this->moveFile($media, 'media/pages', 'meta_info');
            }
            else{
                $facebook[0]['id'] = $setting['facebook_meta_image'];
            }
        }
        GeneralSetting::where('type', 'meta_tags')->where('key', 'facebook_meta_image')->update([
            'value' => isset($facebook, $facebook[0]) ? $facebook[0]['id'] : null
        ]);

        return $this->successResponse([], 'Setting has been updated successfully.');
    }
}
