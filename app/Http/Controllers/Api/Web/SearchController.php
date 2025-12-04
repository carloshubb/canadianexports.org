<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\AdvanceSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{

    public function index($abbreviation = null)
    {
        updateLangByAbber($abbreviation);
        $defaultLang = getDefaultLanguage(true);
        $testimonials = Testimonial::orderBy('id', 'desc')->with(['testimonialDetail', 'businessCategory.businessCategoryDetail']);
        if (isset($_GET['q']) && $_GET['q'] != '') {
            $testimonials = $testimonials->whereHas('testimonialDetail', function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
                $q->where(function ($q1) {
                    $q1->where('name', 'LIKE', '%' . $_GET['q'] . '%');
                    $q1->orWhere('place', 'LIKE', '%' . $_GET['q'] . '%');
                    $q1->orWhere('comment', 'LIKE', '%' . $_GET['q'] . '%');
                });
            });
        }
        $testimonials = $testimonials->with(['businessCategory.businessCategoryDetail' => function ($q) use ($defaultLang) {
            $q->where('business_category_detail.language_id', $defaultLang->id);
        }]);
        $testimonials = $testimonials->with(['testimonialDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        $testimonials = $testimonials->paginate(10);
        return view('web.search.index', compact('testimonials'));
    }

    public function advanceSearch($abbreviation = null)
    {
        $searchEvents = [];
        $searchI2bs = [];
        $searchCustomerProfiles = [];

        updateLangByAbber($abbreviation);
        if (isset($_GET['category']) && Session::has('validation_redirect') && Session::get('validation_redirect') == 0) {
            $validationRule = ['search' => 'required'];
            $request = new Request();
            $niceNames = [];
            $defaulLang = getDefaultLanguage(1);
            if ($defaulLang) {
                App::setLocale($defaulLang->abbreviation);
                $advSearchSetting = getI2bModalSetting($defaulLang, ['advance_search']);
                $niceNames = [
                    'search' => $advSearchSetting['search_input_error'],
                ];
                $niceNames['canadian-exporters'] = $advSearchSetting['select_industry_error'];
                $niceNames['inquaries-to-buy'] = $advSearchSetting['select_industry_error'];
                $niceNames['trade-shows-and-events'] = $advSearchSetting['select_industry_error'];
                if ($_GET['category'] == 'canadian-exporters') {
                    $request['canadian-exporters'] = isset($_GET['canadian-exporters']) ? $_GET['canadian-exporters'] : null;
                    $validationRule = array_merge($validationRule, ['canadian-exporters' => ['required']]);
                } else if ($_GET['category'] == 'inquaries-to-buy') {
                    $request['inquaries-to-buy'] = isset($_GET['inquaries-to-buy']) ? $_GET['inquaries-to-buy'] : null;
                    $validationRule = array_merge($validationRule, ['inquaries-to-buy' => ['required']]);
                } else if ($_GET['category'] == 'trade-shows-and-events') {
                    $request['trade-shows-and-events'] = isset($_GET['trade-shows-and-events']) ? $_GET['trade-shows-and-events'] : null;
                    $validationRule = array_merge($validationRule, ['trade-shows-and-events' => ['required']]);
                }
            }
            $request['search'] = isset($_GET['search']) ? $_GET['search'] : null;
            $validator = Validator::make($request->all(), $validationRule, [], $niceNames);

            if ($validator->fails()) {
                Session::put('validation_redirect', 1);
                return view('web.advance-search.index', compact('searchEvents', 'searchI2bs', 'searchCustomerProfiles'))->withErrors($validator);

                // return redirect(url(\Request::getRequestUri()))
                //     ->withErrors($validator)
                //     ->withInput();
            }
        }

        $defaultLang = getDefaultLanguage(1);
        if (isset($_GET['search'])) {
            $search = strtolower($_GET['search']);
            if (isset($_GET['category']) && $_GET['category'] != 'select-category') {
                $advanceSearchService = new AdvanceSearchService();
                if ($_GET['category'] == 'canadian-exporters') {
                    Session::forget('exporters_profile_ids');
                    // dd(\Session::get('exporters_profile_ids'));
                    $searchCustomerProfiles = $advanceSearchService->canadianExporters($search, $defaultLang);
                } else if ($_GET['category'] == 'inquaries-to-buy') {
                    Session::forget('i2b_ids');
                    $searchI2bs = $advanceSearchService->inquariesToBuy($search, $defaultLang);
                } else if ($_GET['category'] == 'trade-shows-and-events') {
                    Session::forget('events_ids');
                    $searchEvents = $advanceSearchService->tradeShowsAndEvents($search, $defaultLang);
                }
            }
        }
        // return $searchCustomerProfiles;
        return view('web.advance-search.index', compact('searchEvents', 'searchI2bs', 'searchCustomerProfiles'));
    }

    function removeExportsFromSearch(Request $request)
    {
        $ids = [];
        if ($request->type == 'business_categories') {
            if (Session::has('exporters_profile_ids')) {
                $ids = Session::get('exporters_profile_ids');
            }
            $ids[] = $request->id;

            Session::put('exporters_profile_ids', array_unique($ids));
        } else if ($request->type == 'i2b') {
            if (Session::has('i2b_ids')) {
                $ids = Session::get('i2b_ids');
            }
            $ids[] = $request->id;

            Session::put('i2b_ids', array_unique($ids));
        } else if ($request->type == 'events') {
            if (Session::has('events_ids')) {
                $ids = Session::get('events_ids');
            }
            $ids[] = $request->id;

            Session::put('events_ids', array_unique($ids));
        }
        return array_unique($ids);
    }


    public function i2BSearch($abbreviation = null)
    {
        updateLangByAbber($abbreviation);
        $validationRule = [
            'search' => 'required',
            'page_id' => 'required'
        ];
        $request = new Request();
        $niceNames = [];
        $request['search'] = isset($_GET['search']) ? $_GET['search'] : null;
        $request['business-categories'] = isset($_GET['business-categories']) ? $_GET['business-categories'] : null;
        $request['countries'] = isset($_GET['countries']) ? $_GET['countries'] : null;
        $request['sorting'] = isset($_GET['sorting']) ? $_GET['sorting'] : null;
        if(isset($_GET['business-categories']) && $_GET['business-categories'] != ''){
            $validationRule['search'] = ['nullable'];
        }
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $request['page_id'] = isset($_GET['page_id']) ? $_GET['page_id'] : null;
            $i2bSetting = getI2BSettingSettingById($defaultLang, $request->page_id);
            $i2bSettingDetail = isset($i2bSetting->i2bSettingDetail[0]) ? $i2bSetting->i2bSettingDetail[0] : null;
            $niceNames['search'] = $i2bSettingDetail->search_error;
            $niceNames['business-categories'] = $i2bSettingDetail->business_categories_error;
            if(isset($_GET['search']) && $_GET['search'] != ''){
                $validationRule = array_merge($validationRule, ['business-categories' => ['nullable']]);
            }
            else{
                $validationRule = array_merge($validationRule, ['business-categories' => ['required']]);
            }
        }
        $validator = Validator::make($request->all(), $validationRule, [], $niceNames);

        $previousUrl = strtok(url()->previous(), '?');
        $previousUrl = $previousUrl . '?' . http_build_query(['page_id' => $request->page_id, 'search' => $request->search, 'business-categories' => $request['business-categories'], 'countries' => $request['countries'], 'sorting' => $request['sorting']]);

        if ($validator->fails()) {
            return redirect()->to(
                $previousUrl
            )->withErrors($validator);
        }

        return redirect()->to(
            $previousUrl
        );


    }
    public function eventSearch($abbreviation = null)
{
    updateLangByAbber($abbreviation);
    $validationRule = [
        'search' => 'required',
        'page_id' => 'required'
    ];
    $request = new Request();
    $niceNames = [];
    $request['search'] = isset($_GET['search']) ? $_GET['search'] : null;
    $request['event-categories'] = isset($_GET['event-categories']) ? $_GET['event-categories'] : null;
    $request['countries'] = isset($_GET['countries']) ? $_GET['countries'] : null;
    $request['sorting'] = isset($_GET['sorting']) ? $_GET['sorting'] : null;

    $defaultLang = getDefaultLanguage(1);
    if ($defaultLang) {
        App::setLocale($defaultLang->abbreviation);
        $request['page_id'] = isset($_GET['page_id']) ? $_GET['page_id'] : null;
        $eventSetting = getEventSettingSettingById($defaultLang, $request->page_id);
        $eventSettingDetail = isset($eventSetting->eventSettingDetail[0]) ? $eventSetting->eventSettingDetail[0] : null;
        $niceNames['search'] = $eventSettingDetail->search_error;
        $niceNames['event-categories'] = $eventSettingDetail->business_categories_error;
    }

    $validator = Validator::make($request->all(), $validationRule, [], $niceNames);

    $previousUrl = strtok(url()->previous(), '?');
    $previousUrl = $previousUrl . '?' . http_build_query([
        'page_id' => $request->page_id,
        'search' => $request->search,
        'event-categories' => $request['event-categories'],
        'countries' => $request['countries'],
        'sorting' => $request['sorting']
    ]);

    if ($validator->fails()) {
        return redirect()->to($previousUrl)->withErrors($validator);
    }

    return redirect()->to($previousUrl);
}
}
