<div class="">
    @if (isset($page_name) && $page_name == 'review-confirmation')
        @include('web.signup-bussiness-setting.review-banner')
    @endif

    <div class="bg-white py-8 px-4 sm:px-10">
        @php
            $user = auth()
                ->guard('customers')
                ->user()
                ->loadMissing('customerBusinessCategory');

            $page = getPageBySlug('event-signup', $lang);
            $eventSignupSetting = getEventSignupSetting($lang, $page);
            $eventSignupSettingDetail = isset($eventSignupSetting->eventSignupSettingDetail[0])
                ? $eventSignupSetting->eventSignupSettingDetail[0]
                : null;

            $page1 = getPageBySlug('create-event', $lang);
            $eventCreateSetting = getEventCreateSetting($lang, $page1);
            $eventCreateSettingDetail = isset($eventCreateSetting->eventCreateSettingDetail[0])
                ? $eventCreateSetting->eventCreateSettingDetail[0]
                : null;

            $languages = getAllLanguages();
        @endphp
        <profile-event-signup event_detail="{{ $eventSignupSettingDetail }}"
            eventsetting="{{ $eventCreateSettingDetail }}"
            languages="{{ $languages }}"
            submit_url="{{ route('web.event-signup.payment') }}"
            email_validation_url="{{ route('web.event-signup.signup-email-validation') }}"
            page_id="{{ $page->id }}" create_page_id="{{ $page1->id }}" lang="{{ $lang }}"
            payment_setting="{{ $payment_setting }}" current_user="{{ json_encode($user) }}"></profile-event-signup>
    </div>
</div>
