@php
    $homePageSetting = getLatestHomePageSetting(null);
    $homePageSettingDetail = isset($homePageSetting->homePageSettingDetail[0]) ? $homePageSetting->homePageSettingDetail[0] : null;
    $i2b_setting = getI2BSetting($lang, null);
@endphp
@isset($homePageSettingDetail)
    @php
        $loginPageSlug = $general_setting['user_signin_page'];
        $page = getPageBySlug($loginPageSlug, $lang);
        $loginPageSetting = getLoginPageSetting($lang, $page);
        $loginPageSettingDetail = isset($loginPageSetting->loginPageSettingDetail[0]) ? $loginPageSetting->loginPageSettingDetail[0] : null;
        $register_url = isset($general_setting['user_signup_page']) ? route('front.index', $general_setting['user_signup_page']) : '#';
        $register_url = langBasedURL($lang, $register_url);
        $modal_setting = getI2bModalSetting($lang, ['i2b_modal', 'upgrade_modal', 'general']);
        $inquiry_id = null;
    @endphp

    <div class="">
        @foreach ($searchI2bs as $inquiry)
            @isset($inquiry->deadline_date)
                @php
                    $inquiry->deadline_date = date('F d, Y', strtotime($inquiry->deadline_date));
                @endphp
            @endisset
        @endforeach
        @if (Session::has('inquiry_id'))
            @php
                $inquiry_id = Session::get('inquiry_id');
            @endphp
            @if (Session::has('inquiry_id'))
                @php
                    $inquiry_id = Session::get('inquiry_id');
                @endphp
            @else
                @php
                    $inquiry_id = null;
                @endphp
            @endif
        @endif

        @php
            $user = auth()
                ->guard('customers')
                ->user();
                $user = isset($user) ? $user->loadMissing('registrationPackage') : null;
        @endphp

        <i2b-listing home_page_setting_detail="{{ $homePageSettingDetail }}" inquiries="{{ json_encode($searchI2bs->all()) }}"
            display_all_i2b="0" login_page_setting_detail="{{ $loginPageSettingDetail }}" inquiry_id="{{ $inquiry_id }}"
            register_url="{{ $register_url }}" modal_setting="{{ $modal_setting }}"
            user="{{ $user }}" lang="{{ $lang }}" page="advance_search" i2b_setting="{{$i2b_setting}}">
        </i2b-listing>


        {{-- @if (count($searchI2bs) == 0)
            <h1 class="can-exp-h2 text-center text-primary">
                @php
                    $setting = getStaticTranslationByKey($lang, 'general', ['no_result_found_text']);
                @endphp
                {{ isset($setting['no_result_found_text']) ? $setting['no_result_found_text'] : '' }}
            </h1>
        @endif --}}

        <div class="mt-10">
            {{ $searchI2bs->appends($_GET)->links() }}
        </div>

    </div>
@endisset
