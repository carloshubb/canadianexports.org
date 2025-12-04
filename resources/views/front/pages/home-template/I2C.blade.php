<section class="relative lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 bg-primary">
    <div class="container">
        <div class="grid grid-cols-1 text-center">
            <h2 class="text-white can-exp-h1 mb-4">
                {!! $homePageSettingDetail->section2_heading !!}
            </h2>
        </div>
        <!--end grid-->

        @php
            $inquiries = getLatestInquiries(6, $lang);
            $loginPageSlug = $general_setting['user_signin_page'];
            $page = getPageBySlug($loginPageSlug, $lang);
            $loginPageSetting = getLoginPageSetting($lang, $page);
            $loginPageSettingDetail = isset($loginPageSetting->loginPageSettingDetail[0])
                ? $loginPageSetting->loginPageSettingDetail[0]
                : null;
            $register_url = isset($general_setting['user_signup_page'])
                ? route('front.index', $general_setting['user_signup_page'])
                : '#';
            $register_url = langBasedURL($lang, $register_url);
            $modal_setting = getI2bModalSetting($lang, ['i2b_modal', 'upgrade_modal', 'general']);
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

        @foreach ($inquiries as $inquiry)
            @isset($inquiry->deadline_date)
                @php
                    $inquiry->deadline_date = date('F d, Y', strtotime($inquiry->deadline_date));
                @endphp
            @endisset
        @endforeach

        @php
            $user = auth()->guard('customers')->user();
            $user = isset($user) ? $user->loadMissing('registrationPackage') : null;
            $defaultLang = getDefaultLanguage(1);
        @endphp
        <div>
            <i2b-home home_page_setting_detail="{{ $homePageSettingDetail }}" inquiries="{{ $inquiries }}"
                display_all_i2b="1" login_page_setting_detail="{{ $loginPageSettingDetail }}"
                lang="{{ json_encode($lang ?? $defaultLang) }}"
                inquiry_id="{{ $inquiry_id }}" register_url="{{ $register_url }}" modal_setting="{{ $modal_setting }}"
                user="{{ $user }}" lang="{{ $lang }}" is_home_page="1">
            </i2b-home>
        </div>



        <div class="mt-10 flex justify-center">
            @php
                $url = $homePageSettingDetail->section2_button_url;
                $url = langBasedURL($lang, $url);
                $hasPaid = isset($user) && $user->is_package_amount_paid;
            @endphp
            <!-- {{ $hasPaid ? $url : '#' }} -->
            <a id="section2-button" aria-label="Canadian Exporters" href="{{ $url }}" class="button-exp-fill border-white">
                {!! $homePageSettingDetail->section2_button_text !!}
            </a>
        </div>
        <script>
            document.getElementById('section2-button').addEventListener('click', function(event) {
                @if (isset($user) && !$user->is_package_amount_paid)
                    event.preventDefault(); // Prevent the default link behavior
                    window.location.href = "{{ route('user.payment.index', [$lang->abbreviation]) }}";
                @endif
            });
        </script>
    </div>
</section>
