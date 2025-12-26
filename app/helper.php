<?php

use App\Http\Resources\Admin\BannerResource;
use App\Http\Resources\Web\CustomerResource;
use App\Models\AboutUsPageSetting;
use App\Models\AdvertiserSetting;
use App\Models\ScamAlertSetting;
use App\Models\SuccessStoriesSetting;
use App\Models\TestimonialSetting;
use App\Models\SuccessStories;
use App\Models\Banner;
use App\Models\SponsorSetting;
use App\Models\BecomeSponsorSetting;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryDetail;
use App\Models\BusinessDirectory;
use App\Models\BusinessDirectoryDetail;
use App\Models\CloseAccountSetting;
use App\Models\CommentsSetting;
use App\Models\ContactForRateSetting;
use App\Models\ContactUsSetting;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\EventSetting;
use App\Models\Event;
use App\Models\EventCreateSetting;
use App\Models\EventSignupSetting;
use App\Models\ExportingFair;
use App\Models\ExportingFairSetting;
use App\Models\Faq;
use App\Models\FinancingProgramSetting;
use App\Models\FooterSetting;
use App\Models\ForgetPageSetting;
use App\Models\GeneralSetting;
use App\Models\HomePageFeaturedExporter;
use App\Models\HomePageSetting;
use App\Models\I2b;
use App\Models\I2bDetail;
use App\Models\I2BSetting;
use App\Models\InfoLetterSetting;
use App\Models\FaqExporterSetting;
use App\Models\FaqImporterSetting;
use App\Models\Issue;
use App\Models\Language;
use App\Models\LoginPageSetting;
use App\Models\Media;
use App\Models\Menu;
use App\Models\OneMoreThing;
use App\Models\OneMoreThingSetting;
use App\Models\OnlineBusinessDirectorySetting;
use App\Models\Page;
use App\Models\RatesSetting;
use App\Models\RegistrationPackage;
use App\Models\RegistrationPackageDetail;
use App\Models\RegPageSetting;
use App\Models\SponsorPageSetting;
use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use App\Models\Testimonial;
use App\Models\Widget;
use Cohensive\Embed\Facades\Embed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

if (!function_exists('log_to_txt')) {
    function log_to_txt($message, $file = 'custom_log.txt') {
        $logPath = storage_path('logs/' . $file);
        $logMessage = date('Y-m-d H:i:s') . " - $message\n";
        File::append($logPath, $logMessage);
    }
}

if (!function_exists('getAllLanguages')) {
    function getAllLanguages()
    {
        return Language::with('flagIcon')->get();
    }
}

if (!function_exists('getDefaultLanguage')) {
    function getDefaultLanguage($isWeb = false)
    {
        $lang = '';
        $webLanguage = Session::get('webLanguage');
        if ($isWeb && isset($webLanguage) && !empty($webLanguage)) {
            $lang = Language::where('id', $webLanguage)->first();
        } else {
            $lang = Language::whereIsDefault(1)->first();
        }

        return $lang ? $lang : Language::first();
    }
}

if (!function_exists("upload")) {
    function upload($file, $type)
    {
        if (isset($file)) {
            $fileName = preg_replace('/\s+/', '_', time() . ' ' . $file->getClientOriginalName());
            $path = $type . "/" . time() . "/" . $fileName;
           
            if (!file_exists($type . "/" . time())) {
                mkdir($type . "/" . time(), 0777);
            }
            if ($file->move($type . "/" . time(), $fileName)) {
                $media = Media::create([
                    'path' => $path,
                    'type' => 'customer_registration',
                    'extension' => pathinfo($path, PATHINFO_EXTENSION),
                ]);
                return $media->id;
            }
        }
        return null;
    }
}

if (!function_exists("getRegistrationPackage")) {
    function getRegistrationPackage($packageId)
    {
        return RegistrationPackage::whereId($packageId)->first();
    }
}

if (!function_exists("getRegistrationPackageByType")) {
    function getRegistrationPackageByType($type)
    {
        return RegistrationPackage::where('package_type', $type)->where('type', 'profile')->first();
    }
}

if (!function_exists("getDefaultCustomerRegistrationPackage")) {
    function getDefaultCustomerRegistrationPackage()
    {
        return RegistrationPackage::where('type', 'profile')->where('is_default', 1)->first();
    }
}

if (!function_exists("getPackageDetail")) {
    function getPackageDetail($package_id, $defaultLang)
    {
        return RegistrationPackageDetail::where('registration_package_id', $package_id)->where('language_id', $defaultLang->id)->first();
    }
}

if (!function_exists("getFeaturedProfile")) {
    function getFeaturedProfile($pageId)
    {
        $customerProfileIds = HomePageFeaturedExporter::wherePageId($pageId)->pluck('business_category_id');
        $limit = HomePageSetting::wherePageId($pageId)->value('number_of_featured_exporters') ?? 6;
        $customers = CustomerProfile::select('id', 'customer_id', 'company_name', 'slug', 'short_description', 'description')->with(['customerMedia:id,customer_id,customer_profile_id,logo', 'customerMedia.customerLogo']);

        $customerProfiles = clone $customers;

        $preferCustomerProfiles = $customerProfiles->whereIn('id', $customerProfileIds)->limit($limit)->get();

        $remainingProfiles = $limit - count($preferCustomerProfiles);

        if ($remainingProfiles > 0) {

            $customers->whereHas('customer', function ($q) {
                $q->where('is_active', 1)->where('is_package_amount_paid', 1)->where('package_expiry_date', '>=', date('Y-m-d'));
            });
            $customers = $customers->whereHas('customer.registrationPackage', function ($q) {
                $q->where('registration_packages.package_type', 'featured');
            });

            $customers = $customers->addSelect([
                'package_type' => Customer::whereColumn('customers.id', 'customer_profile.customer_id')
                    ->select(['package_type' => RegistrationPackage::whereColumn('customers.registration_package_id', 'registration_packages.id')->select('package_type')])
            ]);
            // $customers = $customers->addSelect([
            //     'sorting_order' => Customer::whereColumn('customers.id', 'customer_profile.customer_id')
            //         ->select(['sorting_order' => RegistrationPackage::whereColumn('customers.registration_package_id', 'registration_packages.id')->select('sorting_order')])
            // ]);

            $remainingCustomerProfiles = $customers->inRandomOrder()->limit($remainingProfiles)->get();
        }
        if ($remainingCustomerProfiles && $preferCustomerProfiles) {
            $customers = array_merge($remainingCustomerProfiles->toArray(), $preferCustomerProfiles->toArray());
        } else if ($remainingCustomerProfiles && !$preferCustomerProfiles) {
            $customers = $remainingCustomerProfiles;
        } else if (!$remainingCustomerProfiles && $preferCustomerProfiles) {
            $customers = $preferCustomerProfiles;
        }
        return $customers;
    }
}

