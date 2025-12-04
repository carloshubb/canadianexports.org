<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FooterSettingResource;
use App\Models\FooterSetting;
use App\Models\FooterSettingDetail;
use App\Rules\ValidUrl;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class FooterSettingController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $footerSettings = FooterSetting::query();

        $footerSettings = $this->whereClause($footerSettings);
        $footerSettings = $this->loadRelations($footerSettings);
        $footerSettings = $this->sortingAndLimit($footerSettings);

        return $this->apiSuccessResponse(FooterSettingResource::collection($footerSettings), 'Data Get Successfully!');
    }


    public function show(FooterSetting $footerSetting)
    {
        if (isset($_GET['withFooterSettingDetail']) && $_GET['withFooterSettingDetail'] == '1') {
            $footerSetting = $footerSetting->loadMissing('footerSettingDetail');
        }

        return $this->apiSuccessResponse(new FooterSettingResource($footerSetting), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [
            'fb_link' => ['nullable', new ValidUrl()],
            'twitter_link' => ['nullable', new ValidUrl()],
            'google_link' => ['nullable', new ValidUrl()],
            'youtube_link' => ['nullable', new ValidUrl()],
            'linkedin_link' => ['nullable', new ValidUrl()],
            'widget1_menu_id' => ['nullable', 'exists:menus,id'],
            'widget2_menu_id' => ['nullable', 'exists:menus,id'],
            'widget3_menu_id' => ['nullable', 'exists:menus,id'],
            'is_active' => ['required', 'boolean'],
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['widget1.widget1_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['widget1.widget1_' . $language->id . '.required' => 'Widget 1 in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['widget2.widget2_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['widget2.widget2_' . $language->id . '.required' => 'Widget 2 in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['widget3.widget3_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['widget3.widget3_' . $language->id . '.required' => 'Widget 3 in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['copyright_text.copyright_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['copyright_text.copyright_text_' . $language->id . '.required' => 'Copyright text in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);

        $footerSetting = FooterSetting::create([
            'fb_link' => $request->fb_link,
            'twitter_link' => $request->twitter_link,
            'google_link' => $request->google_link,
            'youtube_link' => $request->youtube_link,
            'linkedin_link' => $request->linkedin_link,
            'widget1_menu_id' => $request->widget1_menu_id,
            'widget2_menu_id' => $request->widget2_menu_id,
            'widget3_menu_id' => $request->widget3_menu_id,
            'is_active' => $request->is_active,
        ]);

        if ($footerSetting) {
            if ($request->is_active == true) {
                $this->removeDefaultFooter($footerSetting);
            }
            foreach ($languages as $language) {
                FooterSettingDetail::create([
                    'footer_setting_id' => $footerSetting->id,
                    'language_id' => $language->id,
                    'widget1' => $request['widget1']['widget1_' . $language->id],
                    'widget2' => $request['widget2']['widget2_' . $language->id],
                    'widget3' => $request['widget3']['widget3_' . $language->id],
                    'copyright_text' => $request['copyright_text']['copyright_text_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new FooterSettingResource($footerSetting), 'Footer setting has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, FooterSetting $footerSetting)
    {
        $validationRule = [
            'id' => ['required', 'exists:footer_setting,id'],
            'fb_link' => ['nullable', new ValidUrl()],
            'twitter_link' => ['nullable', new ValidUrl()],
            'google_link' => ['nullable', new ValidUrl()],
            'youtube_link' => ['nullable', new ValidUrl()],
            'linkedin_link' => ['nullable', new ValidUrl()],
            'widget1_menu_id' => ['nullable', 'exists:menus,id'],
            'widget2_menu_id' => ['nullable', 'exists:menus,id'],
            'widget3_menu_id' => ['nullable', 'exists:menus,id'],
            'is_active' => ['required', 'boolean'],
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['widget1.widget1_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['widget1.widget1_' . $language->id . '.required' => 'Widget 1 in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['widget2.widget2_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['widget2.widget2_' . $language->id . '.required' => 'Widget 2 in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['widget3.widget3_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['widget3.widget3_' . $language->id . '.required' => 'Widget 3 in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['copyright_text.copyright_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['copyright_text.copyright_text_' . $language->id . '.required' => 'Copyright text in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);

        FooterSetting::whereId($request->id)->update([
            'fb_link' => $request->fb_link,
            'twitter_link' => $request->twitter_link,
            'google_link' => $request->google_link,
            'youtube_link' => $request->youtube_link,
            'linkedin_link' => $request->linkedin_link,
            'widget1_menu_id' => $request->widget1_menu_id,
            'widget2_menu_id' => $request->widget2_menu_id,
            'widget3_menu_id' => $request->widget3_menu_id,
            'is_active' => $request->is_active,
        ]);

        if ($footerSetting) {
            if ($request->is_active == true) {
                $this->removeDefaultFooter($footerSetting);
            }
            foreach ($languages as $language) {
                $footerSettingDetail = FooterSettingDetail::whereFooterSettingId($footerSetting->id)->whereLanguageId($language->id)->exists();
                if ($footerSettingDetail) {
                    FooterSettingDetail::whereFooterSettingId($footerSetting->id)->whereLanguageId($language->id)->update([
                        'widget1' => $request['widget1']['widget1_' . $language->id],
                        'widget2' => $request['widget2']['widget2_' . $language->id],
                        'widget3' => $request['widget3']['widget3_' . $language->id],
                        'copyright_text' => $request['copyright_text']['copyright_text_' . $language->id],
                    ]);
                } else {
                    FooterSettingDetail::create([
                        'footer_setting_id' => $footerSetting->id,
                        'language_id' => $language->id,
                        'widget1' => $request['widget1']['widget1_' . $language->id],
                        'widget2' => $request['widget2']['widget2_' . $language->id],
                        'widget3' => $request['widget3']['widget3_' . $language->id],
                        'copyright_text' => $request['copyright_text']['copyright_text_' . $language->id],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new FooterSettingResource($footerSetting), 'Footer setting has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, FooterSetting $footerSetting)
    {
        if ($footerSetting->footerSettingDetail()->delete() && $footerSetting->delete()) {
            return $this->apiSuccessResponse(new FooterSettingResource($footerSetting), 'Footer setting has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function removeDefaultFooter($footerSetting)
    {
        FooterSetting::where('id', '!=', $footerSetting->id)->update([
            'is_active' => 0
        ]);
    }

    protected function loadRelations($footerSettings)
    {
        $defaultLang = getDefaultLanguage();
        $footerSettings = $footerSettings->with(['footerSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withFooterSettingDetail']) && $_GET['withFooterSettingDetail'] == '1') {
            $footerSettings = $footerSettings->with('footerSettingDetail');
        }
        return $footerSettings;
    }

    protected function sortingAndLimit($footerSettings)
    {

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'is_active', 'fb_link', 'twitter_link', 'google_link'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $footerSettings = $footerSettings->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $footerSettings->paginate($limit);
    }

    protected function whereClause($footerSettings)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $footerSettings = $footerSettings->where('fb_link', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('twitter_link', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('google_link', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $footerSettings;
    }
}
