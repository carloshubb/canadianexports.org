<?php

namespace App\Services;

use App\Models\BusinessCategoryDetail;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\I2b;
use App\Models\I2bDetail;
use App\Models\RegistrationPackage;
use Illuminate\Support\Facades\Session;

class AdvanceSearchService
{
    public function canadianExporters($search, $defaultLang)
    {
        $searchCustomerProfiles = CustomerProfile::whereHas('customer', function ($q) {
            $q->where('is_active', 1)->where('is_package_amount_paid', 1)->where('package_expiry_date', '>=', date('Y-m-d'));
        });
        $searchCustomerProfiles = $searchCustomerProfiles->where(function ($q) use ($search) {
            $q = $q->where('company_name', 'like', '%' . $search . '%')
                ->orWhere('short_description', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('website', 'like', '%' . $search . '%')
                ->orWhere('keywords', 'like', '%' . $search . '%');
        });

        if (isset($_GET['canadian-exporters']) && !in_array('all', $_GET['canadian-exporters']) && is_array($_GET['canadian-exporters']) && count($_GET['canadian-exporters']) > 0) {
            $searchCustomerProfiles = $searchCustomerProfiles->whereHas('customerBusinessCategory', function ($q) {
                $q->whereIn('customer_business_categories.business_category_id', $_GET['canadian-exporters']);
            });
        }
        $searchCustomerProfiles = $searchCustomerProfiles->addSelect([
            'package_type' => Customer::whereColumn('customers.id', 'customer_profile.customer_id')
                ->select(['package_type' => RegistrationPackage::whereColumn('customers.registration_package_id', 'registration_packages.id')->select('package_type')])
        ]);
        // $searchCustomerProfiles = $searchCustomerProfiles->addSelect([
        //     'sorting_order' => Customer::whereColumn('customers.id', 'customer_profile.customer_id')
        //         ->select(['sorting_order' => RegistrationPackage::whereColumn('customers.registration_package_id', 'registration_packages.id')->select('sorting_order')])
        // ]);
        $searchCustomerProfiles = $searchCustomerProfiles->orderByRaw("FIELD(package_type, 'featured', 'premium', 'free') ASC");
        if (isset($_GET['sorting']) && in_array($_GET['sorting'], ['a-z', 'z-a']) != '') {
            $sorting = $_GET['sorting'] == 'a-z' ? 'asc' : 'desc';
            $searchCustomerProfiles = $searchCustomerProfiles->orderBy('company_name', $sorting);
        }
        // $searchCustomerProfiles = $searchCustomerProfiles->orderBy('sorting_order', 'desc');
        if (Session::has('exporters_profile_ids')) {
            $searchCustomerProfiles = $searchCustomerProfiles->whereNotIn('id', Session::get('exporters_profile_ids'));
        }

        // return $searchCustomerProfiles = $searchCustomerProfiles->get();
        return $searchCustomerProfiles = $searchCustomerProfiles->paginate(25);
        return $searchCustomerProfiles;
    }

    function inquariesToBuy($search, $defaultLang)
    {
        $searchI2bs = I2b::query();
        if (isset($_GET['inquaries-to-buy']) && !in_array('all', $_GET['inquaries-to-buy']) && is_array($_GET['inquaries-to-buy']) && count($_GET['inquaries-to-buy']) > 0) {
            $searchI2bs = $searchI2bs->whereIn('id', $_GET['inquaries-to-buy']);
        }


        $searchI2bs = $searchI2bs->addSelect(['business_category_name' => BusinessCategoryDetail::whereColumn('i2b.business_category_id', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);



        $searchI2bs = $searchI2bs->with(['i2bDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        if (Session::has('i2b_ids')) {
            $searchI2bs = $searchI2bs->whereNotIn('id', Session::get('i2b_ids'));
        }
        $searchI2bs = $searchI2bs->where(function ($query) use ($search, $defaultLang) {
            $query = $query->whereHas('i2bDetail', function ($q) use ($search, $defaultLang) {
                $q->where('i2b_detail.language_id', $defaultLang->id);
                $q->where(function ($q1) use ($search) {
                    $q1->where('name', 'like', '%' . $search . '%')->orWhere('country_name', 'like', '%' . $search . '%');
                });
            });
            $query = $query->orWhere(function ($q) use ($search, $defaultLang) {
                $q = $q->whereHas('businessCategory.businessCategoryDetail', function ($q1) use ($search, $defaultLang) {
                    $q1->where('business_category_detail.language_id', $defaultLang->id)->where('name', 'like', '%' . $search . '%');
                });
            });
        });

        if (isset($_GET['sorting'])) {
            $sorting = $_GET['sorting'];

            if ($sorting === 'include-expired') {
                // Include expired I2Bs and sort by deadline_date in ascending order
                $searchI2bs = $searchI2bs->orderBy('deadline_date', 'asc');
            } elseif (in_array($sorting, ['a-z', 'z-a'])) {
                $searchI2bs = $searchI2bs->whereDate('deadline_date', '>=', date('Y-m-d'));

                $searchI2bs = $searchI2bs->addSelect([
                    'i2b_name' => I2bDetail::whereColumn('i2b.id', 'i2b_detail.i2b_id')
                        ->whereLanguageId($defaultLang->id)
                        ->select('deadline_date')
                        ->limit(1)
                ]);

                $sortingOrder = $sorting == 'a-z' ? 'asc' : 'desc';
                $searchI2bs = $searchI2bs->orderBy('i2b_name', $sortingOrder);
            }
        } else {
            $searchI2bs = $searchI2bs->whereDate('deadline_date', '>=', date('Y-m-d'));
        }





        $searchI2bs = $searchI2bs->paginate(12);
        return $searchI2bs;
    }

    function tradeShowsAndEvents($search, $defaultLang)
    {
        $searchEvents = Event::query();

        if (isset($_GET['trade-shows-and-events']) && !in_array('all', $_GET['trade-shows-and-events']) && is_array($_GET['trade-shows-and-events']) && count($_GET['trade-shows-and-events']) > 0) {
            $searchEvents = $searchEvents->whereIn('id', $_GET['trade-shows-and-events']);
        }


        $searchEvents = $searchEvents->with(['eventDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        if (Session::has('events_ids')) {
            $searchEvents = $searchEvents->whereNotIn('id', Session::get('events_ids'));
        }

        $searchEvents = $searchEvents->whereHas('eventDetail', function ($q) use ($search, $defaultLang) {
            $q->where('language_id', $defaultLang->id);
            $q->where(function ($q1) use ($search) {
                $q1->where('title', 'like', '%' . $search . '%')->orWhere('short_description', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%')->orWhere('country', 'like', '%' . $search . '%')->orWhere('city', 'like', '%' . $search . '%')->orWhere('product_search', 'like', '%' . $search . '%')->orWhere('venue', 'like', '%' . $search . '%');
            });
        });



        if (isset($_GET['sorting']) && in_array($_GET['sorting'], ['a-z', 'z-a', 'display-past-events']) != '') {
            if (in_array($_GET['sorting'], ['display-past-events'])) {
                $searchEvents = $searchEvents->whereDate('end_date', '<', date('Y-m-d'));
                $searchEvents = $searchEvents->orderBy('start_date', 'desc');
            } else if (in_array($_GET['sorting'], ['a-z', 'z-a'])) {
                $searchEvents = $searchEvents->whereDate('end_date', '>=', date('Y-m-d'));
                $sorting = $_GET['sorting'] == 'a-z' ? 'asc' : 'desc';
                $searchEvents = $searchEvents->orderBy('start_date', $sorting);
            }
        }

        $searchEvents = $searchEvents->paginate(12);
        return $searchEvents;
    }
}
