<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PageResource;
use App\Models\AboutUsPageSetting;
use App\Models\ScamAlertSettingDetail;
use App\Models\ScamAlertSetting;
use App\Models\TestimonialSettingDetail;
use App\Models\TestimonialSetting;
use App\Models\SuccessStoriesSettingDetail;
use App\Models\SuccessStoriesSetting;
use App\Models\AboutUsPageSettingDetail;
use App\Models\AdvertiserSetting;
use App\Models\AdvertiserSettingDetail;
use App\Models\BecomeSponsorSetting;
use App\Models\BecomeSponsorSettingDetail;
use App\Models\CloseAccountSetting;
use App\Models\CloseAccountSettingDetail;
use App\Models\CommentsSetting;
use App\Models\CommentsSettingDetail;
use App\Models\SponsorPageSetting;
use App\Models\SponsorPageSettingDetail;
use App\Models\EventSignupSetting;
use App\Models\EventSignupSettingDetail;
use App\Models\HomePageSetting;
use App\Models\ContactUsSetting;
use App\Models\ContactUsSettingDetail;
use App\Models\EventCreateSetting;
use App\Models\EventCreateSettingDetail;
use App\Models\EventListingSetting;
use App\Models\EventListingSettingDetail;
use App\Models\ExportingFairSetting;
use App\Models\ExportingFairSettingDetail;
use App\Models\FinancingProgramSetting;
use App\Models\FinancingProgramSettingDetail;
use App\Models\ContactForRateSetting;
use App\Models\ContactForRateSettingDetail;
use App\Models\ForgetPageSetting;
use App\Models\ForgetPageSettingDetail;
use App\Models\GeneralSetting;
use App\Models\HomePageFeaturedExporter;
use App\Models\InfoLetterSetting;
use App\Models\HomePageSettingDetail;
use App\Models\I2BSetting;
use App\Models\I2BSettingDetail;
use App\Models\EventSetting;
use App\Models\EventSettingDetail;
use App\Models\InfoLetterSettingDetail;
use App\Models\LoginPageSetting;
use App\Models\LoginPageSettingDetail;
use App\Models\OneMoreThingSetting;
use App\Models\OneMoreThingSettingDetail;
use App\Models\Page;
use App\Models\PageDetail;
use App\Models\RatesSetting;
use App\Models\RatesSettingDetail;
use App\Models\FaqExporterSetting;
use App\Models\FaqExporterSettingDetail;
use App\Models\FaqImporterSetting;
use App\Models\FaqImporterSettingDetail;
use App\Models\OnlineBusinessDirectorySetting;
use App\Models\OnlineBusinessDirectorySettingDetail;
use App\Models\RegPageSetting;
use App\Models\RegPageSettingDetail;
use App\Models\SponserListingSetting;
use App\Models\SponserListingSettingDetail;
use App\Services\AboutUsPageSettingService;
use App\Services\FaqExporterSettingService;
use App\Services\FaqImporterSettingService;
use App\Services\AdvertiserSettingService;
use App\Services\BecomeSponsorSettingService;
use App\Services\CloseAccountSettingService;
use App\Services\CommentsSettingService;
use App\Services\SponsorPageSettingService;
use App\Services\EventSignupSettingService;
use App\Services\ContactUsSettingService;
use App\Services\EventCreateSettingService;
use App\Services\EventListingSettingService;
use App\Services\ScamAlertSettingService;
use App\Services\TestimonialSettingService;
use App\Services\SuccessStoriesSettingService;
use App\Services\ExportingFairSettingService;
use App\Services\FinancingProgramSettingService;
use App\Services\ContactForRateSettingService;
use App\Services\ForgetPageSettingService;
use App\Services\InfoLetterSettingService;
use Illuminate\Support\Str;
use App\Services\HomePageSettingService;
use App\Services\I2BSettingService;
use App\Services\EventSettingService;
use App\Services\LoginPageSettingService;
use App\Services\OneMoreThingSettingService;
use App\Services\OnlineBusinessDirectorySettingService;
use App\Services\RatesSettingService;
use App\Services\RegistrationPageSettingService;
use App\Services\SponserListingSettingService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $pages = Page::query();

        $pages = $this->whereClause($pages);
        $pages = $this->loadRelations($pages);
        $pages = $this->sortingAndLimit($pages);

        return $this->apiSuccessResponse(PageResource::collection($pages), 'Data Get Successfully!');
    }


    public function show(Page $page)
    {
        if (isset($_GET['withPageDetail']) && $_GET['withPageDetail'] == '1') {
            $page = $page->loadMissing('pageDetail');
        }
        if (isset($_GET['withMetaImages']) && $_GET['withMetaImages'] == '1') {
            $pages = $page->loadMissing(['facebook']);
        }

        return $this->apiSuccessResponse(new PageResource($page), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $validationRule = array_merge($validationRule, ['facebook_media_id' => ['nullable', 'string']]);
        $validationRule = array_merge($validationRule, ['template' => ['nullable', 'in:login_template,register_template,home_template,about_us_template,contact_us_template,comments_template,rates_template,close_account_template,advertiser_page_template,forget_page_template,inquiries_to_buy_template,testimonial_template,event_template,info_letter_template,sponsor_listing,event_signup_template,event_create_template,faq_exporter_template,faq_importer_template,magazine_template,event_listing_template,sponser_listing_template,become_sponsor_template,one_more_thing_template,exporting_fair_template,financing_program_template,contact_for_rates_template,sponser_listing,scam_alert_template,success_stories_template,online_business_directory_template']]);

        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Meta description in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['meta_keywords.meta_keywords_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['meta_keywords.meta_keywords_' . $language->id . '.required' => 'Meta keywords in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['page_detail.page_detail_' . $language->id => ['nullable']]);
            $errorMessages = array_merge($errorMessages, ['page_detail.page_detail_' . $language->id . '.required' => 'Page detail in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['edit_page_detail.edit_page_detail_' . $language->id => ['nullable']]);
            $errorMessages = array_merge($errorMessages, ['edit_page_detail.edit_page_detail_' . $language->id . '.required' => 'Page detail for edit in ' . $language->name . ' is required.']);
        }
        // dd($request->template);
        if (isset($request->template)) {
            if ($request->template == 'home_template') {
                $pageSettingService = new HomePageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'about_us_template') {
                $pageSettingService = new AboutUsPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'sponsor_listing') {
                $pageSettingService = new SponsorPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'event_signup_template') {
                $pageSettingService = new EventSignupSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'event_create_template') {
                $pageSettingService = new EventCreateSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'contact_us_template') {
                $pageSettingService = new ContactUsSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'inquiries_to_buy_template') {
                $pageSettingService = new I2BSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }else if ($request->template == 'event_template') {
                $pageSettingService = new EventSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
             else if ($request->template == 'comments_template') {
                $pageSettingService = new CommentsSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'rates_template') {
                $pageSettingService = new RatesSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'close_account_template') {
                $pageSettingService = new CloseAccountSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'event_listing_template') {
                $pageSettingService = new EventListingSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'sponser_listing_template') {
                $pageSettingService = new SponserListingSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'advertiser_page_template') {
                $pageSettingService = new AdvertiserSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'forget_page_template') {
                $pageSettingService = new ForgetPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'become_sponsor_template') {
                $pageSettingService = new BecomeSponsorSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'online_business_directory_template') {
                $pageSettingService = new OnlineBusinessDirectorySettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'one_more_thing_template') {
                $pageSettingService = new OneMoreThingSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'exporting_fair_template') {
                $pageSettingService = new ExportingFairSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'financing_program_template') {
                $pageSettingService = new FinancingProgramSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'contact_for_rates_template') {
                $pageSettingService = new ContactForRateSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }else if ($request->template == 'scam_alert_template') {
                $pageSettingService = new ScamAlertSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'testimonial_template') {
                $pageSettingService = new TestimonialSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'success_stories_template') {
                $pageSettingService = new SuccessStoriesSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'faq_exporter_template') {
                $pageSettingService = new FaqExporterSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'faq_importer_template') {
                $pageSettingService = new FaqImporterSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
             else if ($request->template == 'info_letter_template') {
                $pageSettingService = new InfoLetterSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'register_template') {
                $pageSettingService = new RegistrationPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'login_template') {
                $pageSettingService = new LoginPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
        }

        $niceName = [];
        $niceName['facebook_media_id'] = 'Facebook media';

        $this->validate(
            $request,
            $validationRule,
            $errorMessages,
            $niceName
        );

        if (isset($request->facebook_media_id)) {
            $media = json_decode($request->facebook_media_id, 1);
            $facebook = $this->moveFile($media, 'media/pages', 'meta_info');
        }

        $page = Page::create([
            'template' => isset($request->template) ? $request->template : null,
            'facebook_media_id' => isset($facebook, $facebook[0]) ? $facebook[0]['id'] : null,
            'is_home_page' => $request->is_home_page,
            'after_header_widget_id' => $request->after_header_widget_id ?? null,
            'before_footer_widget_id' => $request->before_footer_widget_id ?? null,
        ]);
        if ($request->is_home_page) {
            $this->resetAsHomePage($page);
        }
        if ($request->template == 'home_template') {
            $homePageSetting = HomePageSetting::create([
                'page_id' => $page->id,
                'number_of_featured_exporters' => $request->number_of_featured_exporters ?? null,
                'header_widget_id' => $request->header_widget_id ?? null,
                'business_category_widget_id' => $request->business_category_widget_id ?? null,
                'i2b_widget_id' => $request->i2b_widget_id ?? null,
                'sponsor_widget_id' => $request->sponsor_widget_id ?? null,
                'business_widget_id' => $request->business_widget_id ?? null,
                'events_widget_id' => $request->events_widget_id ?? null,
                'magazine_widget_id' => $request->magazine_widget_id ?? null,
            ]);
            if (isset($request->business_categories) && is_array($request->business_categories)) {
                HomePageFeaturedExporter::wherePageId($page->id)->delete();
                foreach ($request->business_categories as $key => $business_category) {
                    HomePageFeaturedExporter::create([
                        'business_category_id' => $business_category,
                        'page_id' => $page->id,
                    ]);
                }
            }

        } else if ($request->template == 'about_us_template') {
            $aboutUsPageSetting = AboutUsPageSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'sponsor_listing') {
            $sponsorPageSetting = SponsorPageSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'event_signup_template') {
            $eventSignupSetting = EventSignupSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'event_create_template') {
            $eventCreateSetting = EventCreateSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'contact_us_template') {
            $contactUsSetting = ContactUsSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'inquiries_to_buy_template') {
            $i2BSetting = I2BSetting::create([
                'page_id' => $page->id
            ]);
        }else if ($request->template == 'event_template') {
            $eventSetting = EventSetting::create([
                'page_id' => $page->id
            ]);
        }
         else if ($request->template == 'comments_template') {
            $commentsSetting = CommentsSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'rates_template') {
            $ratesSetting = RatesSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'close_account_template') {
            $closeAccountSetting = CloseAccountSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'event_listing_template') {
            $eventListingSetting = EventListingSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'sponser_listing_template') {
            $sponserListingSetting = SponserListingSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'advertiser_page_template') {
            $advertiserSetting = AdvertiserSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'forget_page_template') {
            $forgetPageSetting = ForgetPageSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'become_sponsor_template') {
            $becomeSponsorSetting = BecomeSponsorSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'online_business_directory_template') {
            $onlineBusinessDirectorySetting = OnlineBusinessDirectorySetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'one_more_thing_template') {
            $oneMoreThingSetting = OneMoreThingSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'exporting_fair_template') {
            $exportingFairSetting = ExportingFairSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'financing_program_template') {
            $financingProgramSetting = FinancingProgramSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'contact_for_rates_template') {
            $contactForRateSetting = ContactForRateSetting::create([
                'page_id' => $page->id
            ]);
        }else if ($request->template == 'scam_alert_template') {
            $scamAlertSetting = ScamAlertSetting::create([
                'page_id' => $page->id
            ]);
        }
        else if ($request->template == 'testimonial_template') {
            $testimonialSetting = TestimonialSetting::create([
                'page_id' => $page->id
            ]);
        }
        else if ($request->template == 'success_stories_template') {
            $successStoriesSetting = SuccessStoriesSetting::create([
                'page_id' => $page->id
            ]);
        }
        else if ($request->template == 'faq_exporter_template') {
            $faqExporterSetting = FaqExporterSetting::create([
                'page_id' => $page->id
            ]);
        }
        else if ($request->template == 'faq_importer_template') {
            $faqImporterSetting = FaqImporterSetting::create([
                'page_id' => $page->id
            ]);
        }
        else if ($request->template == 'info_letter_template') {
            $infoLetterSetting = InfoLetterSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'register_template') {
            $regPageSetting = RegPageSetting::create([
                'page_id' => $page->id
            ]);
        } else if ($request->template == 'login_template') {
            $loginPageSetting = LoginPageSetting::create([
                'page_id' => $page->id
            ]);
        }

        foreach ($languages as $language) {
            PageDetail::create([
                'page_id' => $page->id,
                'language_id' => $language->id,
                'name' => isset($request['name']['name_' . $language->id]) ? $request['name']['name_' . $language->id] : null,
                'description' => isset($request['description']['description_' . $language->id]) ? $request['description']['description_' . $language->id] : null,
                'page_detail' => $request['page_detail']['page_detail_' . $language->id],
                'edit_page_detail' => $request['edit_page_detail']['edit_page_detail_' . $language->id],
                'slug' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                'meta_keywords' => $request['meta_keywords']['meta_keywords_' . $language->id],
            ]);
            if ($language->is_default == '1') {
                Page::whereId($page->id)->update([
                    'slug' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                ]);

                if (isset($request->set_as_default_page) && $request->set_as_default_page == true) {

                    if ($request->template == 'register_template') {
                        GeneralSetting::where('key', 'user_signup_page')->where('type', 'pages_setting')->update([
                            'value' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                        ]);
                    } else if ($request->template == 'login_template') {
                        GeneralSetting::where('key', 'user_signin_page')->where('type', 'pages_setting')->update([
                            'value' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                        ]);
                    } else if ($request->template == 'event_signup_template') {
                        GeneralSetting::where('key', 'user_event_signup_page')->where('type', 'pages_setting')->update([
                            'value' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                        ]);
                    } else if ($request->template == 'event_create_template') {
                        GeneralSetting::where('key', 'user_event_create_page')->where('type', 'pages_setting')->update([
                            'value' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                        ]);
                    } else if ($request->template == 'event_listing_template') {
                        GeneralSetting::where('key', 'user_event_listing_page')->where('type', 'pages_setting')->update([
                            'value' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                        ]);
                    }  else if ($request->template == 'sponser_listing_template') {
                        GeneralSetting::where('key', 'user_sponser_listing_page')->where('type', 'pages_setting')->update([
                            'value' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                        ]);
                    } else if ($request->template == 'magazine_template') {
                        GeneralSetting::where('key', 'see_all_magazine_page')->where('type', 'pages_setting')->update([
                            'value' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                        ]);
                    } else if ($request->template == 'contact_us_template') {
                        GeneralSetting::where('key', 'contact_us_page')->where('type', 'pages_setting')->update([
                            'value' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                        ]);
                    } else if ($request->template == 'close_account_template') {
                        GeneralSetting::where('key', 'close_account_page')->where('type', 'pages_setting')->update([
                            'value' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                        ]);
                    }
                }
            }
            if ($request->template == 'home_template') {
                $pageSettingService->store($homePageSetting, $language, $request);
            } else if ($request->template == 'about_us_template') {
                $pageSettingService->store($aboutUsPageSetting, $language, $request);
            } else if ($request->template == 'sponsor_listing') {
                $pageSettingService->store($sponsorPageSetting, $language, $request);
            } else if ($request->template == 'event_signup_template') {
                $pageSettingService->store($eventSignupSetting, $language, $request);
            } else if ($request->template == 'event_create_template') {
                $pageSettingService->store($eventCreateSetting, $language, $request);
            } else if ($request->template == 'contact_us_template') {
                $pageSettingService->store($contactUsSetting, $language, $request);
            } else if ($request->template == 'inquiries_to_buy_template') {
                $pageSettingService->store($i2BSetting, $language, $request);
            }else if ($request->template == 'event_template') {
                $pageSettingService->store($eventSetting, $language, $request);
            }
             else if ($request->template == 'comments_template') {
                $pageSettingService->store($commentsSetting, $language, $request);
            } else if ($request->template == 'rates_template') {
                $pageSettingService->store($ratesSetting, $language, $request);
            } else if ($request->template == 'close_account_template') {
                $pageSettingService->store($closeAccountSetting, $language, $request);
            } else if ($request->template == 'event_listing_template') {
                $pageSettingService->store($eventListingSetting, $language, $request);
            }  else if ($request->template == 'sponser_listing_template') {
                $pageSettingService->store($sponserListingSetting, $language, $request);
            } else if ($request->template == 'advertiser_page_template') {
                $pageSettingService->store($advertiserSetting, $language, $request);
            } else if ($request->template == 'forget_page_template') {
                $pageSettingService->store($forgetPageSetting, $language, $request);
            } else if ($request->template == 'become_sponsor_template') {
                $pageSettingService->store($becomeSponsorSetting, $language, $request);
            } else if ($request->template == 'online_business_directory_template') {
                $pageSettingService->store($onlineBusinessDirectorySetting, $language, $request);
            } else if ($request->template == 'one_more_thing_template') {
                $pageSettingService->store($oneMoreThingSetting, $language, $request);
            } else if ($request->template == 'exporting_fair_template') {
                $pageSettingService->store($exportingFairSetting, $language, $request);
            } else if ($request->template == 'financing_program_template') {
                $pageSettingService->store($financingProgramSetting, $language, $request);
            } else if ($request->template == 'contact_for_rates_template') {
                $pageSettingService->store($contactForRateSetting, $language, $request);
            }else if ($request->template == 'scam_alert_template') {
                $pageSettingService->store($scamAlertSetting, $language, $request);
            }
            else if ($request->template == 'testimonial_template') {
                $pageSettingService->store($testimonialSetting, $language, $request);
            }
            else if ($request->template == 'success_stories_template') {
                $pageSettingService->store($successStoriesSetting, $language, $request);
            }
            else if ($request->template == 'faq_exporter_template') {
                $pageSettingService->store($faqExporterSetting, $language, $request);
            }
            else if ($request->template == 'faq_importer_template') {
                $pageSettingService->store($faqImporterSetting, $language, $request);
            }
             else if ($request->template == 'info_letter_template') {
                $pageSettingService->store($infoLetterSetting, $language, $request);
            } else if ($request->template == 'register_template') {
                $pageSettingService->store($regPageSetting, $language, $request);
            } else if ($request->template == 'login_template') {
                $pageSettingService->store($loginPageSetting, $language, $request);
            }
        }

        return $this->successResponse([], 'Page has been added successfully.');
    }


    public function update(Request $request, Page $page)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $validationRule = array_merge($validationRule, ['facebook_media_id' => ['nullable', 'string']]);
        $validationRule = array_merge($validationRule, ['template' => ['nullable', 'in:login_template,register_template,home_template,about_us_template,contact_us_template,comments_template,rates_template,close_account_template,advertiser_page_template,forget_page_template,inquiries_to_buy_template,testimonial_template,event_template,info_letter_listing,event_signup_template,event_create_template,faq_exporter_template,faq_importer_template,magazine_template,event_listing_template,sponser_listing_template,become_sponsor_template,one_more_thing_template,exporting_fair_template,financing_program_template,contact_for_rates_template,sponser_listing,scam_alert_template,success_stories_template,online_business_directory_template,info_letter_template,sponsor_listing']]);
        $validationRule = array_merge($validationRule, ['id' => ['required', 'exists:pages,id']]);

        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['page_detail.page_detail_' . $language->id => ['nullable']]);
            $errorMessages = array_merge($errorMessages, ['page_detail.page_detail_' . $language->id . '.required' => 'Page detail in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['edit_page_detail.edit_page_detail_' . $language->id => ['nullable']]);
            $errorMessages = array_merge($errorMessages, ['edit_page_detail.edit_page_detail_' . $language->id . '.required' => 'Page detail for edit in ' . $language->name . ' is required.']);
        }

        if (isset($request->template)) {
            if ($request->template == 'home_template') {
                $pageSettingService = new HomePageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'about_us_template') {
                $pageSettingService = new AboutUsPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'sponsor_listing') {
                $pageSettingService = new SponsorPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'event_signup_template') {
                $pageSettingService = new EventSignupSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'event_create_template') {
                $pageSettingService = new EventCreateSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'contact_us_template') {
                $pageSettingService = new ContactUsSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'inquiries_to_buy_template') {
                $pageSettingService = new I2BSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }else if ($request->template == 'event_template') {
                $pageSettingService = new EventSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
             else if ($request->template == 'comments_template') {
                $pageSettingService = new CommentsSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'rates_template') {
                $pageSettingService = new RatesSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'close_account_template') {
                $pageSettingService = new CloseAccountSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'event_listing_template') {
                $pageSettingService = new EventListingSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'sponser_listing_template') {
                $pageSettingService = new SponserListingSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'advertiser_page_template') {
                $pageSettingService = new AdvertiserSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'forget_page_template') {
                $pageSettingService = new ForgetPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'become_sponsor_template') {
                $pageSettingService = new BecomeSponsorSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'online_business_directory_template') {
                $pageSettingService = new OnlineBusinessDirectorySettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'one_more_thing_template') {
                $pageSettingService = new OneMoreThingSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'exporting_fair_template') {
                $pageSettingService = new ExportingFairSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'financing_program_template') {
                $pageSettingService = new FinancingProgramSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'contact_for_rates_template') {
                $pageSettingService = new ContactForRateSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }else if ($request->template == 'scam_alert_template') {
                $pageSettingService = new ScamAlertSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'testimonial_template') {
                $pageSettingService = new TestimonialSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'success_stories_template') {
                $pageSettingService = new SuccessStoriesSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'faq_exporter_template') {
                $pageSettingService = new FaqExporterSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'faq_importer_template') {
                $pageSettingService = new FaqImporterSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
            else if ($request->template == 'info_letter_template') {
                $pageSettingService = new InfoLetterSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'register_template') {
                $pageSettingService = new RegistrationPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            } else if ($request->template == 'login_template') {
                $pageSettingService = new LoginPageSettingService();
                $response = $pageSettingService->validation($languages, $validationRule, $errorMessages);
                $validationRule = $response['validation_rules'];
                $errorMessages = $response['error_messages'];
            }
        }
        $niceName = [];
        $niceName['facebook_media_id'] = 'Facebook media';

        $this->validate(
            $request,
            $validationRule,
            $errorMessages,
            $niceName
        );

        $page = Page::whereId($request->id)->with(['facebook'])->first();

        if (isset($request->facebook_media_id)) {
            $media = json_decode($request->facebook_media_id, 1);
            if ((isset($media, $media[0], $page->facebook) && $page->facebook->path != $media[0]) || (isset($media, $media[0]) && !isset($page->facebook))) {
                $facebook = $this->moveFile($media, 'media/pages', 'meta_info');
            } else {
                $facebook[0]['id'] = $page->facebook_media_id;
            }
        }

        Page::whereId($request->id)->update([
            'template' => $request->template,
            'facebook_media_id' => isset($facebook, $facebook[0]) ? $facebook[0]['id'] : null,
            'is_home_page' => $request->is_home_page,
            'after_header_widget_id' => $request->after_header_widget_id ?? null,
            'before_footer_widget_id' => $request->before_footer_widget_id ?? null,
        ]);

        if ($request->is_home_page) {
            $this->resetAsHomePage($page);
        }
        if ($request->template == 'home_template') {
            $homePageSetting = HomePageSetting::wherePageId($request->id)->first();
            if (!$homePageSetting) {
                $homePageSetting = HomePageSetting::create([
                    'page_id' => $request->id
                ]);
            }
            $homePageSetting->update([
                'number_of_featured_exporters' => $request->number_of_featured_exporters ?? null,
                'header_widget_id' => $request->header_widget_id ?? null,
                'business_category_widget_id' => $request->business_category_widget_id ?? null,
                'i2b_widget_id' => $request->i2b_widget_id ?? null,
                'sponsor_widget_id' => $request->sponsor_widget_id ?? null,
                'business_widget_id' => $request->business_widget_id ?? null,
                'events_widget_id' => $request->events_widget_id ?? null,
                'magazine_widget_id' => $request->magazine_widget_id ?? null,
            ]);
            if (isset($request->business_categories) && is_array($request->business_categories)) {
                HomePageFeaturedExporter::wherePageId($page->id)->delete();
                foreach ($request->business_categories as $key => $business_category) {
                    HomePageFeaturedExporter::create([
                        'business_category_id' => $business_category,
                        'page_id' => $page->id,
                    ]);
                }
            }
        } else if ($request->template == 'about_us_template') {
            $aboutUsPageSetting = AboutUsPageSetting::wherePageId($request->id)->first();
            if (!$aboutUsPageSetting) {
                $aboutUsPageSetting = AboutUsPageSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'sponsor_listing') {
            $sponsorPageSetting = SponsorPageSetting::wherePageId($request->id)->first();
            if (!$sponsorPageSetting) {
                $sponsorPageSetting = SponsorPageSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'event_signup_template') {
            $eventSignupSetting = EventSignupSetting::wherePageId($request->id)->first();
            if (!$eventSignupSetting) {
                $eventSignupSetting = EventSignupSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'event_create_template') {
            $eventCreateSetting = EventCreateSetting::wherePageId($request->id)->first();
            if (!$eventCreateSetting) {
                $eventCreateSetting = EventCreateSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'contact_us_template') {
            $contactUsSetting = ContactUsSetting::wherePageId($request->id)->first();
            if (!$contactUsSetting) {
                $contactUsSetting = ContactUsSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'inquiries_to_buy_template') {
            $i2BSetting = I2BSetting::wherePageId($request->id)->first();
            if (!$i2BSetting) {
                $i2BSetting = I2BSetting::create([
                    'page_id' => $request->id
                ]);
            }
        }else if ($request->template == 'event_template') {
            $eventSetting = EventSetting::wherePageId($request->id)->first();
            if (!$eventSetting) {
                $eventSetting = EventSetting::create([
                    'page_id' => $request->id
                ]);
            }
        }
         else if ($request->template == 'comments_template') {
            $commentsSetting = CommentsSetting::wherePageId($request->id)->first();
            if (!$commentsSetting) {
                $commentsSetting = CommentsSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'rates_template') {
            $ratesSetting = RatesSetting::wherePageId($request->id)->first();
            if (!$ratesSetting) {
                $ratesSetting = RatesSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'close_account_template') {
            $closeAccountSetting = CloseAccountSetting::wherePageId($request->id)->first();
            if (!$closeAccountSetting) {
                $closeAccountSetting = CloseAccountSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'event_listing_template') {
            $eventListingSetting = EventListingSetting::wherePageId($request->id)->first();
            if (!$eventListingSetting) {
                $eventListingSetting = EventListingSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'sponser_listing_template') {
            $sponserListingSetting = SponserListingSetting::wherePageId($request->id)->first();
            if (!$sponserListingSetting) {
                $sponserListingSetting = SponserListingSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'advertiser_page_template') {
            $advertiserSetting = AdvertiserSetting::wherePageId($request->id)->first();
            if (!$advertiserSetting) {
                $advertiserSetting = AdvertiserSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'forget_page_template') {
            $forgetPageSetting = ForgetPageSetting::wherePageId($request->id)->first();
            if (!$forgetPageSetting) {
                $forgetPageSetting = ForgetPageSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'become_sponsor_template') {
            $becomeSponsorSetting = BecomeSponsorSetting::wherePageId($request->id)->first();
            if (!$becomeSponsorSetting) {
                $becomeSponsorSetting = BecomeSponsorSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'online_business_directory_template') {
            $onlineBusinessDirectorySetting = OnlineBusinessDirectorySetting::wherePageId($request->id)->first();
            if (!$onlineBusinessDirectorySetting) {
                $onlineBusinessDirectorySetting = OnlineBusinessDirectorySetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'one_more_thing_template') {
            $oneMoreThingSetting = OneMoreThingSetting::wherePageId($request->id)->first();
            if (!$oneMoreThingSetting) {
                $oneMoreThingSetting = OneMoreThingSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'exporting_fair_template') {
            $exportingFairSetting = ExportingFairSetting::wherePageId($request->id)->first();
            if (!$exportingFairSetting) {
                $exportingFairSetting = ExportingFairSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'financing_program_template') {
            $financingProgramSetting = FinancingProgramSetting::wherePageId($request->id)->first();
            if (!$financingProgramSetting) {
                $financingProgramSetting = FinancingProgramSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'contact_for_rates_template') {
            $contactForRateSetting = ContactForRateSetting::wherePageId($request->id)->first();
            if (!$contactForRateSetting) {
                $contactForRateSetting = ContactForRateSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'scam_alert_template') {
            $scamAlertSetting = ScamAlertSetting::wherePageId($request->id)->first();
            if (!$scamAlertSetting) {
                $scamAlertSetting = ScamAlertSetting::create([
                    'page_id' => $request->id
                ]);
            }
        }
        else if ($request->template == 'testimonial_template') {
            $testimonialSetting = TestimonialSetting::wherePageId($request->id)->first();
            if (!$testimonialSetting) {
                $testimonialSetting = TestimonialSetting::create([
                    'page_id' => $request->id
                ]);
            }
        }
        else if ($request->template == 'success_stories_template') {
            $successStoriesSetting = SuccessStoriesSetting::wherePageId($request->id)->first();
            if (!$successStoriesSetting) {
                $successStoriesSetting = SuccessStoriesSetting::create([
                    'page_id' => $request->id
                ]);
            }
        }
        else if ($request->template == 'faq_exporter_template') {
            $faqExporterSetting = FaqExporterSetting::wherePageId($request->id)->first();
            if (!$faqExporterSetting) {
                $faqExporterSetting = FaqExporterSetting::create([
                    'page_id' => $request->id
                ]);
            }
        }
        else if ($request->template == 'faq_importer_template') {
            $faqImporterSetting = FaqImporterSetting::wherePageId($request->id)->first();
            if (!$faqImporterSetting) {
                $faqImporterSetting = FaqImporterSetting::create([
                    'page_id' => $request->id
                ]);
            }
        }
         else if ($request->template == 'info_letter_template') {
            $infoLetterSetting = InfoLetterSetting::wherePageId($request->id)->first();
            if (!$infoLetterSetting) {
                $infoLetterSetting = InfoLetterSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'register_template') {
            $regPageSetting = RegPageSetting::wherePageId($request->id)->first();
            if (!$regPageSetting) {
                $regPageSetting = RegPageSetting::create([
                    'page_id' => $request->id
                ]);
            }
        } else if ($request->template == 'login_template') {
            $loginPageSetting = LoginPageSetting::wherePageId($request->id)->first();
            if (!$loginPageSetting) {
                $loginPageSetting = LoginPageSetting::create([
                    'page_id' => $request->id
                ]);
            }
        }
        foreach ($languages as $language) {
            $pageDetail = PageDetail::wherePageId($request->id)->whereLanguageId($language->id)->exists();
            if ($pageDetail) {
                PageDetail::wherePageId($request->id)->whereLanguageId($language->id)->update([
                    'page_id' => $request->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                    'description' => isset($request['description']['description_' . $language->id]) ? $request['description']['description_' . $language->id] : null,
                    'page_detail' => $request['page_detail']['page_detail_' . $language->id],
                    'edit_page_detail' => $request['edit_page_detail']['edit_page_detail_' . $language->id],
                    // 'slug' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                    'meta_keywords' => $request['meta_keywords']['meta_keywords_' . $language->id],
                ]);
            } else {
                PageDetail::create([
                    'page_id' => $request->id,
                    'language_id' => $language->id,
                    'name' => isset($request['name']['name_' . $language->id]) ? $request['name']['name_' . $language->id] : null,
                    'description' => isset($request['description']['description_' . $language->id]) ? $request['description']['description_' . $language->id] : null,
                    'page_detail' => isset($request['page_detail']['page_detail_' . $language->id]) ? $request['page_detail']['page_detail_' . $language->id] : null,
                    'edit_page_detail' => isset($request['edit_page_detail']['edit_page_detail_' . $language->id]) ? $request['edit_page_detail']['edit_page_detail_' . $language->id] : null,
                    // 'slug' => isset($request['name']['name_' . $language->id]) ? $this->generateUniqueSlug(($request['name']['name_' . $language->id])) : null,
                ]);
            }
            if ($language->is_default == '1') {
                $pageName = $request['name']['name_' . $language->id] ?? null;
                $slug = Str::slug($pageName);
                if (trim($page->slug) != trim($slug)) {
                    $slug = $this->generateUniqueSlug($pageName);
                }
                // Page::whereId($request->id)->update([
                //     'slug' => $slug,
                // ]);

                if (isset($request->set_as_default_page) && $request->set_as_default_page == true) {
                    if ($request->template == 'register_template') {
                        GeneralSetting::where('key', 'user_signup_page')->where('type', 'pages_setting')->update([
                            'value' => $slug,
                        ]);
                    } else if ($request->template == 'login_template') {
                        GeneralSetting::where('key', 'user_signin_page')->where('type', 'pages_setting')->update([
                            'value' => $slug,
                        ]);
                    } else if ($request->template == 'event_signup_template') {
                        GeneralSetting::where('key', 'user_event_signup_page')->where('type', 'pages_setting')->update([
                            'value' => $slug,
                        ]);
                    } else if ($request->template == 'event_create_template') {
                        GeneralSetting::where('key', 'user_event_create_page')->where('type', 'pages_setting')->update([
                            'value' => $slug,
                        ]);
                    } else if ($request->template == 'event_listing_template') {
                        GeneralSetting::where('key', 'user_event_listing_page')->where('type', 'pages_setting')->update([
                            'value' => $slug,
                        ]);
                    } else if ($request->template == 'sponser_listing_template') {
                        GeneralSetting::where('key', 'user_sponser_listing_page')->where('type', 'pages_setting')->update([
                            'value' => $slug,
                        ]);
                    } else if ($request->template == 'magazine_template') {
                        GeneralSetting::where('key', 'see_all_magazine_page')->where('type', 'pages_setting')->update([
                            'value' => $slug,
                        ]);
                    } else if ($request->template == 'contact_us_template') {
                        GeneralSetting::where('key', 'contact_us_page')->where('type', 'pages_setting')->update([
                            'value' => $slug,
                        ]);
                    } else if ($request->template == 'close_account_template') {
                        GeneralSetting::where('key', 'close_account_page')->where('type', 'pages_setting')->update([
                            'value' => $slug,
                        ]);
                    }
                }
            }
            if ($request->template == 'home_template') {
                $homePageSettingDetail = HomePageSettingDetail::whereHomePageSettingId($homePageSetting->id)->whereLanguageId($language->id)->exists();
                if ($homePageSettingDetail) {
                    $pageSettingService->update($homePageSetting, $language, $request);
                } else {
                    $pageSettingService->store($homePageSetting, $language, $request);
                }
            } else if ($request->template == 'about_us_template') {
                $aboutUsPageSettingDetail = AboutUsPageSettingDetail::whereAboutUsPageSettingId($aboutUsPageSetting->id)->whereLanguageId($language->id)->exists();
                if ($aboutUsPageSettingDetail) {
                    $pageSettingService->update($aboutUsPageSetting, $language, $request);
                } else {
                    $pageSettingService->store($aboutUsPageSetting, $language, $request);
                }
            } else if ($request->template == 'sponsor_listing') {
                $sponsorPageSettingDetail = SponsorPageSettingDetail::where('sponsor_page_setting_id',$sponsorPageSetting->id)->whereLanguageId($language->id)->exists();
                if ($sponsorPageSettingDetail) {
                    $pageSettingService->update($sponsorPageSetting, $language, $request);
                } else {
                    $pageSettingService->store($sponsorPageSetting, $language, $request);
                }
            } else if ($request->template == 'event_signup_template') {
                $eventSignupSettingDetail = EventSignupSettingDetail::whereEventSignupSettingId($eventSignupSetting->id)->whereLanguageId($language->id)->exists();
                if ($eventSignupSettingDetail) {
                    $pageSettingService->update($eventSignupSetting, $language, $request);
                } else {
                    $pageSettingService->store($eventSignupSetting, $language, $request);
                }
            } else if ($request->template == 'event_create_template') {
                $eventCreateSettingDetail = EventCreateSettingDetail::whereEventCreateSettingId($eventCreateSetting->id)->whereLanguageId($language->id)->exists();
                if ($eventCreateSettingDetail) {
                    $pageSettingService->update($eventCreateSetting, $language, $request);
                } else {
                    $pageSettingService->store($eventCreateSetting, $language, $request);
                }
            } else if ($request->template == 'contact_us_template') {
                $contactUsSettingDetail = ContactUsSettingDetail::whereContactUsSettingId($contactUsSetting->id)->whereLanguageId($language->id)->exists();
                if ($contactUsSettingDetail) {
                    $pageSettingService->update($contactUsSetting, $language, $request);
                } else {
                    $pageSettingService->store($contactUsSetting, $language, $request);
                }
            } else if ($request->template == 'inquiries_to_buy_template') {
                $i2BSettingDetail = I2BSettingDetail::where('i2b_setting_id', $i2BSetting->id)->whereLanguageId($language->id)->exists();
                if ($i2BSettingDetail) {
                    $pageSettingService->update($i2BSetting, $language, $request);
                } else {
                    $pageSettingService->store($i2BSetting, $language, $request);
                }
            }else if ($request->template == 'event_template') {
                $eventSettingDetail = EventSettingDetail::where('event_setting_id', $eventSetting->id)->whereLanguageId($language->id)->exists();
                if ($eventSettingDetail) {
                    $pageSettingService->update($eventSetting, $language, $request);
                } else {
                    $pageSettingService->store($eventSetting, $language, $request);
                }
            }
             else if ($request->template == 'comments_template') {
                $commentsSettingDetail = CommentsSettingDetail::whereCommentsSettingId($commentsSetting->id)->whereLanguageId($language->id)->exists();
                if ($commentsSettingDetail) {
                    $pageSettingService->update($commentsSetting, $language, $request);
                } else {
                    $pageSettingService->store($commentsSetting, $language, $request);
                }
            } else if ($request->template == 'rates_template') {
                $ratesSettingDetail = RatesSettingDetail::whereRatesSettingId($ratesSetting->id)->whereLanguageId($language->id)->exists();
                if ($ratesSettingDetail) {
                    $pageSettingService->update($ratesSetting, $language, $request);
                } else {
                    $pageSettingService->store($ratesSetting, $language, $request);
                }
            } else if ($request->template == 'close_account_template') {
                $closeAccountSettingDetail = CloseAccountSettingDetail::whereCloseAccountSettingId($closeAccountSetting->id)->whereLanguageId($language->id)->exists();
                if ($closeAccountSettingDetail) {
                    $pageSettingService->update($closeAccountSetting, $language, $request);
                } else {
                    $pageSettingService->store($closeAccountSetting, $language, $request);
                }
            } else if ($request->template == 'event_listing_template') {
                $eventListingSettingDetail = EventListingSettingDetail::whereEventListingSettingId($eventListingSetting->id)->whereLanguageId($language->id)->exists();
                if ($eventListingSettingDetail) {
                    $pageSettingService->update($eventListingSetting, $language, $request);
                } else {
                    $pageSettingService->store($eventListingSetting, $language, $request);
                }
            } else if ($request->template == 'sponser_listing_template') {
                $sponserListingSettingDetail = SponserListingSettingDetail::where('sponser_list_setting_id',$sponserListingSetting->id)->whereLanguageId($language->id)->exists();
                if ($sponserListingSettingDetail) {
                    $pageSettingService->update($sponserListingSetting, $language, $request);
                } else {
                    $pageSettingService->store($sponserListingSetting, $language, $request);
                }
            } else if ($request->template == 'advertiser_page_template') {
                $advertiserSettingDetail = AdvertiserSettingDetail::whereAdvertiserSettingId($advertiserSetting->id)->whereLanguageId($language->id)->exists();
                if ($advertiserSettingDetail) {
                    $pageSettingService->update($advertiserSetting, $language, $request);
                } else {
                    $pageSettingService->store($advertiserSetting, $language, $request);
                }
            } else if ($request->template == 'forget_page_template') {
                $forgetPageSettingDetail = ForgetPageSettingDetail::whereForgetPageSettingId($forgetPageSetting->id)->whereLanguageId($language->id)->exists();
                if ($forgetPageSettingDetail) {
                    $pageSettingService->update($forgetPageSetting, $language, $request);
                } else {
                    $pageSettingService->store($forgetPageSetting, $language, $request);
                }
            } else if ($request->template == 'become_sponsor_template') {
                $becomeSponsorSettingDetail = BecomeSponsorSettingDetail::whereBecomeSponsorSettingId($becomeSponsorSetting->id)->whereLanguageId($language->id)->exists();
                if ($becomeSponsorSettingDetail) {
                    $pageSettingService->update($becomeSponsorSetting, $language, $request);
                } else {
                    $pageSettingService->store($becomeSponsorSetting, $language, $request);
                }
            } else if ($request->template == 'online_business_directory_template') {
                $onlineBusinessDirectorySettingDetail = OnlineBusinessDirectorySettingDetail::whereOnlineBusinessDirectorySettingId($onlineBusinessDirectorySetting->id)->whereLanguageId($language->id)->exists();
                if ($onlineBusinessDirectorySettingDetail) {
                    $pageSettingService->update($onlineBusinessDirectorySetting, $language, $request);
                } else {
                    $pageSettingService->store($onlineBusinessDirectorySetting, $language, $request);
                }
            } else if ($request->template == 'one_more_thing_template') {
                $oneMoreThingSettingDetail = OneMoreThingSettingDetail::whereOneMoreThingSettingId($oneMoreThingSetting->id)->whereLanguageId($language->id)->exists();
                if ($oneMoreThingSettingDetail) {
                    $pageSettingService->update($oneMoreThingSetting, $language, $request);
                } else {
                    $pageSettingService->store($oneMoreThingSetting, $language, $request);
                }
            } else if ($request->template == 'exporting_fair_template') {
                $exportingFairSettingDetail = ExportingFairSettingDetail::whereExportingFairSettingId($exportingFairSetting->id)->whereLanguageId($language->id)->exists();
                if ($exportingFairSettingDetail) {
                    $pageSettingService->update($exportingFairSetting, $language, $request);
                } else {
                    $pageSettingService->store($exportingFairSetting, $language, $request);
                }
            } else if ($request->template == 'financing_program_template') {
                $financingProgramSettingDetail = FinancingProgramSettingDetail::whereFinancingProgramId($financingProgramSetting->id)->whereLanguageId($language->id)->exists();
                if ($financingProgramSettingDetail) {
                    $pageSettingService->update($financingProgramSetting, $language, $request);
                } else {
                    $pageSettingService->store($financingProgramSetting, $language, $request);
                }
            } else if ($request->template == 'contact_for_rates_template') {
                $contactForRateSettingDetail = ContactForRateSettingDetail::where('contact_for_rate_setting_id', $contactForRateSetting->id)->whereLanguageId($language->id)->exists();
                if ($contactForRateSettingDetail) {
                    $pageSettingService->update($contactForRateSetting, $language, $request);
                } else {
                    $pageSettingService->store($contactForRateSetting, $language, $request);
                }
            } else if ($request->template == 'scam_alert_template') {
                $scamAlertSettingDetail = ScamAlertSettingDetail::where('scam_alert_setting_id', $scamAlertSetting->id)->whereLanguageId($language->id)->exists();
                if ($scamAlertSettingDetail) {
                    $pageSettingService->update($scamAlertSetting, $language, $request);
                } else {
                    $pageSettingService->store($scamAlertSetting, $language, $request);
                }
            }
            else if ($request->template == 'testimonial_template') {
                $testimonialSettingDetail = TestimonialSettingDetail::where('testimonial_setting_id', $testimonialSetting->id)->whereLanguageId($language->id)->exists();
                if ($testimonialSettingDetail) {
                    $pageSettingService->update($testimonialSetting, $language, $request);
                } else {
                    $pageSettingService->store($testimonialSetting, $language, $request);
                }
            }
            else if ($request->template == 'success_stories_template') {
                $successStoriesSettingDetail = SuccessStoriesSettingDetail::where('success_stories_setting_id', $successStoriesSetting->id)->whereLanguageId($language->id)->exists();
                if ($successStoriesSettingDetail) {
                    $pageSettingService->update($successStoriesSetting, $language, $request);
                } else {
                    $pageSettingService->store($successStoriesSetting, $language, $request);
                }
            }
            else if ($request->template == 'faq_exporter_template') {
                $faqExporterSettingDetail = FaqExporterSettingDetail::where('faq_exporter_setting_id', $faqExporterSetting->id)->whereLanguageId($language->id)->exists();
                if ($faqExporterSettingDetail) {
                    $pageSettingService->update($faqExporterSetting, $language, $request);
                } else {
                    $pageSettingService->store($faqExporterSetting, $language, $request);
                }
            }
            else if ($request->template == 'faq_importer_template') {
                $faqImporterSettingDetail = FaqImporterSettingDetail::where('faq_importer_setting_id', $faqImporterSetting->id)->whereLanguageId($language->id)->exists();
                if ($faqImporterSettingDetail) {
                    $pageSettingService->update($faqImporterSetting, $language, $request);
                } else {
                    $pageSettingService->store($faqImporterSetting, $language, $request);
                }
            }

            else if ($request->template == 'info_letter_template') {
                $infoLetterSettingDetail = InfoLetterSettingDetail::whereInfoLetterSettingId($infoLetterSetting->id)->whereLanguageId($language->id)->exists();
                if ($infoLetterSettingDetail) {
                    $pageSettingService->update($infoLetterSetting, $language, $request);
                } else {
                    $pageSettingService->store($infoLetterSetting, $language, $request);
                }
            } else if ($request->template == 'register_template') {
                $regPageSettingDetail = RegPageSettingDetail::whereRegPageSettingId($regPageSetting->id)->whereLanguageId($language->id)->exists();
                if ($regPageSettingDetail) {
                    $pageSettingService->update($regPageSetting, $language, $request);
                } else {
                    $pageSettingService->store($regPageSetting, $language, $request);
                }
            } else if ($request->template == 'login_template') {
                $loginPageSettingDetail = LoginPageSettingDetail::whereLoginPageSettingId($loginPageSetting->id)->whereLanguageId($language->id)->exists();
                if ($loginPageSettingDetail) {
                    $pageSettingService->update($loginPageSetting, $language, $request);
                } else {
                    $pageSettingService->store($loginPageSetting, $language, $request);
                }
            }
        }

        return $this->successResponse([], 'Page has been updated successfully.');
    }


    public function destroy(Request $request, Page $page)
    {
        $homePageSetting = HomePageSetting::with('homePageSettingDetail')->wherePageId($page->id)->get();
        foreach ($homePageSetting as $key => $setting) {
            $setting->homePageSettingDetail()->delete();
        }
        HomePageSetting::wherePageId($page->id)->delete();
        $aboutUsPageSetting = AboutUsPageSetting::with('aboutUsPageSettingDetail')->wherePageId($page->id)->get();
        foreach ($aboutUsPageSetting as $key => $setting) {
            $setting->aboutUsPageSettingDetail()->delete();
        }
        AboutUsPageSetting::wherePageId($page->id)->delete();

        $contactUsSetting = ContactUsSetting::with('contactUsSettingDetail')->wherePageId($page->id)->get();
        foreach ($contactUsSetting as $key => $setting) {
            $setting->contactUsSettingDetail()->delete();
        }
        ContactUsSetting::wherePageId($page->id)->delete();

        $becomeSponsorSetting = BecomeSponsorSetting::with('becomeSponsorSettingDetail')->wherePageId($page->id)->get();
        foreach ($becomeSponsorSetting as $key => $setting) {
            if (isset($setting->becomeSponsorSettingDetail)) {
                $setting->becomeSponsorSettingDetail()->delete();
            }
        }
        BecomeSponsorSetting::wherePageId($page->id)->delete();

        $onlineBusinessDirectorySetting = OnlineBusinessDirectorySetting::with('onlineBusinessDirectorySettingDetail')->wherePageId($page->id)->get();
        foreach ($onlineBusinessDirectorySetting as $key => $setting) {
            if (isset($setting->onlineBusinessDirectorySettingDetail)) {
                $setting->onlineBusinessDirectorySettingDetail()->delete();
            }
        }
        OnlineBusinessDirectorySetting::wherePageId($page->id)->delete();

        $infoLetterSetting = InfoLetterSetting::with('infoLetterSettingDetail')->wherePageId($page->id)->get();
        foreach ($infoLetterSetting as $key => $setting) {
            $setting->infoLetterSettingDetail()->delete();
        }
        InfoLetterSetting::wherePageId($page->id)->delete();
        if (isset($page->pageDetail)) {
            $page->pageDetail()->delete();
        }
        if ($page->delete()) {
            return $this->apiSuccessResponse(new PageResource($page), 'Page has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($pages)
    {
        $defaultLang = getDefaultLanguage();
        $pages = $pages->with(['pageDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withPageDetail']) && $_GET['withPageDetail'] == '1') {
            $pages = $pages->with('pageDetail');
        }
        if (isset($_GET['withMetaImages']) && $_GET['withMetaImages'] == '1') {
            $pages = $pages->with(['facebook']);
        }
        return $pages;
    }

    protected function sortingAndLimit($pages)
    {
        $defaultLang = getDefaultLanguage();
        $pages = $pages->addSelect(['page_name' => PageDetail::whereColumn('pages.id', 'page_detail.page_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $pages->orderBy('page_name', 'asc')->get();
        }
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'page_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {

            $pages = $pages->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $pages->paginate($limit);
    }

    protected function whereClause($pages)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $pages = $pages->whereHas('pageDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('description', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $pages;
    }

    protected function resetAsHomePage($page)
    {
        Page::where('id', '!=', $page->id)->where('is_home_page', '1')->update([
            'is_home_page' => '0'
        ]);
    }

    protected function generateUniqueSlug($initialSlug): string
    {
        $slug = Str::slug($initialSlug);
        $count = 1;

        while (Page::where('slug', $slug)->exists()) {
            $slug = Str::slug($initialSlug . '-' . $count);
            $count++;
        }

        return $slug;
    }
}
