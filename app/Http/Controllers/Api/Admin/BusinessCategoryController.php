<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BusinessCategoryResource;
use Illuminate\Support\Str;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class BusinessCategoryController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $businessCategories = BusinessCategory::query();
        $defaultLang = getDefaultLanguage();
        $businessCategories = $this->whereClause($businessCategories);
        $businessCategories = $this->loadRelations($businessCategories, $defaultLang);
        $businessCategories = $this->sortingAndLimit($businessCategories, $defaultLang);

        return $this->apiSuccessResponse(BusinessCategoryResource::collection($businessCategories), 'Data Get Successfully!');
    }


    public function show(BusinessCategory $businessCategory)
    {
        if (isset($_GET['withBusinessCategoryDetail']) && $_GET['withBusinessCategoryDetail'] == '1') {
            $businessCategory = $businessCategory->loadMissing('businessCategoryDetail');
        }

        return $this->apiSuccessResponse(new BusinessCategoryResource($businessCategory), 'Data Get Successfully!');
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
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $businessCategory = BusinessCategory::create([]);
        $slug = null;
        foreach ($languages as $language) {
            if ($language->is_default == '1' && isset($request['name']['name_' . $language->id])) {
                $slug = checkSlug(Str::slug($request['name']['name_' . $language->id]));
            }
            BusinessCategoryDetail::create([
                'business_category_id' => $businessCategory->id,
                'language_id' => $language->id,
                'name' => isset($request['name']['name_' . $language->id]) ? $request['name']['name_' . $language->id] : null,
                'slug' => isset($request['name']['name_' . $language->id]) ? checkSlug(Str::slug($request['name']['name_' . $language->id])) : null,
            ]);
        }
        BusinessCategory::whereId($businessCategory->id)->update([
            'slug' => $slug
        ]);

        if ($businessCategory) {
            return $this->apiSuccessResponse(new BusinessCategoryResource($businessCategory), 'Business category has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, BusinessCategory $businessCategory)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );


        $businessCategory->touch();
        $slug = null;
        foreach ($languages as $language) {
            if ($language->is_default == '1') {
                $slug = checkSlug(Str::slug($request['name']['name_' . $language->id]));
            }
            $businessCategoryDetail = BusinessCategoryDetail::whereLanguageId($language->id)->whereBusinessCategoryId($businessCategory->id)->exists();
            if ($businessCategoryDetail) {
                BusinessCategoryDetail::whereLanguageId($language->id)->whereBusinessCategoryId($businessCategory->id)->update([
                    'name' => isset($request['name']['name_' . $language->id]) ? $request['name']['name_' . $language->id] : null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? checkSlug(Str::slug($request['name']['name_' . $language->id])) : null,
                ]);
            } else {
                BusinessCategoryDetail::create([
                    'business_category_id' => $businessCategory->id,
                    'language_id' => $language->id,
                    'name' => isset($request['name']['name_' . $language->id]) ? $request['name']['name_' . $language->id] : null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? checkSlug(Str::slug($request['name']['name_' . $language->id])) : null,
                ]);
            }
        }
        if ($slug) {
            $businessCategory->update([
                'slug' => $slug
            ]);
        }

        if ($businessCategory) {
            return $this->apiSuccessResponse(new BusinessCategoryResource($businessCategory), 'Business category has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, BusinessCategory $businessCategory)
    {
        if ($businessCategory->businessCategoryDetail()->delete() && $businessCategory->delete()) {
            return $this->apiSuccessResponse(new BusinessCategoryResource($businessCategory), 'Business category has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($businessCategories, $defaultLang)
    {
        $businessCategories = $businessCategories->with(['businessCategoryDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withBusinessCategoryDetail']) && $_GET['withBusinessCategoryDetail'] == '1') {
            $businessCategories = $businessCategories->with('businessCategoryDetail');
        }
        return $businessCategories;
    }

    protected function sortingAndLimit($businessCategories, $defaultLang)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'category_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $businessCategories = $businessCategories->addSelect(['category_name' => BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')->where('business_category_detail.language_id', $defaultLang->id)->select('name')]);

            $businessCategories = $businessCategories->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $businessCategories->get();
        }

        return $businessCategories->paginate($limit);
    }

    protected function whereClause($businessCategories)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $businessCategories = $businessCategories->whereHas('businessCategoryDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $businessCategories;
    }
}
