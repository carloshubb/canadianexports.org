{{-- @isset($ratesSettingDetail)
    @php
        $user_signup_page = isset($general_setting['user_signup_page']) ? route('front.index', $general_setting['user_signup_page']) : '#';
        $user_signup_page = langBasedURL($lang, $user_signup_page);
    @endphp
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="">
                <section class="rounded-md">
                    @isset($page->pageDetail[0])
                        <div class="">
                            @php
                                $page_detail = $page->pageDetail[0]->page_detail;
                            @endphp
                            @include('front.pages.widgets.render-widget-with-detail', [
                                'page_detail' => $page_detail,
                            ])
                        </div>
                    @endisset
                    @php
                        $packages = getRatesPackages($lang);
                        $freePackages = isset($packages) ? $packages->where('package_type', 'free')->all() : null;
                        $featuredPackages = isset($packages) ? $packages->where('package_type', 'featured')->all() : null;
                        $premiumPackages = isset($packages) ? $packages->where('package_type', 'premium')->all() : null;
                    @endphp
                    <!--Tabs-->
                    <div class="container">

                        <div class="mt-8 gap-5">
                            <div class="my-2">
                                {!! $ratesSettingDetail->price_table_pre_text !!}
                            </div>
                                @php
                                    $loggedInUser = null;
                                @endphp
                            @if (Auth::guard('customers')->check())
                                @php
                                    $loggedInUser = Auth::guard('customers')
                                        ->user()
                                        ->loadMissing('registrationPackage');
                                @endphp
                            @endif
                            <rates user="{{ $loggedInUser }}"></rates>
                            <div class="my-2">
                                {!! $ratesSettingDetail->price_table_post_text !!}
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class=" grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 container">
                        <!--cards 1-->
                        <div class="relative hover:shadow-lg transition-all z-0">
                            <div class="w-full h-full flex flex-col bg-white shadow rounded relative z-20">
                                <div class="py-4 flex-initial">
                                    <h2 class="card-heading text-primary text-center">
                                        {{ $ratesSettingDetail->free_package_text }}</h2>
                                </div>
                                <div class="p-4 space-y-1 flex-auto">
                                    @foreach ($freePackages as $freePackage)
                                        <div class="flex items-start gap-x-4">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-600 mt-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>

                                            </div>
                                            <div class="">
                                                <p>
                                                    {{ isset($freePackage->registrationPackageDetail, $freePackage->registrationPackageDetail[0]) ? $freePackage->registrationPackageDetail[0]->amount_pre_text : '' }}
                                                    ${{ $freePackage->price }}
                                                    {{ isset($freePackage->registrationPackageDetail, $freePackage->registrationPackageDetail[0]) ? $freePackage->registrationPackageDetail[0]->amount_post_text : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>

                                <div class="flex justify-center items-center py-4 flex-end">
                                    <a aria-label="Candian Exporters" href="{{$user_signup_page}}"
                                        class="button-exp-fill">{{ $ratesSettingDetail->free_package_btn_text }}</a>
                                </div>

                            </div>
                            <div class="bg-primary w-6 rounded h-[90%] my-auto absolute z-10 top-0 bottom-0 -left-2">

                            </div>
                        </div>

                        <!--cards 2-->
                        <div class="relative hover:shadow-lg transition-all z-0">
                            <div class="w-full h-full flex flex-col bg-white shadow rounded relative z-20">
                                <div class="py-4 flex-initial">
                                    <h2 class="card-heading text-primary text-center">
                                        {{ $ratesSettingDetail->featured_package_text }}</h2>
                                </div>
                                <div class="p-4 space-y-1 flex-auto">
                                    @foreach ($featuredPackages as $featuredPackage)
                                        <div class="flex items-start gap-x-4">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-600 mt-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>

                                            </div>
                                            <div class="">
                                                <p>
                                                    {{ isset($featuredPackage->registrationPackageDetail, $featuredPackage->registrationPackageDetail[0]) ? $featuredPackage->registrationPackageDetail[0]->amount_pre_text : '' }}
                                                    ${{ $featuredPackage->price }}
                                                    {{ isset($featuredPackage->registrationPackageDetail, $featuredPackage->registrationPackageDetail[0]) ? $featuredPackage->registrationPackageDetail[0]->amount_post_text : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex justify-center items-center py-4 flex-end">
                                    <a aria-label="Candian Exporters" href="{{$user_signup_page}}"
                                        class="button-exp-fill">{{ $ratesSettingDetail->featured_package_btn_text }}</a>
                                </div>

                            </div>
                            <div class="bg-primary w-6 rounded h-[90%] my-auto absolute z-10 top-0 bottom-0 -left-2">

                            </div>
                        </div>

                        <!--cards 3-->
                        <div class="relative hover:shadow-lg transition-all z-0">
                            <div class="w-full h-full flex flex-col bg-white shadow rounded relative z-20">
                                <div class="py-4 flex-initial">
                                    <h2 class="card-heading text-primary text-center">
                                        {{ $ratesSettingDetail->premium_package_text }}</h2>
                                </div>
                                <div class="p-4 space-y-1 flex-auto">
                                    @foreach ($premiumPackages as $premiumPackage)
                                        <div class="flex items-start gap-x-4">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-600 mt-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>

                                            </div>
                                            <div class="">
                                                <p>
                                                    {{ isset($premiumPackage->registrationPackageDetail, $premiumPackage->registrationPackageDetail[0]) ? $premiumPackage->registrationPackageDetail[0]->amount_pre_text : '' }}
                                                    ${{ $premiumPackage->price }}
                                                    {{ isset($premiumPackage->registrationPackageDetail, $premiumPackage->registrationPackageDetail[0]) ? $premiumPackage->registrationPackageDetail[0]->amount_post_text : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex justify-center items-center py-4 flex-end">

                                    <a aria-label="Candian Exporters" href="{{$user_signup_page}}"
                                        class="button-exp-fill">{{ $ratesSettingDetail->premium_package_btn_text }}</a>
                                </div>

                            </div>
                            <div class="bg-primary w-6 rounded h-[90%] my-auto absolute z-10 top-0 bottom-0 -left-2">

                            </div>
                        </div>

                    </div> --}}



                {{-- </section>
            </div>
        </div>
    </div>
@endisset --}}



@isset($ratesSettingDetail)
    @php
        $user_signup_page = isset($general_setting['user_signup_page']) ? route('front.index', $general_setting['user_signup_page']) : '#';
        $user_signup_page = langBasedURL($lang, $user_signup_page);
    @endphp
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="">
                <section class="rounded-md">
                    @isset($page->pageDetail[0])
                        <div class="">
                            @php
                                $page_detail = $page->pageDetail[0]->page_detail;
                            @endphp
                            @include('front.pages.widgets.render-widget-with-detail', [
                                'page_detail' => $page_detail,
                            ])
                        </div>
                    @endisset

                    @php
                        $packages = getRatesPackages($lang);
                        $freePackages = isset($packages) ? $packages->where('package_type', 'free')->all() : null;
                        $featuredPackages = isset($packages) ? $packages->where('package_type', 'featured')->all() : null;
                        $premiumPackages = isset($packages) ? $packages->where('package_type', 'premium')->all() : null;
                    @endphp

                    <!-- Tabs -->
                    <div class="container">
                        <div class="mt-8 gap-5">
                            <div class="my-2">
                                {!! $ratesSettingDetail->price_table_pre_text !!}
                            </div>

                            @php
                                $loggedInUser = null;
                            @endphp
                            @if (Auth::guard('customers')->check())
                                @php
                                    $loggedInUser = Auth::guard('customers')
                                        ->user()
                                        ->loadMissing('registrationPackage');
                                @endphp
                            @endif

                            <!-- Page Heading and Required Fields Text -->
                            {{-- <h1 class="text-center">{{ $ratesSettingDetail->page_heading }}</h1>
                            <div class="container">
                                <p class="text-red-500">
                                    <span class="text-red-500">*</span>
                                    {{ $ratesSettingDetail->required_fields_text }}
                                </p>
                            </div> --}}

                            <!-- Rates Component -->
                            <div class="grid grid-cols-1 gap-12">
                                <div class="order-2 md:order-1">
                                    <rates
                                        user="{{ $loggedInUser }}"
                                        rates_setting="{{ json_encode($ratesSettingDetail) }}"
                                        submit_url="{{ route('user.rates.send-message') }}"
                                        page_id="{{ $page->id }}"
                                    ></rates>
                                </div>
                            </div>

                            {{-- <div class="my-2">
                                {!! $ratesSettingDetail->price_table_post_text !!}
                            </div> --}}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endisset

