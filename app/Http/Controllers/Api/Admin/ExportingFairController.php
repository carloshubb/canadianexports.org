<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ExportingFairResource;
use App\Models\ExportingFair;
use App\Models\ExportingFairDetail;
use App\Rules\ValidUrl;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ExportingFairController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $exportingFairs = ExportingFair::query();

        $exportingFairs = $this->whereClause($exportingFairs);
        $exportingFairs = $this->loadRelations($exportingFairs);
        $exportingFairs = $this->sortingAndLimit($exportingFairs);

        return $this->apiSuccessResponse(ExportingFairResource::collection($exportingFairs), 'Data Get Successfully!');
    }


    public function show(ExportingFair $exportingFair)
    {
        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $exportingFair = $exportingFair->loadMissing('media');
        }
        if (isset($_GET['withExportingFairDetail']) && $_GET['withExportingFairDetail'] == '1') {
            $exportingFair = $exportingFair->loadMissing('exportingFairDetail');
        }
        return $this->apiSuccessResponse(new ExportingFairResource($exportingFair), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [
            'zipcode' => ['nullable'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'booth_number' => ['required', 'string', 'max:255'],
            'event_website' => ['required', new ValidUrl()],
            'exibitors_url' => ['nullable', new ValidUrl()],
            'visitors_url' => ['nullable', new ValidUrl()],
            'press_url' => ['nullable', new ValidUrl()],
            'video_url' => ['nullable', new ValidUrl()],
            'contact_name' => ['required', 'string'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string'],
            'contact_designation' => ['required', 'string'],
            'facebook_url' => ['nullable', new ValidUrl()],
            'twitter_url' => ['nullable', new ValidUrl()],
            'linkedin_url' => ['nullable', new ValidUrl()],
            'youtube_url' => ['nullable', new ValidUrl()],
            'pintrest_url' => ['nullable', new ValidUrl()],
            'instagram_url' => ['nullable', new ValidUrl()],
            'snapchat_url' => ['nullable', new ValidUrl()],
            'media_id' => ['required', 'string']
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country.country_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['country.country_' . $language->id . '.required' => 'Country in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['city.city_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['city.city_' . $language->id . '.required' => 'City in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['street_name.street_name_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['street_name.street_name_' . $language->id . '.required' => 'Street name and number in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['address.address_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['address.address_' . $language->id . '.required' => 'Address in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['product_search.product_search_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['product_search.product_search_' . $language->id . '.required' => 'Product search in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'Short description in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.maxwords' => 'Short description in ' . $language->name . ' must have less than 30 words.']);

            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => ['nullable', 'string', 'maxwords:3000']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.maxwords' => 'Description in ' . $language->name . ' must have less than 3000 words.']);
        }

        $this->validate($request, $validationRule, $errorMessages);
        $media = json_decode($request->media_id, 1);
        $files = $this->moveFile($media, 'media/exporting-fairs', 'exporting-fairs');


        $exportingFair = ExportingFair::create([
            'zipcode' => $request->zipcode,
            'media_id' => isset($files, $files[0]) ? $files[0]->id : null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'booth_number' => $request->booth_number,
            'event_website' => $request->event_website,
            'exibitors_url' => $request->exibitors_url,
            'visitors_url' => $request->visitors_url,
            'press_url' => $request->press_url,
            'video_url' => $request->video_url,
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_designation' => $request->contact_designation,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'linkedin_url' => $request->linkedin_url,
            'youtube_url' => $request->youtube_url,
            'pintrest_url' => $request->pintrest_url,
            'instagram_url' => $request->instagram_url,
            'snapchat_url' => $request->snapchat_url,
        ]);

        if ($exportingFair) {
            foreach ($languages as $language) {
                ExportingFairDetail::create([
                    'exporting_fair_id' => $exportingFair->id,
                    'language_id' => $language->id,
                    'title' => $request['title']['title_' . $language->id],
                    'country' => $request['country']['country_' . $language->id],
                    'city' => $request['city']['city_' . $language->id],
                    'street_name' => $request['street_name']['street_name_' . $language->id],
                    'address' => $request['address']['address_' . $language->id] ?? null,
                    'product_search' => $request['product_search']['product_search_' . $language->id],
                    'short_description' => $request['short_description']['short_description_' . $language->id],
                    'description' => $request['description']['description_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new ExportingFairResource($exportingFair), 'Exporting fair has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, ExportingFair $exportingFair)
    {
        $validationRule = [
            'id' => ['required', 'exists:exporting_fairs,id'],
            'zipcode' => ['nullable'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'booth_number' => ['required', 'string', 'max:255'],
            'event_website' => ['required', new ValidUrl()],
            'exibitors_url' => ['nullable', new ValidUrl()],
            'visitors_url' => ['nullable', new ValidUrl()],
            'press_url' => ['nullable', new ValidUrl()],
            'video_url' => ['nullable', new ValidUrl()],
            'contact_name' => ['required', 'string'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string'],
            'contact_designation' => ['required', 'string'],
            'facebook_url' => ['nullable', new ValidUrl()],
            'twitter_url' => ['nullable', new ValidUrl()],
            'linkedin_url' => ['nullable', new ValidUrl()],
            'youtube_url' => ['nullable', new ValidUrl()],
            'pintrest_url' => ['nullable', new ValidUrl()],
            'instagram_url' => ['nullable', new ValidUrl()],
            'snapchat_url' => ['nullable', new ValidUrl()],
            'media_id' => ['nullable']
        ];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if($language->is_default == '1'){
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country.country_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['country.country_' . $language->id . '.required' => 'Country in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['city.city_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['city.city_' . $language->id . '.required' => 'City in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['street_name.street_name_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['street_name.street_name_' . $language->id . '.required' => 'Street name and number in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['address.address_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['address.address_' . $language->id . '.required' => 'Address in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['product_search.product_search_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['product_search.product_search_' . $language->id . '.required' => 'Product search in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'Short description in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.maxwords' => 'Short description in ' . $language->name . ' must have less than 30 words.']);

            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => ['nullable', 'string', 'maxwords:3000']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.maxwords' => 'Description in ' . $language->name . ' must have less than 3000 words.']);
        }

        $this->validate($request, $validationRule, $errorMessages);
        
        if (isset($request->media_id) && !is_array($request->media_id)) {
            $media = json_decode($request->media_id, 1);
            $files = $this->moveFile($media, 'media/exporting-fairs', 'exporting-fairs');
        }

        ExportingFair::whereId($request->id)->update([
            'zipcode' => $request->zipcode,
            'media_id' => !isset($request->media_id) ? null : (isset($files, $files[0]) ? $files[0]->id : $exportingFair->media_id),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'booth_number' => $request->booth_number,
            'event_website' => $request->event_website,
            'exibitors_url' => $request->exibitors_url,
            'visitors_url' => $request->visitors_url,
            'press_url' => $request->press_url,
            'video_url' => $request->video_url,
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_designation' => $request->contact_designation,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'linkedin_url' => $request->linkedin_url,
            'youtube_url' => $request->youtube_url,
            'pintrest_url' => $request->pintrest_url,
            'instagram_url' => $request->instagram_url,
            'snapchat_url' => $request->snapchat_url,
        ]);

        if ($exportingFair) {
            foreach ($languages as $language) {
                $exportingFairDetail = ExportingFairDetail::whereExportingFairId($exportingFair->id)->whereLanguageId($language->id)->exists();
                if ($exportingFairDetail) {
                    ExportingFairDetail::whereExportingFairId($exportingFair->id)->whereLanguageId($language->id)->update([
                        'title' => $request['title']['title_' . $language->id],
                        'country' => $request['country']['country_' . $language->id],
                        'city' => $request['city']['city_' . $language->id],
                        'street_name' => $request['street_name']['street_name_' . $language->id],
                        'address' => $request['address']['address_' . $language->id] ?? null,
                        'product_search' => $request['product_search']['product_search_' . $language->id],
                        'short_description' => $request['short_description']['short_description_' . $language->id],
                        'description' => $request['description']['description_' . $language->id],
                    ]);
                } else {
                    ExportingFairDetail::create([
                        'exporting_fair_id' => $exportingFair->id,
                        'language_id' => $language->id,
                        'title' => $request['title']['title_' . $language->id],
                        'country' => $request['country']['country_' . $language->id],
                        'city' => $request['city']['city_' . $language->id],
                        'street_name' => $request['street_name']['street_name_' . $language->id],
                        'address' => $request['address']['address_' . $language->id] ?? null,
                        'product_search' => $request['product_search']['product_search_' . $language->id],
                        'short_description' => $request['short_description']['short_description_' . $language->id],
                        'description' => $request['description']['description_' . $language->id],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new ExportingFairResource($exportingFair), 'Exporting fair has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, ExportingFair $exportingFair)
    {
        $exportingFairDetail = ExportingFairDetail::whereExportingFairId($exportingFair->id)->delete();
        if ($exportingFairDetail && $exportingFair->delete()) {
            return $this->apiSuccessResponse(new ExportingFairResource($exportingFair), 'Exporting fair has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($exportingFairs)
    {
        $defaultLang = getDefaultLanguage();
        $exportingFairs = $exportingFairs->with(['exportingFairDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withExportingFairDetail']) && $_GET['withExportingFairDetail'] == '1') {
            $exportingFairs = $exportingFairs->with('exportingFairDetail');
        }

        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $exportingFairs = $exportingFairs->with('media');
        }
        return $exportingFairs;
    }

    protected function sortingAndLimit($exportingFairs)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $exportingFairs->orderBy('id', 'desc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'start_date', 'end_date', 'event_website', 'detail_title'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $exportingFairs = $exportingFairs->addSelect(['detail_title' => ExportingFairDetail::whereColumn('exporting_fairs.id', 'exporting_fair_detail.exporting_fair_id')->whereLanguageId($defaultLang->id)->select('title')->limit(1)]);

            $exportingFairs = $exportingFairs->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $exportingFairs->paginate($limit);
    }

    protected function whereClause($exportingFairs)
    {
        $defaultLang = getDefaultLanguage(0);
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $exportingFairs = $exportingFairs->whereHas('exportingFairDetail', function ($q) use ($defaultLang) {
                $q->whereLanguageId($defaultLang->id)->where(function ($q1) {
                    $q1->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
                });
            });
        }
        return $exportingFairs;
    }
}
