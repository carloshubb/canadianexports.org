<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OneMoreThingResource;
use App\Models\OneMoreThing;
use App\Models\OneMoreThingDetail;
use App\Rules\ValidUrl;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class OneMoreThingController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $oneMoreThings = OneMoreThing::query();

        $oneMoreThings = $this->whereClause($oneMoreThings);
        $oneMoreThings = $this->loadRelations($oneMoreThings);
        $oneMoreThings = $this->sortingAndLimit($oneMoreThings);

        return $this->apiSuccessResponse(OneMoreThingResource::collection($oneMoreThings), 'Data Get Successfully!');
    }


    public function show($oneMoreThingId)
    {
        $oneMoreThing = OneMoreThing::whereId($oneMoreThingId);
        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $oneMoreThing = $oneMoreThing->with('media');
        }
        if (isset($_GET['withOneMoreThingDetail']) && $_GET['withOneMoreThingDetail'] == '1') {
            $oneMoreThing = $oneMoreThing->with('oneMoreThingDetail');
        }

        $oneMoreThing = $oneMoreThing->first();

        return $this->apiSuccessResponse(new OneMoreThingResource($oneMoreThing), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [
            'media_id' => ['nullable', 'string'],
            'url' => ['required', new ValidUrl()],
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);
        if (isset($request->media_id)) {
            $media = json_decode($request->media_id, 1);
            $files = $this->moveFile($media, 'media/one-more-thing', 'one-more-thing');
        }


        $oneMoreThing = OneMoreThing::create([
            'url' => $request->url,
            'media_id' => isset($files, $files[0]) ? $files[0]->id : null,
        ]);

        if ($oneMoreThing) {
            foreach ($languages as $language) {
                OneMoreThingDetail::create([
                    'one_more_thing_id' => $oneMoreThing->id,
                    'language_id' => $language->id,
                    'description' => $request['description']['description_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new OneMoreThingResource($oneMoreThing), 'One more thing has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, OneMoreThing $oneMoreThing)
    {
        $validationRule = [
            'id' => ['required', 'exists:one_more_thing,id'],
            'media_id' => ['nullable'],
            'url' => ['required', new ValidUrl()],
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);

        }

        $this->validate($request, $validationRule, $errorMessages);
        if (isset($request->media_id) && !is_array($request->media_id)) {
            $media = json_decode($request->media_id, 1);
            $files = $this->moveFile($media, 'media/one-more-thing', 'one-more-thing');
        }
        
        OneMoreThing::whereId($request->id)->update([
            'url' => $request->url,
            'media_id' => !isset($request->media_id) ? null : (isset($files, $files[0]) ? $files[0]->id : $oneMoreThing->media_id),
        ]);

        if ($oneMoreThing) {
            foreach ($languages as $language) {
                $oneMoreThingDetail = OneMoreThingDetail::whereOneMoreThingId($oneMoreThing->id)->whereLanguageId($language->id)->exists();
                if ($oneMoreThingDetail) {
                    OneMoreThingDetail::whereOneMoreThingId($oneMoreThing->id)->whereLanguageId($language->id)->update([
                        'description' => $request['description']['description_' . $language->id],
                    ]);
                } else {
                    OneMoreThingDetail::create([
                        'one_more_thing_id' => $oneMoreThing->id,
                        'language_id' => $language->id,
                        'description' => $request['description']['description_' . $language->id],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new OneMoreThingResource($oneMoreThing), 'One more thing has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, OneMoreThing $oneMoreThing)
    {
        if ($oneMoreThing->delete()) {
            return $this->apiSuccessResponse(new OneMoreThingResource($oneMoreThing), 'One more thing has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($oneMoreThings)
    {
        $defaultLang = getDefaultLanguage();
        $oneMoreThings = $oneMoreThings->with(['oneMoreThingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withOneMoreThingDetail']) && $_GET['withOneMoreThingDetail'] == '1') {
            $oneMoreThings = $oneMoreThings->with('oneMoreThingDetail');
        }

        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $oneMoreThings = $oneMoreThings->with('media');
        }
        return $oneMoreThings;
    }

    protected function sortingAndLimit($oneMoreThings)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $oneMoreThings->orderBy('id', 'desc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'detail_description'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $oneMoreThings = $oneMoreThings->addSelect(['detail_description' => OneMoreThingDetail::whereColumn('one_more_thing.id', 'one_more_thing_detail.one_more_thing_id')->whereLanguageId($defaultLang->id)->select('description')->limit(1)]);

            $oneMoreThings = $oneMoreThings->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $oneMoreThings->paginate($limit);
    }

    protected function whereClause($oneMoreThings)
    {
        $defaultLang = getDefaultLanguage(0);
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $oneMoreThings = $oneMoreThings->whereHas('oneMoreThingDetail', function ($q) use ($defaultLang) {
                $q->whereLanguageId($defaultLang->id)->where(function ($q1) {
                    $q1->where('description', 'LIKE', '%' . $_GET['searchParam'] . '%');
                });
            });
        }
        return $oneMoreThings;
    }
}