if (!function_exists("getEventPackages")) {
    function getEventPackages($defaultLang)
    {
        return RegistrationPackage::whereType('event')->with(['registrationPackageDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->get();
    }
}

if (!function_exists("getRatesPackages")) {
    function getRatesPackages($defaultLang)
    {
        return RegistrationPackage::where('package_type', '!=', 'pay_to_go')->with(['registrationPackageDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->get();
    }
}

if (!function_exists("getAllPackages")) {
    function getAllPackages()
    {
        return RegistrationPackage::get();
    }
}


if (!function_exists("getVideoHtmlAttribute")) {
    function getVideoHtmlAttribute($url = null)
    {
        if (isset($url)) {
            $embed = Embed::make($url)->parseUrl();

            if (!$embed)
                return '';

            $embed->setAttribute(['width' => '100%', 'height' => 315]);
            return $embed->getHtml();
        } else {
            return null;
        }
    }
}

if (!function_exists("getAllBusinessCategories")) {
    function getAllBusinessCategories()
    {
        $defaultLang = getDefaultLanguage(true);
        $businessCategories = BusinessCategory::addSelect(['category_name' => BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')->where('business_category_detail.language_id', $defaultLang->id)->select('name')])
            ->addSelect(['category_slug' => BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')->where('business_category_detail.language_id', $defaultLang->id)->select('slug')])
            ->addSelect(['category_icon' => BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')->where('business_category_detail.language_id', $defaultLang->id)->select('icon')])
            ->orderBy('category_name', 'asc')->get();
        return $businessCategories;
    }
}

if (!function_exists("getRegPageSetting")) {
    function getRegPageSetting()
    {
        $defaultLang = getDefaultLanguage(true);
        $regPageSetting = RegPageSetting::with(['regPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->latest()->first();
        return $regPageSetting;
    }
}

if (!function_exists("getPageBySlug")) {
    function getPageBySlug($slug = null, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }
        $page = null;
        if ($slug) {
            $page = Page::whereSlug($slug)->with(['pageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])->with(['facebook'])->first();
        }
        return $page;
    }
}

if (!function_exists("getWidgetDetail")) {
    function getWidgetDetail($short_code, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }
        $widget = Widget::where('short_code', $short_code)->with(['widgetDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $widget;
    }
}

if (!function_exists("getFrontPage")) {
    function getFrontPage()
    {
        $page = Page::whereIsHomePage(1)->with(['facebook'])->first();
        $page = !$page ? Page::first() : $page;
        return $page;
    }
}

if (!function_exists("getHomePageSetting")) {
    function getHomePageSetting($defaultLang, $page)
    {
        $homePageSetting = HomePageSetting::wherePageId($page->id)->with(['homePageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $homePageSetting;
    }
}

if (!function_exists("getLatestHomePageSetting")) {
    function getLatestHomePageSetting($defaultLang)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }
        $homePageId = Page::where('is_home_page', '1')->value('id');
        $homePageSetting = HomePageSetting::latest()->with(['homePageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if ($homePageId) {
            $homeSetting = HomePageSetting::wherePageId($homePageId)->exists();
            if ($homeSetting) {
                $homePageSetting = $homePageSetting->where('page_id', $homePageId);
            }
        }

        $homePageSetting = $homePageSetting->first();
        return $homePageSetting;
    }
}

if (!function_exists("getFooterSetting")) {
    function getFooterSetting($defaultLang)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }

        $footerSetting = FooterSetting::whereIsActive('1')
            ->with(['widget1Menu.menuDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])
            ->with(['widget2Menu.menuDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])
            ->with(['widget3Menu.menuDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])
            ->with(['footerSettingDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }]);

        $footerSetting = $footerSetting->first();
        return $footerSetting;
    }
}

if (!function_exists("getAboutUsPageSetting")) {
    function getAboutUsPageSetting($defaultLang, $page)
    {
        $aboutUsPageSetting = AboutUsPageSetting::wherePageId($page->id)->with(['aboutUsPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $aboutUsPageSetting;
    }
}

if (!function_exists("getContactUsSetting")) {
    function getContactUsSetting($defaultLang, $page)
    {
        $contactUsSetting = ContactUsSetting::wherePageId($page->id)->with(['contactUsSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $contactUsSetting;
    }
}

if (!function_exists("getI2BSetting")) {
    function getI2BSetting($defaultLang, $page)
    {
        $i2bSetting = I2BSetting::with(['i2BSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($page)) {
            $i2bSetting = $i2bSetting->wherePageId($page->id);
        }
        $i2bSetting = $i2bSetting->first();
        return $i2bSetting;
    }
}
if (!function_exists("getEventSetting")) {
    function getEventSetting($defaultLang, $page)
    {
        $eventSetting = EventSetting::with(['eventSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($page)) {
            $eventSetting = $eventSetting->wherePageId($page->id);
        }
        $eventSetting = $eventSetting->first();
        return $eventSetting;
    }
}

if (!function_exists("getCommentsSetting")) {
    function getCommentsSetting($defaultLang, $page)
    {
        $commentsSetting = CommentsSetting::wherePageId($page->id)->with(['commentsSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $commentsSetting;
    }
}

if (!function_exists("getRatesSetting")) {
    function getRatesSetting($defaultLang, $page)
    {
        $ratesSetting = RatesSetting::wherePageId($page->id)->with(['ratesSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $ratesSetting;
    }
}

if (!function_exists("getCloseAccountSetting")) {
    function getCloseAccountSetting($defaultLang, $page)
    {
        $closeAccountSetting = CloseAccountSetting::wherePageId($page->id)->with(['closeAccountSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $closeAccountSetting;
    }
}

if (!function_exists("getBecomeSponsorSetting")) {
    function getBecomeSponsorSetting($defaultLang, $page)
    {
        $becomeSponsorSetting = BecomeSponsorSetting::wherePageId($page->id)->with(['becomeSponsorSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $becomeSponsorSetting;
    }
}

if (!function_exists("getOnlineBusinessDirectorySetting")) {
    function getOnlineBusinessDirectorySetting($defaultLang, $page)
    {
        $onlineBusinessDirectorySetting = OnlineBusinessDirectorySetting::wherePageId($page->id)->with(['onlineBusinessDirectorySettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $onlineBusinessDirectorySetting;
    }
}

if (!function_exists("getOnlineBusinessDirectory")) {
    function getOnlineBusinessDirectory($defaultLang)
    {
        $onlineBusinessDirectorySetting = BusinessDirectory::pluck('industry');
        return $onlineBusinessDirectorySetting;
    }
}

if (!function_exists("getFinancingProgramSetting")) {
    function getFinancingProgramSetting($defaultLang, $page)
    {
        $financingProgramSetting = FinancingProgramSetting::wherePageId($page->id)->with(['financingProgramSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $financingProgramSetting;
    }
}

if (!function_exists("getContactForRateSetting")) {
    function getContactForRateSetting($defaultLang, $page)
    {
        $contactForRateSetting = ContactForRateSetting::wherePageId($page->id)->with(['contactForRateSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $contactForRateSetting;
    }
}
if (!function_exists("getScamAlertSetting")) {
    function getScamAlertSetting($defaultLang, $page)
    {
        $scamAlertSetting = ScamAlertSetting::wherePageId($page->id)->with(['scamAlertSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $scamAlertSetting;
    }
}
if (!function_exists("getSuccessStoriesSetting")) {
    function getSuccessStoriesSetting($defaultLang, $page)
    {
        $successStoriesSetting = SuccessStoriesSetting::wherePageId($page->id)->with(['successStoriesSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $successStoriesSetting;
    }
}
if (!function_exists("getTestimonialSetting")) {
    function getTestimonialSetting($defaultLang, $page)
    {
        $testimonialSetting = TestimonialSetting::wherePageId($page->id)->with(['testimonialSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $testimonialSetting;
    }
}
if (!function_exists("getFaqExporterSetting")) {
    function getFaqExporterSetting($defaultLang, $page)
    {
        $faqExporterSetting = FaqExporterSetting::wherePageId($page->id)->with(['faqExporterSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $faqExporterSetting;
    }
}
if (!function_exists("getFaqImporterSetting")) {
    function getFaqImporterSetting($defaultLang, $page)
    {
        $faqImporterSetting = FaqImporterSetting::wherePageId($page->id)->with(['faqImporterSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $faqImporterSetting;
    }
}

if (!function_exists("getOneMoreThingSetting")) {
    function getOneMoreThingSetting($defaultLang, $page)
    {
        $oneMoreThingSetting = OneMoreThingSetting::wherePageId($page->id)->with(['oneMoreThingSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $oneMoreThingSetting;
    }
}

if (!function_exists("getExportingFairSetting")) {
    function getExportingFairSetting($defaultLang, $page)
    {
        $exportingFairSetting = ExportingFairSetting::wherePageId($page->id)->with(['exportingFairSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $exportingFairSetting;
    }
}

if (!function_exists("getSponsorSetting")) {
    function getSponsorSetting($defaultLang, $page)
    {
        $sponsorPageSetting = SponsorPageSetting::wherePageId($page->id)->with(['sponsorPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $sponsorPageSetting;
    }
}

if (!function_exists("getGeneralSettingByKey")) {
    function getGeneralSettingByKey()
    {
        return GeneralSetting::pluck('value', 'key');
    }
}

if (!function_exists("getSignleGeneralSettingByKey")) {
    function getSignleGeneralSettingByKey($keys = [])
    {
        return GeneralSetting::whereIn('key', $keys)->pluck('value', 'key');
    }
}

if (!function_exists("getGeneralSettingByType")) {
    function getGeneralSettingByType($type)
    {
        return GeneralSetting::where('type', $type)->get();
    }
}

if (!function_exists("getEventCreateSetting")) {
    function getEventCreateSetting($defaultLang, $page)
    {
        $eventCreateSetting = EventCreateSetting::wherePageId($page->id)->with(['eventCreateSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $eventCreateSetting;
    }
}

if (!function_exists("getEventSignupSetting")) {
    function getEventSignupSetting($defaultLang, $page)
    {
        $eventSignupSetting = EventSignupSetting::wherePageId($page->id)->with(['eventSignupSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $eventSignupSetting;
    }
}

if (!function_exists("getInfoLetterSetting")) {
    function getInfoLetterSetting($defaultLang, $page)
    {
        $infoLetterSetting = InfoLetterSetting::wherePageId($page->id)->with(['infoLetterSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $infoLetterSetting;
    }
}

if (!function_exists("getRegPageSetting")) {
    function getRegPageSetting($defaultLang, $page)
    {
        $regPageSetting = RegPageSetting::wherePageId($page->id)->with(['regPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $regPageSetting;
    }
}

if (!function_exists("getSponsorPageSetting")) {
    function getSponsorPageSetting($defaultLang, $pageId)
    {
        $becomeSponsorSetting = BecomeSponsorSetting::wherePageId($pageId)->with(['becomeSponsorSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $becomeSponsorSetting;
    }
}

if (!function_exists("getFinancingPageSetting")) {
    function getFinancingPageSetting($defaultLang, $pageId)
    {
        $financingProgramSetting = FinancingProgramSetting::wherePageId($pageId)->with(['financingProgramSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $financingProgramSetting;
    }
}

if (!function_exists("getContactForRatePageSetting")) {
    function getContactForRatePageSetting($defaultLang, $pageId)
    {
        $contactForRateSetting = ContactForRateSetting::wherePageId($pageId)->with(['contactForRateSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $contactForRateSetting;
    }
}
if (!function_exists("getRatesPageSetting")) {
    function getRatesPageSetting($defaultLang, $pageId)
    {
        $ratesSetting = RatesSetting::wherePageId($pageId)->with(['ratesSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $ratesSetting;
    }
}

if (!function_exists("getScamAlertPageSetting")) {
    function getScamAlertPageSetting($defaultLang, $pageId)
    {
        $scamAlertSetting = ScamAlertSetting::wherePageId($pageId)->with(['scamAlertSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $scamAlertSetting;
    }
}
if (!function_exists("getSuccessStoriesPageSetting")) {
    function getSuccessStoriesPageSetting($defaultLang, $pageId)
    {
        $successStoriesSetting = SuccessStoriesSetting::wherePageId($pageId)->with(['successStoriesSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $successStoriesSetting;
    }
}
if (!function_exists("getTestimonialPageSetting")) {
    function getTestimonialPageSetting($defaultLang, $pageId)
    {
        $testimonialSetting = TestimonialSetting::wherePageId($pageId)->with(['testimonialSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $testimonialSetting;
    }
}
if (!function_exists("getFaqExporterPageSetting")) {
    function getFaqExporterPageSetting($defaultLang, $pageId)
    {
        $faqExporterSetting = FaqExporterSetting::wherePageId($pageId)->with(['faqExporterSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $faqExporterSetting;
    }
}
if (!function_exists("getFaqImporterPageSetting")) {
    function getFaqImporterPageSetting($defaultLang, $pageId)
    {
        $faqImporterSetting = FaqImporterSetting::wherePageId($pageId)->with(['faqImporterSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $faqImporterSetting;
    }
}

if (!function_exists("getRatesPageSetting")) {
    function getRatePageSetting($defaultLang, $pageId)
    {
        $ratesSetting = RatesSetting::wherePageId($pageId)->with(['ratesSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $ratesSetting;
    }
}
if (!function_exists("getCloseAccountPageSetting")) {
    function getCloseAccountPageSetting($defaultLang, $pageId)
    {
        $closeAccountSetting = CloseAccountSetting::wherePageId($pageId)->with(['closeAccountSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $closeAccountSetting;
    }
}

if (!function_exists("getEventCreateSettingById")) {
    function getEventCreateSettingById($defaultLang, $pageId)
    {
        $eventCreateSetting = EventCreateSetting::wherePageId($pageId)->with(['eventCreateSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $eventCreateSetting;
    }
}

if (!function_exists("getI2BSettingSettingById")) {
    function getI2BSettingSettingById($defaultLang, $pageId)
    {
        $i2bSetting = I2BSetting::wherePageId($pageId)->with(['i2BSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $i2bSetting;
    }
}
if (!function_exists("getEventSettingSettingById")) {
    function getEventSettingSettingById($defaultLang, $pageId)
    {
        $eventSetting = EventSetting::wherePageId($pageId)->with(['eventSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $eventSetting;
    }
}
if (!function_exists("getSponsorSettingSettingById")) {
    function getSponsorSettingSettingById($defaultLang, $pageId)
    {
        $sponsorPageSetting = SponsorPageSetting::wherePageId($pageId)->with(['sponsorPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $sponsorPageSetting;
    }
}

if (!function_exists("getContactUsSettingById")) {
    function getContactUsSettingById($defaultLang, $pageId)
    {
        $contactUsSetting = ContactUsSetting::wherePageId($pageId)->with(['contactUsSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $contactUsSetting;
    }
}

if (!function_exists("getCommentsSettingById")) {
    function getCommentsSettingById($defaultLang, $pageId)
    {
        $commentsSetting = CommentsSetting::wherePageId($pageId)->with(['commentsSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $commentsSetting;
    }
}

if (!function_exists("getLatestRegPageId")) {
    function getLatestRegPageId()
    {
        return RegPageSetting::latest()->value('page_id');
    }
}

if (!function_exists("getLoginPageSetting")) {
    function getLoginPageSetting($defaultLang, $page)
    {
        if (isset($page)) {
            $loginPageSetting = LoginPageSetting::wherePageId($page->id)->with(['loginPageSettingDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])->first();
            return $loginPageSetting;
        }
        return false;
    }
}

if (!function_exists("getForgetPageSetting")) {
    function getForgetPageSetting($defaultLang, $page)
    {
        $forgetPageSetting = ForgetPageSetting::wherePageId($page->id)->with(['forgetPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $forgetPageSetting;
    }
}

// if (!function_exists("getAllInquiries")) {
//     function getAllInquiries($paginateNumber = null, $defaultLang = null)
//     {
//         if (!$defaultLang) {
//             $defaultLang = getDefaultLanguage(1);
//         }
//         $i2b = I2b::with(['i2bDetail' => function ($q) use ($defaultLang) {
//             $q->where('language_id', $defaultLang->id);
//         }]);
//         $i2b = $i2b->addSelect(['business_category_name' => BusinessCategoryDetail::whereColumn('i2b.business_category_id', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

//         $i2b = $i2b->addSelect(['business_category_name_2' => BusinessCategoryDetail::whereColumn('i2b.business_category_id_2', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

//         $i2b = $i2b->addSelect(['business_category_name_3' => BusinessCategoryDetail::whereColumn('i2b.business_category_id_3', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

//         if (isset($_GET['business-categories']) && !in_array('all', $_GET['business-categories']) && is_array($_GET['business-categories']) && count($_GET['business-categories']) > 0) {
//             $i2b = $i2b->where(function ($q) {
//                 $q->whereIn('business_category_id', $_GET['business-categories'])->orWhereIn('business_category_id_2', $_GET['business-categories'])->orWhereIn('business_category_id_3', $_GET['business-categories']);
//             });
//         }
//         if (isset($_GET['search']) && $_GET['search'] != '') {
//             $search = $_GET['search'];
//             $searchValues = explode(',', $search);

//             $i2b = $i2b->whereHas('i2bDetail', function ($q) use ($searchValues, $defaultLang) {
//                 $q->where('i2b_detail.language_id', $defaultLang->id);
//                 $q->where(function ($q1) use ($searchValues) {
//                     foreach ($searchValues as $key => $searchValue) {

//                         if ($key == 0) {
//                             $q1->where('name', 'like', '%' . $searchValue . '%')->orWhere('country_name', 'like', '%' . $searchValue . '%');
//                         } else {
//                             $q1->orWhere('name', 'like', '%' . $searchValue . '%')->orWhere('country_name', 'like', '%' . $searchValue . '%');
//                         }
//                     }
//                 });
//             });
//         }
//         if (isset($_GET['countries']) && !in_array('all', $_GET['countries']) && is_array($_GET['countries']) && count($_GET['countries']) > 0) {
//             $i2b = $i2b->whereHas('i2bDetail', function ($q) {
//                 $q->whereIn('country_name', $_GET['countries']);
//             });
//         }
//         if (isset($_GET['sorting'])) {
//             $sorting = $_GET['sorting'];

//             if (in_array($sorting, ['a-z', 'z-a'])) {
//                 $i2b = $i2b->whereDate('deadline_date', '>=', date('Y-m-d'));

//                 $i2b = $i2b->addSelect([
//                     'i2b_name' => I2bDetail::whereColumn('i2b.id', 'i2b_detail.i2b_id')
//                         ->whereLanguageId($defaultLang->id)
//                         ->select('name')
//                         ->limit(1)
//                 ]);

//                 $sortingOrder = $sorting == 'a-z' ? 'asc' : 'desc';
//                 // $i2b = $i2b->orderBy('i2b_name', $sortingOrder);
//                 $i2b = $i2b->orderBy('created_at', $sortingOrder);
//             }
//         } else {
//             $i2b = $i2b->whereDate('deadline_date', '>=', date('Y-m-d'))->latest();
//         }

//         if (isset($paginateNumber) && $paginateNumber > 0) {
//             $i2b = $i2b->paginate($paginateNumber);
//             return $i2b->appends(['search' => request('search'), 'countries' => request('countries'), 'sorting' => request('sorting'), 'business-categories' => request('business-categories')]);
//         }

//         if ($paginateNumber == 0) {
//             return $i2b->get();
//         }

//         return $i2b->limit(9)->get();
//     }
// }
if (!function_exists("getAllInquiries")) {
    function getAllInquiries($paginateNumber = null, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }

        $i2b = I2b::with(['i2bDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        $i2b = $i2b->addSelect(['business_category_name' => BusinessCategoryDetail::whereColumn('i2b.business_category_id', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);
        $i2b = $i2b->addSelect(['business_category_name_2' => BusinessCategoryDetail::whereColumn('i2b.business_category_id_2', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);
        $i2b = $i2b->addSelect(['business_category_name_3' => BusinessCategoryDetail::whereColumn('i2b.business_category_id_3', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

        // Filtering business categories
        if (isset($_GET['business-categories']) && !in_array('all', $_GET['business-categories']) && is_array($_GET['business-categories']) && count($_GET['business-categories']) > 0) {
            $i2b = $i2b->where(function ($q) {
                $q->whereIn('business_category_id', $_GET['business-categories'])
                    ->orWhereIn('business_category_id_2', $_GET['business-categories'])
                    ->orWhereIn('business_category_id_3', $_GET['business-categories']);
            });
        }

        // Search filter
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = $_GET['search'];
            $searchValues = explode(',', $search);

            $i2b = $i2b->whereHas('i2bDetail', function ($q) use ($searchValues, $defaultLang) {
                $q->where('i2b_detail.language_id', $defaultLang->id);
                $q->where(function ($q1) use ($searchValues) {
                    foreach ($searchValues as $key => $searchValue) {
                        if ($key == 0) {
                            $q1->where('name', 'like', '%' . $searchValue . '%')
                               ->orWhere('country_name', 'like', '%' . $searchValue . '%');
                        } else {
                            $q1->orWhere('name', 'like', '%' . $searchValue . '%')
                               ->orWhere('country_name', 'like', '%' . $searchValue . '%');
                        }
                    }
                });
            });
        }

        // Filter countries
        if (isset($_GET['countries']) && !in_array('all', $_GET['countries']) && is_array($_GET['countries']) && count($_GET['countries']) > 0) {
            $i2b = $i2b->whereHas('i2bDetail', function ($q) {
                $q->whereIn('country_name', $_GET['countries']);
            });
        }

        // Sorting based on deadline_date
        if (isset($_GET['sorting'])) {
            $sorting = $_GET['sorting'];

            if ($sorting == 'include-expired') {
                // Sort by deadline_date in ascending order, including expired records
                $i2b = $i2b->orderBy('deadline_date', 'asc');
            } elseif (in_array($sorting, ['a-z', 'z-a'])) {
                $i2b = $i2b->whereDate('deadline_date', '>=', date('Y-m-d'));

                $i2b = $i2b->addSelect([
                    'i2b_name' => I2bDetail::whereColumn('i2b.id', 'i2b_detail.i2b_id')
                        ->whereLanguageId($defaultLang->id)
                        ->select('name')
                        ->limit(1)
                ]);

                // Sorting by deadline_date
                $sortingOrder = $sorting == 'a-z' ? 'asc' : 'desc';
                $i2b = $i2b->orderBy('deadline_date', $sortingOrder); // Changed to deadline_date
            }
        } else {
            $i2b = $i2b->whereDate('deadline_date', '>=', date('Y-m-d'))->latest();
        }

        // Paginate results
        if (isset($paginateNumber) && $paginateNumber > 0) {
            $i2b = $i2b->paginate($paginateNumber);
            return $i2b->appends([
                'search' => request('search'),
                'countries' => request('countries'),
                'sorting' => request('sorting'),
                'business-categories' => request('business-categories')
            ]);
        }

        if ($paginateNumber == 0) {
            return $i2b->get();
        }

        return $i2b->limit(9)->get();
    }
}

if (!function_exists("getLatestInquiries")) {
    function getLatestInquiries($limit = 6, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $i2b = I2b::with(['i2bDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->whereDate('deadline_date', '>=', date('Y-m-d'))->inRandomOrder();
        $i2b = $i2b->addSelect(['business_category_name' => BusinessCategoryDetail::whereColumn('i2b.business_category_id', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

        return $i2b->limit($limit)->get();
    }
}

if (!function_exists("getInquiryById")) {
    function getInquiryById($inquiryId, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $i2b = I2b::with(['i2bDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->whereId($inquiryId);
        $i2b = $i2b->addSelect(['business_category_name' => BusinessCategoryDetail::whereColumn('i2b.business_category_id', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

        return $i2b->first();
    }
}

if (!function_exists("getAllTestimonials")) {
    function getAllTestimonials($paginateNumber = null, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $testimonial = Testimonial::with(['businessCategory.businessCategoryDetail'])
            ->with(['testimonialDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])
            ->where('status', 'active') // Only fetch active testimonials
            ->latest();

        if (isset($paginateNumber)) {
            return $testimonial->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $testimonial->get();
        }
        return $testimonial->limit(9)->get();
    }
}
if (!function_exists("getAllSuccessStories")) {
    function getAllSuccessStories($paginateNumber = null, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $successStorie = SuccessStories::with(['successStoriesDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])
        ->where('status', 'active')
        ->latest();
        if (isset($paginateNumber)) {
            return $successStorie->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $successStorie->get();
        }

        return $successStorie->limit(9)->get();
    }
}
// if (!function_exists("getAllSponsors")) {
//     function getAllSponsors($paginateNumber = null)
//     {
//         $sponsors = Banner::where('type', 'sponsor')
//             ->where('is_visible', true)
//             ->orderBy('small_business_description', 'asc')  // Only fetch checked records
//             ->latest();

//         if (isset($paginateNumber)) {
//             return $sponsors->paginate($paginateNumber);
//         }

//         if ($paginateNumber == 0) {
//             return $sponsors->get();
//         }

//         return $sponsors->limit(9)->get();
//     }
// }

// Legacy function - keep for backward compatibility with old banner-based sponsors
if (!function_exists("getAllSponsorsLegacy")) {
    function getAllSponsorsLegacy($paginateNumber = null)
    {
        $sponsors = Banner::where('type', 'sponsor')
            ->where('is_active', 'active')
            ->orderBy('business_name', 'asc')
            ->latest();

        if (isset($paginateNumber)) {
            return $sponsors->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $sponsors->get();
        }

        return $sponsors->limit(9)->get();
    }
}

// New function using sponsors table
if (!function_exists("getAllSponsors")) {
    function getAllSponsors($paginateNumber = null)
    {
        $sponsors = \App\Models\Sponsor::where('status', 'active')
            ->where('is_visible', true)
            ->where('payment_status', 'paid')
            ->with(['logoMedia', 'featuredMedia'])
            ->orderBy('business_name', 'asc')
            ->latest();

        if (isset($paginateNumber)) {
            return $sponsors->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $sponsors->get();
        }

        return $sponsors->limit(9)->get();
    }
}
if (!function_exists("getCustomerSponsors")) {
    function getCustomerSponsors($paginateNumber = null)
    {
        $loggedInCustomer = auth()->guard('customers')->user();

        if (!$loggedInCustomer) {
            return collect([]); // Return empty collection if not logged in
        }

        $sponsors = \App\Models\Sponsor::where('customer_id', $loggedInCustomer->id)
            ->with(['logoMedia', 'featuredMedia', 'beneficiary'])
            ->orderBy('created_at', 'desc');

        if (isset($paginateNumber)) {
            return $sponsors->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $sponsors->get();
        }

        return $sponsors->limit(9)->get();
    }
}

if (!function_exists("getBanners")) {
    function getBanners($type = 'banners', $limit = 3)
    {
        // Sort sponsors alphabetically by business_name
        if ($type === 'sponsor') {
            return Banner::whereType($type)->with('media')->orderBy('business_name', 'asc')->limit($limit)->get();
        }
        return Banner::whereType($type)->with('media')->limit($limit)->latest()->get();
    }
}

// if (!function_exists("getRandomBanners")) {
//     function getRandomBanners($type = 'banners', $limit = 3)
//     {
//         return Banner::whereType($type)->with('media')->limit($limit)->inRandomOrder()->get();
//     }
// }
if (!function_exists("getRandomBanners")) {
    function getRandomBanners($type = 'banners', $limit = 3,$status = 'active')
    {
        // If type is 'sponsor', use new sponsors table
        if ($type === 'sponsor') {
            return \App\Models\Sponsor::where('status', 'active')
                ->where('is_visible', true)
                ->where('payment_status', 'paid')
                ->with(['logoMedia', 'featuredMedia'])
                ->orderBy('business_name', 'asc')
                ->limit($limit)
                ->get();
        }
        
        // Otherwise use old banners table
        return Banner::whereType($type)->with('media')->where('is_visible', '1')->where('is_active', $status)->limit($limit)->inRandomOrder()->get();
    }
}
if (!function_exists("getAllMagazines")) {
    function getAllMagazines($paginateNumber = null, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $issues = Issue::with('media')->with(['issueDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->latest();
        if (isset($paginateNumber)) {
            return $issues->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $issues->get();
        }

        return $issues->limit(9)->get();
    }
}

// if (!function_exists("getAllEvents")) {
//     function getAllEvents($paginateNumber = null, $defaultLang = null, $orderBy = 'price')
//     {
//         if (!$defaultLang) {
//             $defaultLang = getDefaultLanguage(1);
//         }
//         $events = Event::with('media')->with(['eventDetail' => function ($q) use ($defaultLang) {
//             $q->where('language_id', $defaultLang->id);
//         }])->whereDate('end_date', '>=', date('Y-m-d'));

//         $events = $events->addSelect([
//             'package_type' => Customer::whereColumn('customers.id', 'events.customer_id')
//                 ->select(['package_type' => RegistrationPackage::whereColumn('customers.registration_package_id', 'registration_packages.id')->select('package_type')])
//         ]);


//         if (isset($orderBy) && $orderBy == 'package_type') {
//             $events = $events->orderByRaw("FIELD(package_type, 'featured', 'premium', 'free') DESC");
//         } else if (isset($orderBy) && $orderBy == 'created_at') {
//             $events = $events->orderBy('created_at', 'desc');
//         } else {
//             $events = $events->orderBy('package_price', 'desc');
//         }
//         if (isset($paginateNumber)) {
//             return $events->paginate($paginateNumber);
//         }

//         if ($paginateNumber == 0) {
//             return $events->get();
//         }

//         return $events->limit(9)->get();
//     }
// }

if (!function_exists("getAllEvents")) {
    function getAllEvents($paginateNumber = null, $defaultLang = null, $orderBy = 'title', $search = null, $eventCategories = null, $countries = null, $sorting = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }

        $events = Event::with('media')
            ->with(['eventDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])
            ->join('event_detail', 'events.id', '=', 'event_detail.event_id')
            ->where('event_detail.language_id', $defaultLang->id)
            ->select('events.*', 'event_detail.title', 'event_detail.country', 'event_detail.venue', 'event_detail.short_description', 'event_detail.product_search','event_detail.description','event_detail.street_name','event_detail.city','event_detail.country')
            ->leftJoin('customers', 'events.customer_id', '=', 'customers.id')
            ->leftJoin('registration_packages', 'customers.registration_package_id', '=', 'registration_packages.id')
            ->addSelect('registration_packages.package_type')
            ->orderByRaw("FIELD(registration_packages.package_type, 'featured', 'premium', 'free') DESC")
            ->orderBy('event_detail.title', 'asc');

        // Apply search filter
        if ($search) {
            $events->where(function ($query) use ($search) {
                $query->where('event_detail.title', 'like', '%' . $search . '%')
                      ->orWhere('event_detail.venue', 'like', '%' . $search . '%')
                      ->orWhere('event_detail.short_description', 'like', '%' . $search . '%')
                      ->orWhere('event_detail.product_search', 'like', '%' . $search . '%')
                      ->orWhere('event_detail.description', 'like', '%' . $search . '%')
                      ->orWhere('event_detail.country', 'like', '%' . $search . '%')
                      ->orWhere('event_detail.city', 'like', '%' . $search . '%')
                      ->orWhere('event_detail.street_name', 'like', '%' . $search . '%');
            });
        }

        // Apply event categories filter
        if ($eventCategories && !in_array('all', $eventCategories)) {
            $events->whereIn('event_detail.id', $eventCategories);
        }

        // Apply countries filter
        if ($countries && !in_array('all', $countries)) {
            $events->whereIn('event_detail.country', $countries);
        }

        // Handle sorting
        if ($sorting === 'display_past_events') {
            $events->whereDate('end_date', '<', date('Y-m-d'));
        } else {
            $events->whereDate('end_date', '>=', date('Y-m-d'));
        }

        // Paginate or return results
        if (isset($paginateNumber)) {
            return $events->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $events->get();
        }

        return $events->limit(9)->get();
    }
}
if (!function_exists('getAllEventCategories')) {
    function getAllEventCategories() {
        return \App\Models\EventDetail::distinct()
            ->whereNotNull('title') // Fetch only records with a non-null title
            ->pluck('title', 'id') // Use 'title' as the value and 'id' as the key
            ->toArray(); // Convert the result to an array
    }
}

// if (!function_exists("getAllEvents")) {
//     function getAllEvents($paginateNumber = null, $defaultLang = null, $orderBy = 'title')
//     {
//         if (!$defaultLang) {
//             $defaultLang = getDefaultLanguage(1);
//         }

//         $events = Event::with('media')
//             ->with(['eventDetail' => function ($q) use ($defaultLang) {
//                 $q->where('language_id', $defaultLang->id);
//             }])
//             ->whereDate('end_date', '>=', date('Y-m-d'));

//         // Add package type selection
//         $events = $events->addSelect([
//             'package_type' => Customer::whereColumn('customers.id', 'events.customer_id')
//                 ->select(['package_type' => RegistrationPackage::whereColumn('customers.registration_package_id', 'registration_packages.id')->select('package_type')])
//         ]);

//         // Ensure proper ordering using LEFT JOIN
//         $events = $events->leftJoin('event_detail', function ($join) use ($defaultLang) {
//             $join->on('event_detail.event_id', '=', 'events.id')
//                  ->where('event_detail.language_id', '=', $defaultLang->id);
//         })->orderBy('event_detail.title', 'asc')
//           ->select('events.*');

//         // Handle pagination
//         if (isset($paginateNumber) && $paginateNumber > 0) {
//             return $events->paginate($paginateNumber);
//         }

//         return $events->limit(9)->get();
//     }
// }




if (!function_exists("getFeaturedEvents")) {
    function getFeaturedEvents($defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $events = Event::with('media')->with(['eventDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->orderBy('package_price', 'desc')->whereDate('end_date', '>=', date('Y-m-d'));

        return $events->limit(6)->get();
    }
}

if (!function_exists("getAllFaqs")) {
    function getAllFaqs($type, $paginateNumber = null, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $faqs = Faq::where('type', $type)->with(['faqDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->latest();
        if (isset($paginateNumber)) {
            return $faqs->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $faqs->get();
        }

        return $faqs->limit(9)->get();
    }
}

if (!function_exists("getAllUpcomingExportingFairs")) {
    function getAllUpcomingExportingFairs($paginateNumber = null, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $exportingFairs = ExportingFair::with(['exportingFairDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->where('end_date', '>', date('Y-m-d'))->latest();
        Log::info("exportingFairs", ['sdf' => $exportingFairs->get()]);
        if (isset($paginateNumber)) {
            return $exportingFairs->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $exportingFairs->get();
        }

        return $exportingFairs->limit(9)->get();
    }
}

if (!function_exists("getAllOneMoreThings")) {
    function getAllOneMoreThings($paginateNumber = null, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $oneMoreThings = OneMoreThing::with(['oneMoreThingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->latest();
        if (isset($paginateNumber)) {
            return $oneMoreThings->paginate($paginateNumber);
        }

        if ($paginateNumber == 0) {
            return $oneMoreThings->get();
        }

        return $oneMoreThings->limit(9)->get();
    }
}

if (!function_exists("getCurrentIssue")) {
    function getCurrentIssue($defaultLang)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $issues = Issue::with('media')->with(['issueDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        return $issues->first();
    }
}

if (!function_exists("getLatestCurrentIssue")) {
    function getLatestCurrentIssue($defaultLang)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $issues = Issue::with('media')->with(['issueDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        return $issues->latest()->limit(6)->get();
    }
}

if (!function_exists("getMainMenu")) {
    function getMainMenu($defaultLang)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $menu = Menu::where('is_main_menu', '1')->with(['menuDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        return $menu->first();
    }
}

if (!function_exists("langBasedURL")) {
    function langBasedURL($defaultLang, $url, $newLanguage = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }

        if ($url === null || trim($url) === '') {
            return $url;
        }

        $appUrl = rtrim(config('app.url') ?? env('APP_URL'), '/');

        if (!$appUrl) {
            return $url;
        }

        static $languageCodes = null;

        if ($languageCodes === null) {
            $languageCodes = Language::pluck('abbreviation')
                ->filter()
                ->map(fn ($code) => strtolower($code))
                ->values()
                ->toArray();
        }

        $targetLanguage = $defaultLang;

        if ($newLanguage) {
            $targetLanguage = Language::find($newLanguage) ?? $defaultLang;
        }

        $targetAbbreviation = $targetLanguage->abbreviation;
        $normalizedTarget = strtolower($targetAbbreviation);
        $normalizedUrl = trim($url);
        $isAbsolute = (bool) preg_match('#^https?://#i', $normalizedUrl);

        $normalizeHost = static function ($host) {
            $host = strtolower($host ?? '');

            if (str_starts_with($host, 'www.')) {
                return substr($host, 4);
            }

            return $host;
        };

        $parsed = $isAbsolute
            ? parse_url($normalizedUrl)
            : parse_url('https://placeholder/' . ltrim($normalizedUrl, '/'));

        $path = ltrim($parsed['path'] ?? '', '/');
        $query = $parsed['query'] ?? null;
        $fragment = $parsed['fragment'] ?? null;

        $appHost = $normalizeHost(parse_url($appUrl, PHP_URL_HOST));

        if ($isAbsolute) {
            $urlHost = $normalizeHost($parsed['host'] ?? '');

            if ($urlHost && $urlHost !== $appHost) {
                return $normalizedUrl;
            }
        }

        $segments = $path === '' ? [] : explode('/', $path);

        if (!empty($segments)) {
            $firstSegment = strtolower($segments[0]);

            if (in_array($firstSegment, $languageCodes, true)) {
                array_shift($segments);
            }
        }

        if ($normalizedTarget !== '' && ($segments === [] || strtolower($segments[0]) !== $normalizedTarget)) {
            array_unshift($segments, $targetAbbreviation);
        }

        $segments = array_values(array_filter($segments, static fn ($segment) => $segment !== ''));
        $normalizedPath = implode('/', $segments);

        if ($normalizedPath === '') {
            $normalizedPath = $targetAbbreviation;
        }

        if ($isAbsolute) {
            $rebuiltUrl = rtrim($appUrl, '/') . '/' . $normalizedPath;
        } else {
            $rebuiltUrl = url($normalizedPath);
        }

        if ($query) {
            $rebuiltUrl .= '?' . $query;
        }

        if ($fragment) {
            $rebuiltUrl .= '#' . $fragment;
        }

        return $rebuiltUrl;
    }
}

if (!function_exists("updateLangByAbber")) {
    function updateLangByAbber($abbreviation)
    {
        $language = Language::where('abbreviation', $abbreviation)->first();
        if (!$language) {
            $language = getDefaultLanguage(true);
        }
        Session::put('webLanguage', $language->id);
        return 1;
    }
}

if (!function_exists("countEndingDigits")) {
    function countEndingDigits($string)
    {
        $tailing_number_digits =  0;
        $i = 0;
        $from_end = -1;
        while ($i < strlen($string)) {
            if (is_numeric(substr($string, $from_end - $i, 1))) {
                $tailing_number_digits++;
            } else {
                break;
            }
            $i++;
        }
        return $tailing_number_digits;
    }
}

if (!function_exists("checkSlug")) {
    function checkSlug($slug)
    {
        if (BusinessCategory::whereSlug($slug)->count() > 0) {
            $numIn = countEndingDigits($slug);
            if ($numIn > 0) {
                $base_portion = substr($slug, 0, -$numIn);
                $digits_portion = abs(substr($slug, -$numIn));
            } else {
                $base_portion = $slug . "-";
                $digits_portion = 0;
            }

            $slug = $base_portion . intval($digits_portion + 1);
            $slug = checkSlug($slug);
        }

        return $slug;
    }
}

if (!function_exists("getI2bModalSetting")) {
    function getI2bModalSetting($defaultLang = null, $type = [])
    {

        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }

        $staticTranslation = StaticTranslation::whereIn('type', $type)->pluck('id');

        $staticTranslationDetail = StaticTranslationDetail::whereIn('static_translation_id', $staticTranslation)->whereLanguageId($defaultLang->id)->pluck('value', 'key');
     // dd($staticTranslationDetail);
    // Log::info("staticTranslationDetail", ['sdf' => $staticTranslationDetail]); 
        return $staticTranslationDetail;
    }
}

if (!function_exists("getStaticTranslationByKey")) {
    function getStaticTranslationByKey($defaultLang = null, $type = null, $keys = [])
    {

        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }

        $staticTranslation = StaticTranslation::where('type', $type)->pluck('id');

        $staticTranslationDetail = StaticTranslationDetail::whereIn('static_translation_id', $staticTranslation)->whereIn('key', $keys)->whereLanguageId($defaultLang->id)->pluck('value', 'key');

        return $staticTranslationDetail;
    }
}

if (!function_exists("getAdvertiserSetting")) {
    function getAdvertiserSetting($page, $defaultLang = null)
    {

        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }

        $advertiserSetting = AdvertiserSetting::wherePageId($page->id)->with(['advertiserSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $advertiserSetting;
    }
}

if (!function_exists("getCustomerResource")) {
    function getCustomerResource()
    {

        $customer = Customer::whereId(auth()->guard('customers')->user()->id)->with(['customerMedia.customerLogo'])->with(['customerMedia.customerGalleryImages.media'])->first();
        $customer = new CustomerResource($customer);
        return $customer;
    }
}

if (!function_exists("getCustomerResourceWithProfileImage")) {
    function getCustomerResourceWithProfileImage()
    {

        $customer = Customer::whereId(auth()->guard('customers')->user()->id)->with(['profileImage'])->first();
        $customer = new CustomerResource($customer);
        return $customer;
    }
}

// if (!function_exists("getCustomerBannerResource")) {
//     function getCustomerBannerResource()
//     {

//         $sponsor = Banner::whereCustomerId(auth()->guard('customers')->user()->id)->with('media')->first();
//         $sponsor = new BannerResource($sponsor);
//         return $sponsor;
//     }
// }
if (!function_exists("getCustomerBannerResource")) {
    function getCustomerBannerResource()
    {
        $sponsor = Banner::whereCustomerId(auth()->guard('customers')->user()->id)->with('media')->first();
        if (!$sponsor) {
            $sponsor = Banner::with('media')->first();
        }
        $sponsor = new BannerResource($sponsor);

        return $sponsor;
    }
}

if (!function_exists("getCustomerSponsorResource")) {
    function getCustomerSponsorResource()
    {
        $customerId = auth()->guard('customers')->user()->id;
        
        // Try to find sponsor in new sponsors table first
        $sponsor = \App\Models\Sponsor::where('customer_id', $customerId)
            ->with(['logoMedia', 'featuredMedia', 'beneficiary'])
            ->first();
        
        if ($sponsor) {
            return new \App\Http\Resources\Web\SponsorResource($sponsor);
        }
        
        // Fallback to old banners table for backward compatibility
        $banner = Banner::whereCustomerId($customerId)->with('media')->first();
        if ($banner) {
            return new BannerResource($banner);
        }
        
        return null;
    }
}

if (!function_exists("getMediaById")) {
    function getMediaById($mediaId = null)
    {

        $media = Media::whereId($mediaId)->first();
        return $media;
    }
}

if (!function_exists("getAllCountriesFromI2b")) {
    function getAllCountriesFromI2b($defaultLang)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }
        $countries = I2bDetail::whereLanguageId($defaultLang->id)->distinct('country_name')->pluck('country_name');
        return $countries;
    }
}

if (!function_exists("getEventById")) {
    function getEventById($id)
    {
        $event = Event::where('customer_id', Auth::guard('customers')->user()->id)->whereId($id);
        $event = $event->loadMissing('media');
        $event = $event->loadMissing('eventMedia');
        $event = $event->loadMissing('eventMedia.media');
        $event = $event->loadMissing('eventDetail');
        $event = $event->loadMissing('eventContacts');
        return $event->firstOrFail();
    }
}


if (!function_exists("getWidgetById")) {
    function getWidgetById($id, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }
        $widget = Widget::whereId($id)->with(['widgetDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $widget;
    }
}

/**
 * Email Subscription Helper Functions
 * These functions help manage email subscriptions and unsubscribe links
 */

if (!function_exists("isEmailSubscribed")) {
    /**
     * Check if an email address is subscribed to receive emails
     * 
     * @param string $email
     * @return bool
     */
    function isEmailSubscribed(string $email): bool
    {
        $service = app(\App\Services\EmailSubscriptionService::class);
        return $service->isSubscribed($email);
    }
}

if (!function_exists("generateUnsubscribeLink")) {
    /**
     * Generate an unsubscribe link for any email address
     * 
     * @param string $email
     * @param string $type Type of email: 'auto', 'customer', or 'newsletter'
     * @return string|null
     */
    function generateUnsubscribeLink(string $email, string $type = 'auto'): ?string
    {
        $service = app(\App\Services\EmailSubscriptionService::class);
        return $service->generateUnsubscribeLink($email, $type);
    }
}

if (!function_exists("canSendEmailTo")) {
    /**
     * Check if an email can be sent to a recipient (alias for isEmailSubscribed)
     * 
     * @param string $email
     * @return bool
     */
    function canSendEmailTo(string $email): bool
    {
        return isEmailSubscribed($email);
    }
}

if (!function_exists("sendEmailIfSubscribed")) {
    /**
     * Send email only if the recipient is subscribed
     * Use this for marketing/promotional emails
     * 
     * @param string $email The recipient email address
     * @param \Illuminate\Mail\Mailable $mailable The email to send
     * @param bool $queue Whether to queue the email (default: false)
     * @return bool True if sent, false if not subscribed or failed
     */
    function sendEmailIfSubscribed(string $email, $mailable, bool $queue = false): bool
    {
        $service = app(\App\Services\EmailSubscriptionService::class);
        return $service->sendIfSubscribed($email, $mailable, $queue);
    }
}

if (!function_exists("sendBulkEmailIfSubscribed")) {
    /**
     * Send email to multiple recipients, filtering out unsubscribed users
     * Use this for marketing/promotional bulk emails
     * 
     * @param array $emails Array of email addresses
     * @param \Illuminate\Mail\Mailable $mailable The email to send
     * @param bool $queue Whether to queue the email (default: false)
     * @return array ['sent' => int, 'skipped' => int, 'failed' => int]
     */
    function sendBulkEmailIfSubscribed(array $emails, $mailable, bool $queue = false): array
    {
        $service = app(\App\Services\EmailSubscriptionService::class);
        return $service->sendBulkIfSubscribed($emails, $mailable, $queue);
    }
}

if (!function_exists('getImageUrl')) {
    /**
     * Get properly encoded image URL for display
     * Handles special characters in filenames and resolves correct path
     * 
     * @param string|null $path The image path from database
     * @param bool $useStorage Whether to use /storage/ prefix (default: false for public/)
     * @return string The full URL with proper encoding
     */
    function getImageUrl(?string $path, bool $useStorage = false): string
    {
        if (empty($path)) {
            return '';
        }
        
        // If it's already a full URL, return as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        
        // Encode special characters in each path segment
        $pathParts = explode('/', $path);
        $encodedParts = array_map(fn($part) => rawurlencode($part), $pathParts);
        $encodedPath = implode('/', $encodedParts);
        
        // Build URL based on storage type
        $prefix = $useStorage ? '/storage/' : '/';
        return $prefix . $encodedPath;
    }
}

if (!function_exists('getWebPublicPath')) {
    /**
     * Get the correct public path for file storage
     * Handles Hostinger and similar shared hosting where web root differs from Laravel public
     * 
     * @param string $path Optional subpath to append
     * @return string The full filesystem path to the web-accessible public directory
     */
    function getWebPublicPath(string $path = ''): string
    {
        // Get the document root (web root) - this is what the browser can access
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? public_path();
        
        // On Hostinger, document root is typically public_html/
        // Laravel's public_path() might be public_html/src/public/
        // We want to use the document root (web root) for file storage
        
        // Check if we're in a subdirectory structure (like src/public/)
        $laravelPublic = public_path();
        $webRoot = rtrim($documentRoot, DIRECTORY_SEPARATOR);
        
        // If Laravel public is inside web root, use web root
        // Otherwise, use Laravel public (for local development)
        if (strpos($laravelPublic, $webRoot) === 0) {
            // Laravel public is inside web root, use web root
            $basePath = $webRoot;
        } else {
            // Use Laravel public path (local development)
            $basePath = $laravelPublic;
        }
        
        // Append the subpath if provided
        if (!empty($path)) {
            $path = ltrim($path, DIRECTORY_SEPARATOR . '/\\');
            return $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        }
        
        return $basePath;
    }
}