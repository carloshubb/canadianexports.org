<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TestimonialResource;
use App\Models\BusinessCategoryDetail;
use App\Models\Testimonial;
use App\Models\TestimonialDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $testimonials = Testimonial::query();

        $testimonials = $this->whereClause($testimonials);
        $testimonials = $this->loadRelations($testimonials);
        $testimonials = $this->sortingAndLimit($testimonials);

        return $this->apiSuccessResponse(TestimonialResource::collection($testimonials), 'Data Get Successfully!');
    }


    public function show(Testimonial $testimonial)
    {
        if (isset($_GET['withTestimonialDetail']) && $_GET['withTestimonialDetail'] == '1') {
            $testimonial = $testimonial->loadMissing('testimonialDetail');
        }

        if (isset($_GET['withBusinessCategory']) && $_GET['withBusinessCategory'] == '1') {
            $testimonial = $testimonial->loadMissing('businessCategory');
        }

        return $this->apiSuccessResponse(new TestimonialResource($testimonial), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $languages = getAllLanguages();

        $validationRule = [
            "business_categories" => "required|array|min:1|max:3",
            "business_categories.*.id" => "required|exists:business_categories,id",
            "business_categories.*.category_name" => "required|string",
        ];

        $niceNames = ['business_category_id' => 'Business category'];
        $errorMessages = [];

        foreach ($languages as $language) {
            $requiredVal = $language->is_default == '1' ? 'required' : 'nullable';
            $validationRule = array_merge($validationRule, [
                "name.name_{$language->id}" => [$requiredVal, 'string'],
                "email.email_{$language->id}" => [$requiredVal, 'email'],
                "place.place_{$language->id}" => [$requiredVal, 'string'],
                "comment.comment_{$language->id}" => [$requiredVal, 'string'],
            ]);

            $errorMessages = array_merge($errorMessages, [
                "name.name_{$language->id}.required" => "Name in {$language->name} is required.",
                "email.email_{$language->id}.required" => "Email in {$language->name} is required.",
                "place.place_{$language->id}.required" => "Company name in {$language->name} is required.",
                "comment.comment_{$language->id}.required" => "Comment in {$language->name} is required.",
            ]);
        }

        $this->validate($request, $validationRule, $errorMessages, $niceNames);

        // Create the testimonial
        $testimonial = Testimonial::create([
            // 'business_category_id' => $request->business_category_id,
        ]);

        // Process business categories
        $businessCategories = $request->business_categories;
        $primaryIndustry = json_encode($businessCategories);

        // Create testimonial details for each language
        foreach ($languages as $language) {
            TestimonialDetail::create([
                'testimonial_id' => $testimonial->id,
                'language_id' => $language->id,
                'name' => $request['name']['name_' . $language->id],
                'email' => $request['email']['email_' . $language->id],
                'place' => $request['place']['place_' . $language->id],
                'comment' => $request['comment']['comment_' . $language->id],
                'primary_industry' => $primaryIndustry, // Store as JSON
            ]);
        }

        if ($testimonial) {
            return $this->apiSuccessResponse(new TestimonialResource($testimonial), 'Testimonial has been added successfully.');
        }

        return $this->errorResponse();
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->status = $request->status;
        $testimonial->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Testimonial status updated successfully.',
        ]);
    }
    public function update(Request $request, Testimonial $testimonial)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();

        // Validation rules for business_categories
        $validationRule = [
            "business_categories" => "required|array|min:1|max:3",
            "business_categories.*.id" => "required|exists:business_categories,id",
            "business_categories.*.category_name" => "required|string",
        ];

        // Validation rules for testimonial ID
        $validationRule = array_merge($validationRule, ['id' => ['required', 'exists:testimonials,id']]);

        // Validation rules for language-specific fields
        foreach ($languages as $language) {
            $requiredVal = $language->is_default == '1' ? 'required' : 'nullable';
            $validationRule = array_merge($validationRule, [
                "name.name_{$language->id}" => [$requiredVal, 'string'],
                "email.email_{$language->id}" => [$requiredVal, 'string'],
                "place.place_{$language->id}" => [$requiredVal, 'string'],
                "comment.comment_{$language->id}" => [$requiredVal, 'string'],
            ]);

            $errorMessages = array_merge($errorMessages, [
                "name.name_{$language->id}.required" => "Name in {$language->name} is required.",
                "email.email_{$language->id}.required" => "Email in {$language->name} is required.",
                "place.place_{$language->id}.required" => "Place in {$language->name} is required.",
                "comment.comment_{$language->id}.required" => "Comment in {$language->name} is required.",
            ]);
        }

        // Validate the request
        $this->validate($request, $validationRule, $errorMessages, ['business_category_id' => 'Business category']);

        // Update the testimonial
        $testimonial->update([
            // 'business_category_id' => $request->business_category_id,
        ]);

        // Process business categories
        $businessCategories = $request->business_categories;
        $primaryIndustry = json_encode($businessCategories);

        // Update or create testimonial details for each language
        foreach ($languages as $language) {
            $testimonialDetail = TestimonialDetail::where('language_id', $language->id)
                ->where('testimonial_id', $testimonial->id)
                ->first();

            if ($testimonialDetail) {
                // Update existing testimonial detail
                $testimonialDetail->update([
                    'name' => $request['name']['name_' . $language->id] ?? '',
                    'place' => $request['place']['place_' . $language->id] ?? '',
                    'comment' => $request['comment']['comment_' . $language->id] ?? '',
                    'email' => $request['email']['email_' . $language->id] ?? '',
                    'primary_industry' => $primaryIndustry, // Update primary_industry
                ]);
            } else {
                // Create new testimonial detail
                TestimonialDetail::create([
                    'testimonial_id' => $testimonial->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? '',
                    'place' => $request['place']['place_' . $language->id] ?? '',
                    'comment' => $request['comment']['comment_' . $language->id] ?? '',
                    'email' => $request['email']['email_' . $language->id] ?? '',
                    'primary_industry' => $primaryIndustry, // Store primary_industry
                ]);
            }
        }

        if ($testimonial) {
            return $this->apiSuccessResponse(new TestimonialResource($testimonial), 'Testimonial has been updated successfully.');
        }

        return $this->errorResponse();
    }


    public function destroy(Request $request, Testimonial $testimonial)
    {
        if ($testimonial->testimonialDetail()->delete() && $testimonial->delete()) {
            return $this->apiSuccessResponse(new TestimonialResource($testimonial), 'Testimonial has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($testimonial)
    {
        $defaultLang = getDefaultLanguage();
        $testimonial = $testimonial->with(['testimonialDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withTestimonialDetail']) && $_GET['withTestimonialDetail'] == '1') {
            $testimonial = $testimonial->with('testimonialDetail');
        }
        $testimonial = $testimonial->addSelect(['business_category_name' => BusinessCategoryDetail::whereColumn('testimonials.business_category_id', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);
        return $testimonial;
    }

    protected function sortingAndLimit($testimonial)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'testimonial_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $testimonial = $testimonial->addSelect(['testimonial_name' => TestimonialDetail::whereColumn('testimonials.id', 'testimonial_detail.testimonial_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $testimonial = $testimonial->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $testimonial->paginate($limit);
    }

    protected function whereClause($testimonial)
    {
        $defaultLang = getDefaultLanguage(0);
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $testimonial = $testimonial->whereHas('testimonialDetail', function ($q) use ($defaultLang) {
                $q->whereLanguageId($defaultLang->id)->where(function ($q1) {
                    $q1->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email', 'LIKE', '%' . $_GET['searchParam'] . '%');
                });
            });
        }
        return $testimonial;
    }
}
