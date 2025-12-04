<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FinancingProgramResource;
use App\Mail\FinancingProgramListMail;
use App\Models\BusinessCategoryDetail;
use App\Models\FinancingProgram;
use App\Models\CustomerProfile;
use App\Models\FinancingProgramDetail;
use App\Traits\FileUploadTrait;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FinancingProgramController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function sendEmail()
    {
        // Fetch the list of financing programs
        $financingPrograms = FinancingProgram::with('financingProgramDetail')->get();

        // Fetch the list of featured and premium exporters
        $featuredExporters = CustomerProfile::whereHas('customer', function ($q) {
            $q->where('is_active', 1)
              ->where('is_package_amount_paid', 1)
              ->where('package_expiry_date', '>=', date('Y-m-d'))
              ->where('type', 'customer');
        })->whereHas('customer.registrationPackage', function ($q) {
            $q->whereIn('registration_packages.package_type', ['featured', 'premium']) // Use whereIn for multiple values
              ->where('registration_packages.type', 'profile');
        })->with('customer')->get();

        // Send the email to each featured and premium exporter
        foreach ($featuredExporters as $exporter) {
            if ($exporter->customer && $exporter->customer->email) {
                Mail::to($exporter->customer->email)->send(new FinancingProgramListMail($financingPrograms));
            }
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'Email sent successfully to featured and premium exporters.',
        ]);
    }
  public function index()
    {
        $financingPrograms = FinancingProgram::query();

        $financingPrograms = $this->whereClause($financingPrograms);
        $financingPrograms = $this->loadRelations($financingPrograms);
        $financingPrograms = $this->sortingAndLimit($financingPrograms);

        return $this->apiSuccessResponse(FinancingProgramResource::collection($financingPrograms), 'Data Get Successfully!');
    }


    public function show(FinancingProgram $financingProgram)
    {
        if (isset($_GET['withFinancingProgramDetail']) && $_GET['withFinancingProgramDetail'] == '1') {
            $financingProgram = $financingProgram->loadMissing('financingProgramDetail');
        }

        if (isset($_GET['withBusinessCategory']) && $_GET['withBusinessCategory'] == '1') {
            $financingProgram = $financingProgram->loadMissing('businessCategory');
        }

        return $this->apiSuccessResponse(new FinancingProgramResource($financingProgram), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();

        // Validation rules for business categories
        $validationRule = [
            "business_categories" => "required|array|min:1|max:3",
            "business_categories.*.id" => "required|exists:business_categories,id",
            "business_categories.*.category_name" => "required|string",
        ];

        // Add validation rules for other fields
        foreach ($languages as $language) {
            $requiredVal = $language->is_default == '1' ? 'required' : 'nullable';
            $validationRule = array_merge($validationRule, [
                'name_title.name_title_' . $language->id => [$requiredVal, 'string'],
                'email.email_' . $language->id => [$requiredVal, 'string'],
                'business_name.business_name_' . $language->id => [$requiredVal, 'string'],
                'zipcode.zipcode_' . $language->id => [$requiredVal, 'string'],
                'incorporation.incorporation_' . $language->id => [$requiredVal, 'string'],
                'full_time_employees.full_time_employees_' . $language->id => [$requiredVal, 'string'],
                'revenue_last_year.revenue_last_year_' . $language->id => [$requiredVal, 'string'],
                'company_ownership.company_ownership_' . $language->id => [$requiredVal, 'string'],
                'needs_intentions.needs_intentions_' . $language->id => [$requiredVal, 'string'],
            ]);
        }

        $this->validate($request, $validationRule, $errorMessages);

        // Create the financing program
        $financingProgram = FinancingProgram::create();

        // Save the financing program details
        foreach ($languages as $language) {
            FinancingProgramDetail::create([
                'financing_program_id' => $financingProgram->id,
                'language_id' => $language->id,
                'name_title' => $request['name_title']['name_title_' . $language->id] ?? '',
                'email' => $request['email']['email_' . $language->id] ?? '',
                'business_name' => $request['business_name']['business_name_' . $language->id] ?? '',
                'zipcode' => $request['zipcode']['zipcode_' . $language->id] ?? '',
                'incorporation' => $request['incorporation']['incorporation_' . $language->id] ?? '',
                'full_time_employees' => $request['full_time_employees']['full_time_employees_' . $language->id] ?? '',
                'revenue_last_year' => $request['revenue_last_year']['revenue_last_year_' . $language->id] ?? '',
                'company_ownership' => $request['company_ownership']['company_ownership_' . $language->id] ?? '',
                'needs_intentions' => $request['needs_intentions']['needs_intentions_' . $language->id] ?? '',
                'primary_industry' => json_encode($request->business_categories), // Store as JSON
            ]);
        }

        return $this->apiSuccessResponse(new FinancingProgramResource($financingProgram), 'Financing Program has been added successfully.');
    }


    public function update(Request $request, FinancingProgram $financingProgram)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();

        // Validation rules for business categories
        $validationRule = [
            "business_categories" => "required|array|min:1|max:3",
            "business_categories.*.id" => "required|exists:business_categories,id",
            "business_categories.*.category_name" => "required|string",
        ];

        // Add validation rules for other fields
        foreach ($languages as $language) {
            $requiredVal = $language->is_default == '1' ? 'required' : 'nullable';
            $validationRule = array_merge($validationRule, [
                'name_title.name_title_' . $language->id => [$requiredVal, 'string'],
                'email.email_' . $language->id => [$requiredVal, 'string'],
                'business_name.business_name_' . $language->id => [$requiredVal, 'string'],
                'zipcode.zipcode_' . $language->id => [$requiredVal, 'string'],
                'incorporation.incorporation_' . $language->id => [$requiredVal, 'string'],
                'full_time_employees.full_time_employees_' . $language->id => [$requiredVal, 'string'],
                'revenue_last_year.revenue_last_year_' . $language->id => [$requiredVal, 'string'],
                'company_ownership.company_ownership_' . $language->id => [$requiredVal, 'string'],
                'needs_intentions.needs_intentions_' . $language->id => [$requiredVal, 'string'],
            ]);
        }

        $this->validate($request, $validationRule, $errorMessages);

        // Update the financing program details
        foreach ($languages as $language) {
            $financingProgramDetail = FinancingProgramDetail::whereLanguageId($language->id)
                ->whereFinancingProgramId($financingProgram->id)
                ->firstOrNew();

            $financingProgramDetail->update([
                'name_title' => $request['name_title']['name_title_' . $language->id] ?? '',
                'email' => $request['email']['email_' . $language->id] ?? '',
                'business_name' => $request['business_name']['business_name_' . $language->id] ?? '',
                'zipcode' => $request['zipcode']['zipcode_' . $language->id] ?? '',
                'incorporation' => $request['incorporation']['incorporation_' . $language->id] ?? '',
                'full_time_employees' => $request['full_time_employees']['full_time_employees_' . $language->id] ?? '',
                'revenue_last_year' => $request['revenue_last_year']['revenue_last_year_' . $language->id] ?? '',
                'company_ownership' => $request['company_ownership']['company_ownership_' . $language->id] ?? '',
                'needs_intentions' => $request['needs_intentions']['needs_intentions_' . $language->id] ?? '',
                'primary_industry' => json_encode($request->business_categories), // Update as JSON
            ]);
        }

        return $this->apiSuccessResponse(new FinancingProgramResource($financingProgram), 'Financing Program has been updated successfully.');
    }


    public function destroy(Request $request, FinancingProgram $financingProgram)
    {
        if ($financingProgram->financingProgramDetail()->delete() && $financingProgram->delete()) {
            return $this->apiSuccessResponse(new FinancingProgramResource($financingProgram), 'Financing Program has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($financingProgram)
    {
        $defaultLang = getDefaultLanguage();
        $financingProgram = $financingProgram->with(['financingProgramDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        if (isset($_GET['withFinancingProgramDetail']) && $_GET['withFinancingProgramDetail'] == '1') {
            $financingProgram = $financingProgram->with('financingProgramDetail');
        }

        // Ensure the column name is correct (e.g., 'name' should be the correct column name)
        $financingProgram = $financingProgram->addSelect([
            'business_category_name' => BusinessCategoryDetail::whereColumn('financing_programs.business_category_id', 'business_category_detail.business_category_id')
                ->whereLanguageId($defaultLang->id)
                ->select('name') // Ensure this is the correct column name
                ->limit(1)
        ]);

        return $financingProgram;
    }

    protected function sortingAndLimit($financingProgram)
{
    $sortType = ['ASC', 'asc', 'DESC', 'desc'];
    $sortBy = ['id', 'financingProgram_name_title'];

    if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
        $defaultLang = getDefaultLanguage();

        // Correct the table name to 'financing_programs'
        $financingProgram = $financingProgram->addSelect([
            'financingProgram_name_title' => FinancingProgramDetail::whereColumn('financing_programs.id', 'financing_program_details.financing_program_id')
                ->whereLanguageId($defaultLang->id)
                ->select('name_title') // Ensure this is the correct column name
                ->limit(1)
        ]);

        $financingProgram = $financingProgram->orderBy($_GET['sortBy'], $_GET['sortType']);
    }

    $limit = isset($_GET['limit']) && $_GET['limit'] != '' ? $_GET['limit'] : 10;

    return $financingProgram->paginate($limit);
}

    protected function whereClause($financingProgram)
    {
        $defaultLang = getDefaultLanguage(0);
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $financingProgram = $financingProgram->whereHas('financingProgramDetail', function ($q) use ($defaultLang) {
                $q->whereLanguageId($defaultLang->id)->where(function ($q1) {
                    $q1->where('name_title', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('business_name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email', 'LIKE', '%' . $_GET['searchParam'] . '%');
                });
            });
        }
        return $financingProgram;
    }
}