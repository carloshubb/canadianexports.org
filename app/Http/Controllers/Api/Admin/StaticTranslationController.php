<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\StaticTranslationResource;
use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

    public function exportCsv()
    {
        $fileName = 'languages_' . now()->format('Ymd_His') . '.csv';
        $filePath = "public/exports/$fileName";  // storage/app/exports/
        $fileUrl = "exports/$fileName";  // storage/app/exports/

        // Ensure folder exists
        if (!Storage::exists('public/exports')) {
            Storage::makeDirectory('public/exports');
        }

        // Create CSV content
        $handle = fopen(storage_path("app/$filePath"), 'w');

        // UTF-8 BOM (Excel fix)
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Assume an English is default language !!! ID of 1
        $detail_lang_list = StaticTranslationDetail::whereLanguageId(1)->get();
        
        $lang_list = getAllLanguages();
        $lang_arr = [];
        $lang_ids = [];
        foreach ($lang_list as $lang) {
            $lang_id = $lang->id;
            $lang_arr[] = $lang->name;
            $lang_ids[] = $lang->id;
            // Add language columns to header
            foreach ($detail_lang_list as $lang_detail) {
                $translation = StaticTranslationDetail::where('static_translation_id', $lang_detail->static_translation_id)
                    ->where('key', $lang_detail->key)
                    ->where('language_id', $lang_id)
                    ->first();
                $lang_detail->{'lang_' . $lang_id} = $translation ? $translation->value : '';
            }
        }
        // Header
        fputcsv($handle, ['ID', 'Display Text', 'Key', ...$lang_arr]);

        // Rows
        foreach ($detail_lang_list as $lang) {
            fputcsv($handle, [
                $lang->static_translation_id,
                $lang->display_text,
                $lang->key,
                // Add translations for each language
                ...array_map(function ($l) use ($lang) {
                    $_COOKIE = 'lang_' . $l;
                    return $lang->$_COOKIE;
                }, $lang_ids), 
            ]);
        }

        fclose($handle);

        // Return download URL
        return response()->json([
            'status'    => 'Success',
            'file_url'  => url("storage/$fileUrl"), // public/storage/exports
        ]);
    }

    public function importCsv(Request $request)
    {
        $validationRule = [
            'file' => ['required', 'mimes:csv,txt'],
        ];
        $this->validate(
            $request,
            $validationRule
        );

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $handle = fopen($file->getRealPath(), 'r');

            // Skip header row
            fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== false) {
                $static_translation_id = $data[0];
                $display_text = $data[1];
                $key = $data[2];

                $lang_list = getAllLanguages();
                $lang_ids = [];
                foreach ($lang_list as $lang) {
                    $lang_ids[] = $lang->id;
                }

                foreach ($lang_ids as $index => $lang_id) {
                    $value = isset($data[3 + $index]) ? $data[3 + $index] : "";
                    $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1252');

                    StaticTranslationDetail::updateOrCreate(
                        [
                            'static_translation_id' => $static_translation_id,
                            'language_id' => $lang_id,
                            'key' => $key,
                            'display_text' => $display_text,
                        ],
                        [
                            'value' => $value,
                        ]
                    );
                }
            }

            fclose($handle);

            return $this->successResponse([], 'CSV imported successfully.');
        }

        return $this->errorResponse('No file uploaded.', 400);
    }
}
