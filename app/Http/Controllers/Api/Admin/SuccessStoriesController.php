<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SuccessStoriesResource;
use App\Models\BusinessCategoryDetail;
use App\Models\SuccessStories;
use App\Models\SuccessStoriesDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SuccessStoriesController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $successStories = SuccessStories::query();

        $successStories = $this->whereClause($successStories);
        $successStories = $this->loadRelations($successStories);
        $successStories = $this->sortingAndLimit($successStories);

        return $this->apiSuccessResponse(SuccessStoriesResource::collection($successStories), 'Data Get Successfully!');
    }


    public function show(SuccessStories $successStory)
    {
        if (isset($_GET['withSuccessStoriesDetail']) && $_GET['withSuccessStoriesDetail'] == '1') {
            $successStory = $successStory->loadMissing('successStoriesDetail');
        }

        if (isset($_GET['withBusinessCategory']) && $_GET['withBusinessCategory'] == '1') {
            $successStory = $successStory->loadMissing('businessCategory');
        }

        return $this->apiSuccessResponse(new SuccessStoriesResource($successStory), 'Data Get Successfully!');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $successStorie = SuccessStories::findOrFail($id);
        $successStorie->status = $request->status;
        $successStorie->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Success Stories status updated successfully.',
        ]);
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $validationRule = [
            "business_categories" => "required|array|min:1|max:3",
            "business_categories.*.id" => "required|exists:business_categories,id",
            "business_categories.*.category_name" => "required|string",
        ];
        $niceNames = ['business_category_id' => 'Business category'];

        foreach ($languages as $language) {
            $requiredVal = $language->is_default == '1' ? 'required' : 'nullable';
            $validationRule['name.name_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['name.name_' . $language->id . '.required'] = 'Name in ' . $language->name . ' is required.';

            $validationRule['company_name.company_name_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['company_name.company_name_' . $language->id . '.required'] = 'Company name in ' . $language->name . ' is required.';

            $validationRule['message.message_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['message.message_' . $language->id . '.required'] = 'Message in ' . $language->name . ' is required.';

            $validationRule['email.email_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['email.email_' . $language->id . '.required'] = 'Email in ' . $language->name . ' is required.';
        }

        $this->validate($request, $validationRule, $errorMessages, $niceNames);

        $successStorie = SuccessStories::create([
            // 'business_category_id' => $request->business_category_id,

        ]);
        // Process business categories
        $businessCategories = $request->business_categories;
        $primaryIndustry = json_encode($businessCategories);
        foreach ($languages as $language) {
            SuccessStoriesDetail::create([
                'success_stories_id' => $successStorie->id,
                'language_id' => $language->id,
                'name' => $request->name['name_' . $language->id] ?? null,
                'company_name' => $request->company_name['company_name_' . $language->id] ?? null,
                'message' => $request->message['message_' . $language->id] ?? null,
                'email' => $request->email['email_' . $language->id] ?? null,
                'primary_industry' => $primaryIndustry,
            ]);
        }

        if ($successStorie) {
            return $this->apiSuccessResponse(new SuccessStoriesResource($successStorie), 'Success Stories has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, SuccessStories $successStorie)
    {
        $validationRule = [
            "business_categories" => "required|array|min:1|max:3",
            "business_categories.*.id" => "required|exists:business_categories,id",
            "business_categories.*.category_name" => "required|string",
            "id" => "required|exists:success_stories,id",
        ];

        $errorMessages = [];
        $niceNames = ['business_category_id' => 'Business category'];
        $languages = getAllLanguages();

        // Build dynamic rules for multilingual fields
        foreach ($languages as $language) {
            $requiredVal = $language->is_default == '1' ? 'required' : 'nullable';

            $fields = ['name', 'company_name', 'message', 'email'];
            foreach ($fields as $field) {
                $validationRule["$field.$field" . '_' . $language->id] = [$requiredVal, 'string'];
                $errorMessages["$field.$field" . '_' . $language->id . '.required'] = ucfirst($field) . ' in ' . $language->name . ' is required.';
            }
        }

        // Validate the request
        $this->validate($request, $validationRule, $errorMessages, $niceNames);

        // Update the SuccessStories model
        $successStorie->update([
            // 'business_category_id' => $request->business_category_id,
        ]);

        // Process business categories
        $businessCategories = $request->business_categories;
        $primaryIndustry = json_encode($businessCategories);
        $successStorie->touch();

        // Update or create SuccessStoriesDetail for each language
        foreach ($languages as $language) {
            SuccessStoriesDetail::updateOrCreate(
                [
                    'success_stories_id' => $successStorie->id,
                    'language_id' => $language->id,
                ],
                [
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'company_name' => $request['company_name']['company_name_' . $language->id] ?? null,
                    'message' => $request['message']['message_' . $language->id] ?? null,
                    'email' => $request['email']['email_' . $language->id] ?? null,
                    'primary_industry' => $primaryIndustry,
                ]
            );
        }

        // Return success response
        if ($successStorie) {
            return $this->apiSuccessResponse(new SuccessStoriesResource($successStorie), 'Success Story has been updated successfully.');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, SuccessStories $successStory)
    {
        // dd($successStorie);
        if ($successStory->successStoriesDetail()->delete() && $successStory->delete()) {
            return $this->apiSuccessResponse(new SuccessStoriesResource($successStory), 'Success Stories has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($successStories)
    {
        $defaultLang = getDefaultLanguage();
        $successStories = $successStories->with(['successStoriesDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        if (isset($_GET['withSuccessStoriesDetail']) && $_GET['withSuccessStoriesDetail'] == '1') {
            $successStories = $successStories->with('successStoriesDetail');
        }

        return $successStories;
    }
    protected function sortingAndLimit($successStorie)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'success_stories_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $successStorie = $successStorie->addSelect(['success_stories_name' => SuccessStoriesDetail::whereColumn('successStories.id', 'success_stories_details.success_stories_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $successStorie = $successStorie->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $successStorie->paginate($limit);
    }

    protected function whereClause($successStorie)
    {
        $defaultLang = getDefaultLanguage(0);
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $successStorie = $successStorie->whereHas('successStoriesDetail', function ($q) use ($defaultLang) {
                $q->whereLanguageId($defaultLang->id)->where(function ($q1) {
                    $q1->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('company_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
                });
            });
        }
        return $successStorie;
    }
}
