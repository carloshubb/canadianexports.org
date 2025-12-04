<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\StaticTranslationResource;
use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class StaticTranslationController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $staticTranslation = StaticTranslation::query();
        if (isset($_GET['findByType']) && $_GET['findByType'] != '') {
            $type = str_replace('-', '_', strtolower($_GET['findByType']));
            $staticTranslation = $staticTranslation->where('type', $type);


            if (isset($_GET['createStaticTranslationDetail']) && $_GET['createStaticTranslationDetail'] == '1') {
                $lang = getDefaultLanguage();
                $staticTrans = StaticTranslation::where('type', $type)->with(['staticTranslationDetail' => function ($q) use ($lang) {
                    $q->where('language_id', $lang->id);
                }])->first();
                if (isset($staticTrans, $staticTrans->staticTranslationDetail)) {
                    $languages = getAllLanguages();
                    foreach ($languages as $language) {
                        foreach ($staticTrans->staticTranslationDetail as $staticTranslationDetail) {
                            $response = StaticTranslationDetail::where('key', $staticTranslationDetail->key)->whereLanguageId($language->id)->where('static_translation_id', $staticTrans->id)->exists();
                            if (!$response) {
                                StaticTranslationDetail::create([
                                    'static_translation_id' => $staticTrans->id,
                                    'language_id' => $language->id,
                                    'display_text' => $staticTranslationDetail->display_text,
                                    'key' => $staticTranslationDetail->key,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        if (isset($_GET['withStaticTranslationDetail']) && $_GET['withStaticTranslationDetail'] == '1') {
            $staticTranslation = $staticTranslation->with('staticTranslationDetail');
        }

        return $this->successResponse(new StaticTranslationResource($staticTranslation->first()), 'Data get successfully.');
    }

    public function store(Request $request)
    {
        $validationRule = [
            'type' => ['required'],
        ];
        $this->validate(
            $request,
            $validationRule
        );
        $type = str_replace('-', '_', strtolower($request->type));

        $languages = getAllLanguages();
        $defaultLang = $languages->where('is_default', '1')->first();
        if ($defaultLang) {


            $staticTranslation = StaticTranslation::whereType($type)->with(['staticTranslationDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])->first();
        }
        $errorMessages = [];

        $staticTranslationDetail = $staticTranslation->staticTranslationDetail;
        foreach ($languages as $key => $language) {
            $requiredVal = 'nullable';
            // if($language->is_default == '1'){
            //     $requiredVal = 'required';
            // }
            foreach ($staticTranslationDetail as $key => $translationDetail) {
                $validationRule = array_merge($validationRule, [$translationDetail->key . '.' . $translationDetail->key . '_' . $language->id => [$requiredVal, 'string']]);
                $errorMessages = array_merge($errorMessages, [$translationDetail->key . '.' . $translationDetail->key . '_' . $language->id . '.required' => $translationDetail->display_text . ' in ' . $language->name . ' is required.']);
            }
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages,
        );

        foreach ($languages as $key => $language) {
            foreach ($staticTranslationDetail as $key => $translationDetail) {
                $detail = StaticTranslationDetail::whereLanguageId($language->id)->whereStaticTranslationId($translationDetail->static_translation_id)->where('key', $translationDetail->key)->exists();
                if ($detail) {
                    StaticTranslationDetail::whereLanguageId($language->id)->whereStaticTranslationId($translationDetail->static_translation_id)->where('key', $translationDetail->key)->update([
                        'value' => isset($request[$translationDetail->key][$translationDetail->key . '_' . $language->id]) ? $request[$translationDetail->key][$translationDetail->key . '_' . $language->id] : null
                    ]);
                } else {
                    StaticTranslationDetail::create([
                        'static_translation_id' => $translationDetail->static_translation_id,
                        'language_id' => $language->id,
                        'display_text' => $translationDetail->display_text,
                        'key' => $translationDetail->key,
                        'value' => isset($request[$translationDetail->key][$translationDetail->key . '_' . $language->id]) ? $request[$translationDetail->key][$translationDetail->key . '_' . $language->id] : null
                    ]);
                }
            }
        }

        // foreach ($fileds as $setting) {
        //     $staticTranslation = StaticTranslation::where('key', $setting['key'])->first();
        //     if ($staticTranslation) {
        //         $staticTranslation->value = $setting['value'];
        //         $staticTranslation->save();
        //     }
        // }

        return $this->successResponse([], 'Setting has been updated successfully.');
    }
}
