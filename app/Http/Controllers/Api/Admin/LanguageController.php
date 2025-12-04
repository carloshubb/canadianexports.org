<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Resources\Admin\LanguageResource;
use App\Models\BusinessCategoryDetail;
use App\Models\Language;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $languages = Language::query();

        $languages = $this->whereClause($languages);
        $languages = $this->loadRelations($languages);
        $languages = $this->sortingAndLimit($languages);

        return $this->apiSuccessResponse(LanguageResource::collection($languages), 'Data Get Successfully!');
    }


    public function show(Language $language)
    {
        if (isset($_GET['withFlagIcon']) && $_GET['withFlagIcon'] == '1') {
            $language = $language->loadMissing('flagIcon');
        }

        return $this->apiSuccessResponse(new LanguageResource($language), 'Data Get Successfully!');
    }


    public function store(LanguageRequest $request)
    {
        $media = json_decode($request->flag_icon, 1);
        $files = $this->moveFile($media, 'media/flag_icons', 'flag_icon');
        $lang = getDefaultLanguage();
        $language = Language::create([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'native_name' => $request->native_name,
            'is_default' => $request->is_default,
            'direction' => $request->direction,
            'flag_icon' => isset($files, $files[0]) ? $files[0]->id : null,
        ]);

        if ($language) {
            if ($request->is_default == true) {
                $this->removeDefaultLanguage($language);
            }
            if (!file_exists(lang_path($request->abbreviation))) {
                File::makeDirectory(lang_path($request->abbreviation));
            }
            $abbreviation = !isset($lang->abbreviation) ? 'en' : $lang->abbreviation;
            foreach (glob(lang_path($abbreviation) . '/*.*') as $file) {
                if (app()->isProduction()) {
                    $file_to_go = str_replace('/' . $abbreviation . '/', '/' . $request->abbreviation . '/', $file);
                } else {
                    $file_to_go = str_replace($abbreviation . '/', $request->abbreviation . '/', $file);
                }
                if (!file_exists($file_to_go)) {
                    copy($file, $file_to_go);
                }
            }
            return $this->apiSuccessResponse(new LanguageResource($language), 'Language has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Language $language)
    {
        $rules = [
            'id' => ['required', 'exists:App\Models\Language,id'],
            'name' => ['required', 'string', 'max:50'],
            'abbreviation' => ['required', 'string', 'max:10'],
            'native_name' => ['required', 'string', 'max:50'],
            'is_default' => ['required', 'boolean'],
            'direction' => ['required', 'in:ltr,rtl'],
            'flag_icon' => ['nullable']
        ];
        $this->validate($request, $rules);
        if (isset($request->flag_icon) && !is_array($request->flag_icon)) {
            $media = json_decode($request->flag_icon, 1);
            $files = $this->moveFile($media, 'media/flag_icons', 'flag_icon');
        }
        $lang = getDefaultLanguage();
        $result = Language::whereId($request->id)->update([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'native_name' => $request->native_name,
            'is_default' => $request->is_default,
            'direction' => $request->direction,
            'flag_icon' => !isset($request->flag_icon) ? null : (isset($files, $files[0]) ? $files[0]->id : $language->flag_icon),
        ]);

        if ($result) {
            if ($request->is_default == true) {
                $this->removeDefaultLanguage($language);
            }
            if (!file_exists(lang_path($request->abbreviation))) {
                File::makeDirectory(lang_path($request->abbreviation));
            }
            $abbreviation = !isset($lang->abbreviation) ? 'en' : $lang->abbreviation;
            foreach (glob(lang_path($abbreviation) . '/*.*') as $file) {
                if (app()->isProduction()) {
                    $file_to_go = str_replace('/' . $abbreviation . '/', '/' . $request->abbreviation . '/', $file);
                } else {
                    $file_to_go = str_replace($abbreviation . '/', $request->abbreviation . '/', $file);
                }
                if (!file_exists($file_to_go)) {
                    copy($file, $file_to_go);
                }
            }
            return $this->apiSuccessResponse(new LanguageResource($language), 'Language has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, Language $language)
    {
        $bcdExists = BusinessCategoryDetail::whereLanguageId($language->id)->exists();
        if ($bcdExists) {
            return $this->errorResponse('Sorry, you can not delete this because its already used in business categories.');
        }
        if ($language->is_default) {
            return $this->errorResponse('Sorry, you can not delete this because its default language.');
        }
        if ($language->delete()) {
            return $this->apiSuccessResponse(new LanguageResource($language), 'Language has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function removeDefaultLanguage($language)
    {
        Language::where('id', '!=', $language->id)->update([
            'is_default' => 0
        ]);
    }

    protected function loadRelations($languages)
    {
        if (isset($_GET['withFlagIcon']) && $_GET['withFlagIcon'] == '1') {
            $languages = $languages->with('flagIcon');
        }
        return $languages;
    }

    protected function sortingAndLimit($languages)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $languages->orderBy('is_default', 'desc')->orderBy('name', 'asc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'native_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $languages = $languages->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $languages->paginate($limit);
    }

    protected function whereClause($languages)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $languages = $languages->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('abbreviation', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('native_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $languages;
    }
}
