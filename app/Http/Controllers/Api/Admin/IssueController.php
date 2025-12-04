<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\IssueResource;
use App\Models\Issue;
use App\Models\IssueDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $issues = Issue::query();

        $issues = $this->whereClause($issues);
        $issues = $this->loadRelations($issues);
        $issues = $this->sortingAndLimit($issues);

        return $this->apiSuccessResponse(IssueResource::collection($issues), 'Data Get Successfully!');
    }


    public function show(Issue $issue)
    {
        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $issue = $issue->loadMissing('media');
        }
        if (isset($_GET['withIssueDetail']) && $_GET['withIssueDetail'] == '1') {
            $issue = $issue->loadMissing('issueDetail');
        }

        return $this->apiSuccessResponse(new IssueResource($issue), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [
            'is_current_issue' => ['required', 'boolean'],
            'media_id' => ['required', 'string'],
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);

        if (isset($request->media_id)) {
            $media = json_decode($request->media_id, 1);
            $files = $this->moveFile($media, 'media/issues', 'issues');
        }
        $issue = Issue::create([
            'is_current_issue' => $request->is_current_issue,
            'pdf' => $request->pdf,
            'media_id' => isset($files, $files[0]) ? $files[0]->id : null,
        ]);

        if ($issue) {
            foreach ($languages as $language) {
                IssueDetail::create([
                    'issue_id' => $issue->id,
                    'language_id' => $language->id,
                    'title' => $request['title']['title_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new IssueResource($issue), 'Issue has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Issue $issue)
    {
        $validationRule = [
            'is_current_issue' => ['required', 'boolean'],
            'media_id' => ['nullable'],
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);

        if (isset($request->media_id)) {
            $media = json_decode($request->media_id, 1);
            $files = $this->moveFile($media, 'media/issues', 'issues');
        }
        Issue::whereId($request->id)->update([
            'is_current_issue' => $request->is_current_issue,
            'pdf' => $request->pdf,
            'media_id' => isset($files, $files[0]) ? $files[0]->id : $issue->media_id,
        ]);

        if ($issue) {
            foreach ($languages as $language) {
                $issueDetail = IssueDetail::whereIssueId($issue->id)->whereLanguageId($language->id)->exists();
                if ($issueDetail) {
                    IssueDetail::whereIssueId($issue->id)->whereLanguageId($language->id)->update([
                        'title' => $request['title']['title_' . $language->id],
                    ]);
                } else {
                    IssueDetail::create([
                        'issue_id' => $issue->id,
                        'language_id' => $language->id,
                        'title' => $request['title']['title_' . $language->id],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new IssueResource($issue), 'Issue has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, Issue $issue)
    {
        if ($issue->delete()) {
            return $this->apiSuccessResponse(new IssueResource($issue), 'Issue has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($issues)
    {
        $defaultLang = getDefaultLanguage();
        $issues = $issues->with(['issueDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withIssueDetail']) && $_GET['withIssueDetail'] == '1') {
            $issues = $issues->with('issueDetail');
        }

        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $issues = $issues->with('media');
        }
        return $issues;
    }

    protected function sortingAndLimit($issues)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $issues->orderBy('is_default', 'desc')->orderBy('name', 'asc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'native_name', 'issue_title'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $issues = $issues->addSelect(['issue_title' => IssueDetail::whereColumn('issues.id', 'issue_detail.issue_id')->whereLanguageId($defaultLang->id)->select('title')->limit(1)]);

            $issues = $issues->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $issues->paginate($limit);
    }

    protected function whereClause($issues)
    {
        $defaultLang = getDefaultLanguage(0);
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $issues = $issues->whereHas('issueDetail', function ($q) use ($defaultLang) {
                $q->whereLanguageId($defaultLang->id)->where(function ($q1) {
                    $q1->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
                });
            });
        }
        return $issues;
    }
}
