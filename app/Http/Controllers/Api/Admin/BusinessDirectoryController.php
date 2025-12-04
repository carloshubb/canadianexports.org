<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BusinessDirectoryResource;
use App\Imports\BusinessDirectoryImport;
use Illuminate\Support\Str;
use App\Models\BusinessDirectory;
use App\Models\BusinessDirectoryDetail;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class BusinessDirectoryController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $business_directories = BusinessDirectory::query();

        $business_directories = $this->whereClause($business_directories);
        $business_directories = $this->loadRelations($business_directories);
        $business_directories = $this->sortingAndLimit($business_directories);

        return $this->apiSuccessResponse(BusinessDirectoryResource::collection($business_directories), 'Data Get Successfully!');
    }


    public function show(BusinessDirectory $BusinessDirectory)
    {
        if (isset($_GET['withBusinessDirectoryDetail']) && $_GET['withBusinessDirectoryDetail'] == '1') {
            $BusinessDirectory = $BusinessDirectory->loadMissing('businessDirectoryDetail');
        }

        return $this->apiSuccessResponse(new BusinessDirectoryResource($BusinessDirectory), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required.']);
        }

        $validationRule = array_merge($validationRule, [
            'phone' => ['required']
        ]);

        $errorMessages = array_merge($errorMessages, [
            'phone.required' => 'Phone is required',
            'phone.regex' => 'Phone number must be a valid format with up to 15 digits'
        ]);
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $BusinessDirectory = BusinessDirectory::create([
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'industry' => $request->industry,
            'status' => $request->status,
        ]);


        if ($BusinessDirectory) {
            foreach ($languages as $language) {
                BusinessDirectoryDetail::create([
                    'business_directory_id' => $BusinessDirectory->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                    'slug' => Str::slug($request['name']['name_' . $language->id]),
                ]);
            }
            return $this->apiSuccessResponse(new BusinessDirectoryResource($BusinessDirectory), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, BusinessDirectory $BusinessDirectory)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $BusinessDirectory->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required.']);
        }

        $validationRule = array_merge($validationRule, ['phone' => ['required' , 'digits_between:1,15']]);
        $errorMessages = array_merge($errorMessages, ['phone.required' => 'Phone is required',
        'phone.digits_between' => 'Phone number cannot exceed 15 digits']);
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $BusinessDirectory->update([
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'industry' => $request->industry,
            'status' => $request->status,
        ]);
        foreach ($languages as $language) {
            $BusinessDirectoryDetail = BusinessDirectoryDetail::whereLanguageId($language->id)->whereBusinessDirectoryId($BusinessDirectory->id)->exists();
            if ($BusinessDirectoryDetail) {
                BusinessDirectoryDetail::whereLanguageId($language->id)->whereBusinessDirectoryId($BusinessDirectory->id)->update([
                    'name' => $request['name']['name_' . $language->id],
                    'slug' => Str::slug($request['name']['name_' . $language->id]),
                ]);
            } else {
                BusinessDirectoryDetail::create([
                    'business_directory_id' => $BusinessDirectory->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                    'slug' => Str::slug($request['name']['name_' . $language->id]),
                ]);
            }
        }

        if ($BusinessDirectory) {
            return $this->apiSuccessResponse(new BusinessDirectoryResource($BusinessDirectory), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, BusinessDirectory $BusinessDirectory)
    {
        if ($BusinessDirectory->businessDirectoryDetail()->delete() && $BusinessDirectory->delete()) {
            return $this->apiSuccessResponse(new BusinessDirectoryResource($BusinessDirectory), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($business_directories)
    {
        $defaultLang = getDefaultLanguage();
        $business_directories = $business_directories->with(['businessDirectoryDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withBusinessDirectoryDetail']) && $_GET['withBusinessDirectoryDetail'] == '1') {
            $business_directories = $business_directories->with('businessDirectoryDetail');
        }
        return $business_directories;
    }

    protected function sortingAndLimit($business_directories)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'business_directory_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $business_directories = $business_directories->addSelect(['business_directory_name' => BusinessDirectoryDetail::whereColumn('business_directories.id', 'business_directory_details.business_directory_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $business_directories = $business_directories->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $business_directories->paginate($limit);
    }

    protected function whereClause($business_directories)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $business_directories = $business_directories->whereHas('businessDirectoryDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $business_directories;
    }

    public function importBusinessDirectory(Request $request)
    {
        $validationRule = ['import_file' => 'required'];
        $this->validate(
            $request,
            $validationRule
        );

        Excel::import(new BusinessDirectoryImport, public_path($request->import_file));

        return $this->successResponse([], 'Business directories has been imported successfully!');
    }
}
