<section class="home-container relative lg:py-[100px] md:pt-10 md:pb-10 pt-10 pb-10 bg-white">
    <div class="">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-left font-semibold text-[#006EB7] can-exp-h1 mb-0">
                {!! $homePageSettingDetail->section2_heading !!}
            </h2>
            
            <div class="flex justify-end">
                @php
                    $url = $homePageSettingDetail->section2_button_url;
                    $url = langBasedURL($lang, $url);
                    $hasPaid = isset($user) && $user->is_package_amount_paid;
                @endphp
                <a id="section2-button" aria-label="{{ __('Canadian Exporters') }}" href="{{ $url }}" class="button-exp-no-fill rounded-none">
                    {!! $homePageSettingDetail->section2_button_text !!}
                </a>
            </div>
        </div>
        <!--end header-->

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
        <div class="mt-2 relative">
        <div class="swiper i2b-slider-container relative z-0" style="padding: 0px !important;">
            <div class="swiper-wrapper">
                @foreach ($inquiries as $inquiry)
                <div class="swiper-slide h-full">
                    <div class="bg-white w-full border border-[#c9dbe9] shadow-md shadow-blue-500/20 flex flex-col h-full">
                        @php
                        $inquiryDetail = $inquiry->i2bDetail->where('language_id', $lang->id)->first() ?? $inquiry->i2bDetail->first();
                        @endphp
                        <div class="border-b border-[#c9dbe9] p-4">
                            {{-- Title --}}
                            <h2 class="text-left text-2xl font-semibold text-[#000000] leading-tight truncate">
                                {{ $inquiryDetail->name ?? 'Inquiry' }}
                            </h2>

                        </div>
                        
                        {{-- Details list --}}
                        <div class="flex-1 flex flex-col gap-3 p-4">
                            @if ($inquiry->business_category_name)
                                <div class="flex items-center">
                                    <span class="text-gray-600 text-sm w-[45%] text-left">{{ __('Business Category') }}</span>
                                    <span class="text-gray-600 text-sm flex-1 text-center">:</span>
                                    <span class="text-[#000000] text-sm font-semibold w-[55%] text-left pl-2 truncate">{{ $inquiry->business_category_name }}</span>
                                </div>
                            @endif
                            
                            @if ($inquiryDetail && $inquiryDetail->country_name)
                                <div class="flex items-center">
                                    <span class="text-gray-600 text-sm w-[45%] text-left">{{ __('Country') }}</span>
                                    <span class="text-gray-600 text-sm flex-1 text-center">:</span>
                                    <span class="text-[#000000] text-sm font-semibold w-[55%] text-left pl-2 truncate">{{ $inquiryDetail->country_name }}</span>
                                </div>
                            @endif
                            
                            @if ($inquiry->deadline_date)
                                <div class="flex items-center">
                                    <span class="text-gray-600 text-sm w-[45%] text-left">{{ __('Deadline') }}</span>
                                    <span class="text-gray-600 text-sm flex-1 text-center">:</span>
                                    <span class="text-[#000000] text-sm font-semibold w-[55%] text-left pl-2 truncate">{{ $inquiry->deadline_date }}</span>
                                </div>
                            @endif
                            
                            @if ($inquiry->estimated_value)
                                <div class="flex items-center">
                                    <span class="text-gray-600 text-sm w-[45%] text-left">{{ __('Estimated Value') }}</span>
                                    <span class="text-gray-600 text-sm flex-1 text-center">:</span>
                                    <span class="text-[#000000] text-sm font-semibold w-[55%] text-left pl-2 truncate">${{ number_format($inquiry->estimated_value, 0) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        {{-- More Details link --}}
                        <div class="mt-auto text-left p-4">
                            @php
                            $inquiryUrl = $homePageSettingDetail->section2_button_url ?? '#';
                            $inquiryUrl = langBasedURL($lang, $inquiryUrl);
                            @endphp
                            <a aria-label="{{ __('Canadian Exporters') }}" href="{{ $inquiryUrl }}"
                                class="text-primary text-sm hover:underline font-medium">
                                <span data-i18n="More Details">{{ __('More Details') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <div class="i2b-button-next-exp absolute z-50" style="right: -72px; top: 50%; transform: translateY(-50%);">
            <div
                class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                </svg>
            </div>
        </div>
        <div class="i2b-button-prev-exp absolute z-50" style="left: -72px; top: 50%; transform: translateY(-50%);">
            <div
                class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                </svg>
            </div>
        </div>
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