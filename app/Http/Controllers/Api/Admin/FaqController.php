<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FaqResource;
use App\Models\Faq;
use App\Models\FaqDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $faqs = Faq::query();

        $faqs = $this->whereClause($faqs);
        $faqs = $this->loadRelations($faqs);
        $faqs = $this->sortingAndLimit($faqs);

        return $this->apiSuccessResponse(FaqResource::collection($faqs), 'Data Get Successfully!');
    }


    public function show(Faq $faq)
    {
        if (isset($_GET['withFaqDetail']) && $_GET['withFaqDetail'] == '1') {
            $faq = $faq->loadMissing('faqDetail');
        }

        return $this->apiSuccessResponse(new FaqResource($faq), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $validationRule['type'] = ['required', 'in:importer,exporter'];
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['question.question_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['question.question_' . $language->id . '.required' => 'Question in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['answer.answer_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['answer.answer_' . $language->id . '.required' => 'Answer in ' . $language->name . ' is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $faq = Faq::create([
            'type' => $request->type ?? null
        ]);
        foreach ($languages as $language) {
            FaqDetail::create([
                'faq_id' => $faq->id,
                'language_id' => $language->id,
                'question' => $request['question']['question_' . $language->id],
                'answer' => $request['answer']['answer_' . $language->id],
            ]);
        }

        if ($faq) {
            return $this->apiSuccessResponse(new FaqResource($faq), 'Faq has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Faq $faq)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $validationRule = array_merge(
            $validationRule,
            [
                'id' => ['required', 'exists:faq,id'],
                'type' => ['required', 'in:importer,exporter'],
            ]
        );
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['question.question_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['question.question_' . $language->id . '.required' => 'Question in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['answer.answer_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['answer.answer_' . $language->id . '.required' => 'Answer in ' . $language->name . ' is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $faq->update([
            'type' => $request->type ?? null
        ]);
        foreach ($languages as $language) {
            $faqDetail = FaqDetail::whereLanguageId($language->id)->whereFaqId($faq->id)->exists();
            if ($faqDetail) {
                FaqDetail::whereLanguageId($language->id)->whereFaqId($faq->id)->update([
                    'question' => $request['question']['question_' . $language->id] ?? null,
                    'answer' => $request['answer']['answer_' . $language->id] ?? null,
                ]);
            } else {
                FaqDetail::create([
                    'faq_id' => $faq->id,
                    'language_id' => $language->id,
                    'question' => $request['question']['question_' . $language->id] ?? null,
                    'answer' => $request['answer']['answer_' . $language->id] ?? null,
                ]);
            }
        }

        if ($faq) {
            return $this->apiSuccessResponse(new FaqResource($faq), 'Faq has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, Faq $faq)
    {
        if ($faq->faqDetail()->delete() && $faq->delete()) {
            return $this->apiSuccessResponse(new FaqResource($faq), 'Faq has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($faq)
    {
        $defaultLang = getDefaultLanguage();
        $faq = $faq->with(['faqDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withFaqDetail']) && $_GET['withFaqDetail'] == '1') {
            $faq = $faq->with('faqDetail');
        }
        return $faq;
    }

    protected function sortingAndLimit($faq)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'faq_question'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $faq = $faq->addSelect(['faq_question' => FaqDetail::whereColumn('faq.id', 'faq_detail.faq_id')->whereLanguageId($defaultLang->id)->select('question')->limit(1)]);

            $faq = $faq->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $faq->paginate($limit);
    }

    protected function whereClause($faq)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $faq = $faq->whereHas('faqDetail', function ($q) {
                $q->where('id', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $faq;
    }
}
