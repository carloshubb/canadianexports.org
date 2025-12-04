@extends('front.layouts.app')
@if (isset($page, $page->facebook))
    @php
        $facebook = asset($page->facebook->path);
    @endphp
@else
    @php
        $mediaId = getSignleGeneralSettingByKey(['facebook_meta_image']);
        $facebook = isset($mediaId) ? getMediaById($mediaId) : null;
        $facebook = isset($facebook) ? asset($facebook->path) : null;
    @endphp
@endif

@php
    $meta_desc = isset($page->pageDetail, $page->pageDetail[0]) ? $page->pageDetail[0]->description : null;
@endphp
@section('title', 'Canadian Exports | Canadian Products and Services')
@section('meta_description', $meta_desc)
@section('facebook_meta_image', isset($facebook) ? $facebook : null)
@section('twitter_meta_image', isset($facebook) ? $facebook : null)
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
    catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
    companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
@section('content')
    @if (isset($page) && $page->template != 'online_business_directory_template')
    @include('front.pages.header-banner')
    @endif
    @if (isset($page) && $page->template == 'home_template')
        @php
            $homePageSetting = getHomePageSetting($lang, $page);
            $homePageSettingDetail = isset($homePageSetting->homePageSettingDetail[0])
                ? $homePageSetting->homePageSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.home-template.index')
    @elseif(isset($page) && $page->template == 'login_template')
        @php
            $loginPageSetting = getLoginPageSetting($lang, $page);
            $loginPageSettingDetail = isset($loginPageSetting->loginPageSettingDetail[0])
                ? $loginPageSetting->loginPageSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.login-template.index', ['page' => $page])
    @elseif(isset($page) && $page->template == 'forget_page_template')
        @php
            $forgetPageSetting = getForgetPageSetting($lang, $page);
            $forgetPageSettingDetail = isset($forgetPageSetting->forgetPageSettingDetail[0])
                ? $forgetPageSetting->forgetPageSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.forget-password-template.index', ['page' => $page])
    @elseif(isset($page) && $page->template == 'register_template')
        @include('front.pages.register-template.index', ['page' => $page])
    @elseif(isset($page) && $page->template == 'contact_us_template')
        @php
            $contactUsSetting = getContactUsSetting($lang, $page);
            $contactUsSettingDetail = isset($contactUsSetting->contactUsSettingDetail[0])
                ? $contactUsSetting->contactUsSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.contact-us-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'comments_template')
        @php
            $commentsSetting = getCommentsSetting($lang, $page);
            $commentsSettingDetail = isset($commentsSetting->commentsSettingDetail[0])
                ? $commentsSetting->commentsSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.comments-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'rates_template')
        @php
            $ratesSetting = getRatesSetting($lang, $page);
            $ratesSettingDetail = isset($ratesSetting->ratesSettingDetail[0])
                ? $ratesSetting->ratesSettingDetail[0]
                : null;
                // dd($ratesSetting);
        @endphp

        @include('front.pages.rates-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'close_account_template')
        @php
            $closeAccountSetting = getCloseAccountSetting($lang, $page);
            $closeAccountSettingDetail = isset($closeAccountSetting->closeAccountSettingDetail[0])
                ? $closeAccountSetting->closeAccountSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.close-account-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'become_sponsor_template')
        @php
            $becomeSponsorSetting = getBecomeSponsorSetting($lang, $page);
            $becomeSponsorSettingDetail = isset($becomeSponsorSetting->becomeSponsorSettingDetail[0])
                ? $becomeSponsorSetting->becomeSponsorSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.become-sponsor-template.index', ['page' => $page, 'lang' => $lang])
        @elseif(isset($page) && $page->template == 'sponsor_listing')
        @php
            $sponsorPageSetting = getSponsorSetting($lang, $page);
            $sponsorPageSettingDetail = isset($sponsorPageSetting->sponsorPageSettingDetail[0])
                ? $sponsorPageSetting->sponsorPageSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.sponsor-listing.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'online_business_directory_template')
        @php
            $onlineBusinessDirectorySetting = getOnlineBusinessDirectorySetting($lang, $page);
            $onlineBusinessDirectorySettingDetail = isset($onlineBusinessDirectorySetting->onlineBusinessDirectorySettingDetail[0])
            ? $onlineBusinessDirectorySetting->onlineBusinessDirectorySettingDetail[0]
            : null;

            $onlineBusinessDirectory = getOnlineBusinessDirectory($lang);
        @endphp
        @include('front.pages.online-business-directory-template.index', ['page' => $page, 'lang' => $lang, 'onlineBusinessDirectory' => $onlineBusinessDirectory])
    @elseif(isset($page) && $page->template == 'financing_program_template')
        @php
            $financingProgramSetting = getFinancingProgramSetting($lang, $page);
            $financingProgramSettingDetail = isset($financingProgramSetting->financingProgramSettingDetail[0])
                ? $financingProgramSetting->financingProgramSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.financing-program-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'contact_for_rates_template')
        @php

            $contactForRateSetting = getContactForRateSetting($lang, $page);
            $contactForRateSettingDetail = isset($contactForRateSetting->contactForRateSettingDetail[0])
                ? $contactForRateSetting->contactForRateSettingDetail[0]
                : null;
                // dd($contactForRateSetting);
        @endphp
        @include('front.pages.contact-for-rates-template.index', ['page' => $page, 'lang' => $lang])

        @elseif(isset($page) && $page->template == 'scam_alert_template')
        @php
            $scamAlertSetting = getScamAlertSetting($lang, $page);
            $scamAlertSettingDetail = isset($scamAlertSetting->scamAlertSettingDetail[0])
                ? $scamAlertSetting->scamAlertSettingDetail[0]
                : null;
                // dd($scamAlertSetting);
        @endphp
        @include('front.pages.scam-alert-template.index', ['page' => $page, 'lang' => $lang])
        @elseif(isset($page) && $page->template == 'success_stories_template')
        @php
            $successStoriesSetting = getSuccessStoriesSetting($lang, $page);
            $successStoriesSettingDetail = isset($successStoriesSetting->successStoriesSettingDetail[0])
                ? $successStoriesSetting->successStoriesSettingDetail[0]
                : null;
                // dd($scamAlertSetting);
        @endphp
        @include('front.pages.success_stories-template.index', ['page' => $page, 'lang' => $lang])
        @elseif(isset($page) && $page->template == 'faq_exporter_template')
        @php
            $faqExporterSetting = getFaqExporterSetting($lang, $page);
            $faqExporterSettingDetail = isset($faqExporterSetting->faqExporterSettingDetail[0])
                ? $faqExporterSetting->faqExporterSettingDetail[0]
                : null;
                // dd($scamAlertSetting);
        @endphp
        @include('front.pages.faq-exporter-template.index', ['page' => $page, 'lang' => $lang])
        @elseif(isset($page) && $page->template == 'faq_importer_template')
        @php
            $faqImporterSetting = getFaqImporterSetting($lang, $page);
            $faqImporterSettingDetail = isset($faqImporterSetting->faqImporterSettingDetail[0])
                ? $faqImporterSetting->faqImporterSettingDetail[0]
                : null;
                // dd($scamAlertSetting);
        @endphp
        @include('front.pages.faq-importer-template.index', ['page' => $page, 'lang' => $lang])
        @elseif(isset($page) && $page->template == 'testimonial_template')
        @php
            $testimonialSetting = getTestimonialSetting($lang, $page);
            $testimonialSettingDetail = isset($testimonialSetting->testimonialSettingDetail[0])
                ? $testimonialSetting->testimonialSettingDetail[0]
                : null;
                // dd($scamAlertSetting);
        @endphp
        @include('front.pages.testimonial-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'one_more_thing_template')
        @php
            $oneMoreThingSetting = getOneMoreThingSetting($lang, $page);
            $oneMoreThingSettingDetail = isset($oneMoreThingSetting->oneMoreThingSettingDetail[0])
                ? $oneMoreThingSetting->oneMoreThingSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.one-more-thing-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'exporting_fair_template')
        @php
            $exportingFairSetting = getExportingFairSetting($lang, $page);
            $exportingFairSettingDetail = isset($exportingFairSetting->exportingFairSettingDetail[0])
                ? $exportingFairSetting->exportingFairSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.exporting-fair-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'event_signup_template')
        @php
            $eventSignupSetting = getEventSignupSetting($lang, $page);
            $eventSignupSettingDetail = isset($eventSignupSetting->eventSignupSettingDetail[0])
                ? $eventSignupSetting->eventSignupSettingDetail[0]
                : null;

            $page1 = getPageBySlug('create-event', $lang);
            $eventCreateSetting = getEventCreateSetting($lang, $page1);
            $eventCreateSettingDetail = isset($eventCreateSetting->eventCreateSettingDetail[0])
                ? $eventCreateSetting->eventCreateSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.event-signup-template.index', ['page' => $page, 'page1' => $page1, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'event_create_template')
        @php
            $eventCreateSetting = getEventCreateSetting($lang, $page);
            $eventCreateSettingDetail = isset($eventCreateSetting->eventCreateSettingDetail[0])
                ? $eventCreateSetting->eventCreateSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.event-create-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'info_letter_template')
        @php
            $infoLetterSetting = getInfoLetterSetting($lang, $page);
            $infoLetterSettingDetail = isset($infoLetterSetting->infoLetterSettingDetail[0])
                ? $infoLetterSetting->infoLetterSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.info-letter-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'inquiries_to_buy_template')
        @php
            $homePageSetting = getLatestHomePageSetting($lang, $page);
            $homePageSettingDetail = isset($homePageSetting->homePageSettingDetail[0])
                ? $homePageSetting->homePageSettingDetail[0]
                : null;

            $i2BSetting = getI2BSetting($lang, $page);
            $i2BSettingDetail = isset($i2BSetting->i2BSettingDetail[0]) ? $i2BSetting->i2BSettingDetail[0] : null;
        @endphp
        @include('front.pages.inquiries-to-buy-template.index', [
            'page' => $page,
            'lang' => $lang,
            'i2BSettingDetail' => $i2BSettingDetail,
        ])
    {{-- @elseif(isset($page) && $page->template == 'sponsor_listing')
        @include('front.pages.sponsor-listing.index', [
            'page' => $page,
            'lang' => $lang,
        ]) --}}
    {{-- @elseif(isset($page) && $page->template == 'testimonial_template')
        @include('front.pages.testimonial-template.index', ['page' => $page, 'lang' => $lang]) --}}
    {{-- @elseif(isset($page) && $page->template == 'event_template')
        @php
            $homePageSetting = getLatestHomePageSetting($lang, $page);
            $homePageSettingDetail = isset($homePageSetting->homePageSettingDetail[0])
                ? $homePageSetting->homePageSettingDetail[0]
                : null;
        @endphp
        @include('front.pages.event-template.index', ['page' => $page, 'lang' => $lang]) --}}
        @elseif(isset($page) && $page->template == 'event_template')
        @php
            $homePageSetting = getLatestHomePageSetting($lang, $page);
            $homePageSettingDetail = isset($homePageSetting->homePageSettingDetail[0])
                ? $homePageSetting->homePageSettingDetail[0]
                : null;

            $eventSetting = getEventSetting($lang, $page);
            $eventSettingDetail = isset($eventSetting->eventSettingDetail[0]) ? $eventSetting->eventSettingDetail[0] : null;
        @endphp
        @include('front.pages.event-template.index', [
            'page' => $page,
            'lang' => $lang,
            'eventSettingDetail' => $eventSettingDetail,
        ])
    @elseif(isset($page) && $page->template == 'magazine_template')
        @include('front.pages.magazine-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'faq_exporter_template')
        @include('front.pages.faq-exporter-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'faq_importer_template')
        @include('front.pages.faq-importer-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == 'event_listing_template')
        @include('front.pages.event-listing-template.index', ['page' => $page, 'lang' => $lang])
         @elseif(isset($page) && $page->template == 'sponser_listing_template')
        @include('front.pages.sponser-listing-template.index', ['page' => $page, 'lang' => $lang])
    @elseif(isset($page) && $page->template == null)
        @include('front.pages.about-us-template.index', ['page' => $page, 'lang' => $lang])
    @endif
    @if (Session::has('type') &&
            (Session::get('type') == 'success' || Session::get('type') == 'pre_success') &&
            Session::has('message') &&
            Session::get('message') != '')
        <message type="{{ Session::get('type') }}" message="{{ Session::get('message') }}"></message>
    @endif

    @if (isset($page) && $page->template != 'online_business_directory_template')
    @include('front.pages.footer-banner')
    @endif
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    @if (isset($page) && $page->template == 'inquiries_to_buy_template')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2({
                    width: '100%'
                });
            });

            document.addEventListener("DOMContentLoaded", function() {

                $('#business-categories-select').on('select2:select', function(e) {
                    const selectedValues = $('#business-categories-select').val() || [];

                    var selectedData = e.params.data;
                    var selectedValue = selectedData.id;
                    if (selectedValue == 'all') {
                        $('#business-categories-select').val(['all']).trigger('change');
                    } else if (selectedValues.includes('all')) {
                        let withoutAll = [];
                        withoutAll = selectedValues.filter(value => value !== 'all');
                        $('#business-categories-select').val(withoutAll).trigger('change');
                    }
                });

                $('#business-categories-select').on('select2:unselect', function(e) {
                    const selectedValues = $('#business-categories-select').val() || [];

                    if (selectedValues.length === 0) {
                        $('#business-categories-select').val(['all']).trigger('change');
                    }
                });

                $('#countries-select').on('select2:select', function(e) {
                    const selectedValues = $('#countries-select').val() || [];

                    var selectedData = e.params.data;
                    var selectedValue = selectedData.id;
                    if (selectedValue == 'all') {
                        $('#countries-select').val(['all']).trigger('change');
                    } else if (selectedValues.includes('all')) {
                        let withoutAll = [];
                        withoutAll = selectedValues.filter(value => value !== 'all');
                        $('#countries-select').val(withoutAll).trigger('change');
                    }
                });

                $('#countries-select').on('select2:unselect', function(e) {
                    const selectedValues = $('#countries-select').val() || [];

                    if (selectedValues.length === 0) {
                        $('#countries-select').val(['all']).trigger('change');
                    }
                });
            });
        </script>
    @elseif (isset($page) && $page->template == 'event_template')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                // Initialize Select2
                $('.js-example-basic-multiple').select2({
                    width: '100%'
                });

                // Handle selection logic for event-categories dropdown
                $('#event-categories-select').on('select2:select', function(e) {
                    const selectedValues = $('#event-categories-select').val() || [];

                    var selectedData = e.params.data;
                    var selectedValue = selectedData.id;

                    // If "All" is selected, deselect all other options
                    if (selectedValue === 'all') {
                        $('#event-categories-select').val(['all']).trigger('change');
                    }
                    // If a specific category is selected, deselect "All"
                    else if (selectedValues.includes('all')) {
                        let withoutAll = selectedValues.filter(value => value !== 'all');
                        $('#event-categories-select').val(withoutAll).trigger('change');
                    }
                });

                // Handle deselection logic for event-categories dropdown
                $('#event-categories-select').on('select2:unselect', function(e) {
                    const selectedValues = $('#event-categories-select').val() || [];

                    // If no options are selected, select "All" by default
                    if (selectedValues.length === 0) {
                        $('#event-categories-select').val(['all']).trigger('change');
                    }
                });
            });
        </script>
    @elseif(isset($page) && $page->template == 'login_template')
        <script>
            $(document).on('click', '.resend-activation-email', () => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('web.user.reactive-customer-account') }}',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        email: $('#email').val(),
                    },
                    success: function(response) {
                        console.log(response.status);
                        if (response?.status == 'Success') {
                            helper.swalSuccessMessageForWeb(response?.data);
                        } else if (response?.status == 'Error') {
                            helper.swalErrorMessageForWeb(response?.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        helper.swalErrorMessageForWeb('Something went wrong, please try again');
                    }
                });
            });
        </script>
    @endif
@endsection
