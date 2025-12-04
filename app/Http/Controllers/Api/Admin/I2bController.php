<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\I2bResource;
use App\Imports\I2bImport;
use App\Models\BusinessCategoryDetail;
use App\Models\I2b;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\I2bDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class I2bController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $i2b = I2b::query();

        $i2b = $this->whereClause($i2b);
        $i2b = $this->loadRelations($i2b);
        $i2b = $this->sortingAndLimit($i2b);

        return $this->apiSuccessResponse(I2bResource::collection($i2b), 'Data Get Successfully!');
    }


    public function show(I2b $i2b)
    {
        if (isset($_GET['withI2bDetail']) && $_GET['withI2bDetail'] == '1') {
            $i2b = $i2b->loadMissing('i2bDetail');
        }

        if (isset($_GET['withBusinessCategory']) && $_GET['withBusinessCategory'] == '1') {
            $i2b = $i2b->loadMissing('businessCategory');
        }

        return $this->apiSuccessResponse(new I2bResource($i2b), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $validationRule = ['deadline_date' => ['required', 'date']];
        $validationRule = array_merge($validationRule, ['estimated_value' => ['required', 'regex:/^\d+(\.\d{1,2})?$/']]);
        $validationRule = array_merge($validationRule, ['pdf_1' => ['nullable', 'string']]);
        $validationRule = array_merge($validationRule, ['pdf_2' => ['nullable', 'string']]);
        $validationRule = array_merge($validationRule, ['pdf_3' => ['nullable', 'string']]);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'email']]);
        // $validationRule = array_merge($validationRule, ['business_category_id' => ['required', 'exists:business_categories,id']]);
        // $validationRule = array_merge($validationRule, ['business_category_id_2' => ['nullable', 'exists:business_categories,id']]);
        // $validationRule = array_merge($validationRule, ['business_category_id_3' => ['nullable', 'exists:business_categories,id']]);
        $validationRule = array_merge($validationRule, [
            'business_category_id' => ['required', 'exists:business_categories,id', function($attribute, $value, $fail) use ($request) {
                if ($value == $request->business_category_id_2 || $value == $request->business_category_id_3) {
                    $fail('The business category 1 cannot be the same as business category 2 or business category 3.');
                }
            }],
            'business_category_id_2' => ['nullable', 'exists:business_categories,id', function($attribute, $value, $fail) use ($request) {
                if ($value == $request->business_category_id || $value == $request->business_category_id_3) {
                    $fail('The business category 2 cannot be the same as business category 1 or business category 3.');
                }
            }],
            'business_category_id_3' => ['nullable', 'exists:business_categories,id', function($attribute, $value, $fail) use ($request) {
                if ($value == $request->business_category_id || $value == $request->business_category_id_2) {
                    $fail('The business category 3 cannot be the same as business category 1 or business category 2.');
                }
            }],
        ]);

        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_name.country_name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_name.country_name_' . $language->id . '.required' => 'Country name in ' . $language->name . ' is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $i2b = I2b::create([
            'business_category_id' => $request->business_category_id,
            'business_category_id_2' => $request->business_category_id_2,
            'business_category_id_3' => $request->business_category_id_3,
            'deadline_date' => date('Y-m-d', strtotime($request->deadline_date)),
            'estimated_value' => $request->estimated_value,
            'pdf_1' => $request->pdf_1,
            'pdf_2' => $request->pdf_2,
            'pdf_3' => $request->pdf_3,
            'email' => $request->email,
        ]);
        foreach ($languages as $language) {
            I2bDetail::create([
                'i2b_id' => $i2b->id,
                'language_id' => $language->id,
                'name' => $request['name']['name_' . $language->id],
                'country_name' => $request['country_name']['country_name_' . $language->id],
            ]);
        }

        if ($i2b) {
            return $this->apiSuccessResponse(new I2bResource($i2b), 'Inquiry has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, I2b $i2b)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $validationRule = ['deadline_date' => ['required', 'date']];
        $validationRule = array_merge($validationRule, ['estimated_value' => ['required', 'regex:/^\d+(\.\d{1,2})?$/']]);
        $validationRule = array_merge($validationRule, ['pdf_1' => ['nullable', 'string']]);
        $validationRule = array_merge($validationRule, ['pdf_2' => ['nullable', 'string']]);
        $validationRule = array_merge($validationRule, ['pdf_3' => ['nullable', 'string']]);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'email']]);
        // $validationRule = array_merge($validationRule, ['business_category_id' => ['required', 'exists:business_categories,id']]);
        // $validationRule = array_merge($validationRule, ['business_category_id_2' => ['nullable', 'exists:business_categories,id']]);
        // $validationRule = array_merge($validationRule, ['business_category_id_3' => ['nullable', 'exists:business_categories,id']]);
        $validationRule = array_merge($validationRule, [
            'business_category_id' => [
                'required',
                'exists:business_categories,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value == $request->business_category_id_2 || $value == $request->business_category_id_3) {
                        $fail('The business category 1 cannot be the same as category 2 or 3.');
                    }
                }
            ],
            'business_category_id_2' => [
                'nullable',
                'exists:business_categories,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value == $request->business_category_id || $value == $request->business_category_id_3) {
                        $fail('The business category 2 cannot be the same as category 1 or 3.');
                    }
                }
            ],
            'business_category_id_3' => [
                'nullable',
                'exists:business_categories,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value == $request->business_category_id || $value == $request->business_category_id_2) {
                        $fail('The business category 3 cannot be the same as category 1 or 2.');
                    }
                }
            ]
        ]);

        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_name.country_name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_name.country_name_' . $language->id . '.required' => 'Country name in ' . $language->name . ' is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $i2b->update([
            'business_category_id' => $request->business_category_id,
            'business_category_id_2' => $request->business_category_id_2,
            'business_category_id_3' => $request->business_category_id_3,
            'deadline_date' => date('Y-m-d', strtotime($request->deadline_date)),
            'estimated_value' => $request->estimated_value,
            'pdf_1' => $request->pdf_1,
            'pdf_2' => $request->pdf_2,
            'pdf_3' => $request->pdf_3,
            'email' => $request->email,
        ]);
        foreach ($languages as $language) {
            $i2bDetail = I2bDetail::whereLanguageId($language->id)->whereI2bId($i2b->id)->exists();
            if ($i2bDetail) {
                I2bDetail::whereLanguageId($language->id)->whereI2bId($i2b->id)->update([
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'country_name' => $request['country_name']['country_name_' . $language->id] ?? null,
                ]);
            } else {
                I2bDetail::create([
                    'i2b_id' => $i2b->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'country_name' => $request['country_name']['country_name_' . $language->id] ?? null,
                ]);
            }
        }

        if ($i2b) {
            return $this->apiSuccessResponse(new I2bResource($i2b), 'Inquiry has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, I2b $i2b)
    {
        if ($i2b->i2bDetail()->delete() && $i2b->delete()) {
            return $this->apiSuccessResponse(new I2bResource($i2b), 'Inquiry has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($i2b)
    {
        $defaultLang = getDefaultLanguage();
        $i2b = $i2b->with(['i2bDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withI2bDetail']) && $_GET['withI2bDetail'] == '1') {
            $i2b = $i2b->with('i2bDetail');
        }
        $i2b = $i2b->addSelect(['business_category_name' => BusinessCategoryDetail::whereColumn('i2b.business_category_id', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

        $i2b = $i2b->addSelect(['business_category_name_2' => BusinessCategoryDetail::whereColumn('i2b.business_category_id_2', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

        $i2b = $i2b->addSelect(['business_category_name_3' => BusinessCategoryDetail::whereColumn('i2b.business_category_id_3', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);
        return $i2b;
    }

    protected function sortingAndLimit($i2b)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'deadline_date', 'estimated_value', 'i2b_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $i2b = $i2b->addSelect(['i2b_name' => I2bDetail::whereColumn('i2b.id', 'i2b_detail.i2b_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $i2b = $i2b->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $i2b->paginate($limit);
    }

    protected function whereClause($i2b)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $i2b = $i2b->whereHas('i2bDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $i2b;
    }

    function importI2b(Request $request)
    {
        $validationRule = ['import_file' => 'required'];
        $this->validate(
            $request,
            $validationRule
        );

        Excel::import(new I2bImport, public_path($request->import_file));

        return $this->successResponse([], 'Inquiries has been imported successfully!');
    }
}
