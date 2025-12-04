@php
    $featuredProfiles = $searchCustomerProfiles->where('package_type', 'featured');
    $setting = getI2bModalSetting($lang, ['general']);
    $advance_search_setting = getI2bModalSetting($lang, ['advance_search']);
    $business_profile_setting = getI2bModalSetting($lang, ['business_profile_setting']);
@endphp
@foreach ($featuredProfiles as $customerProfile)
    @if ($loop->first)
        <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md my-6">
            <h4 class="text-center text-white text-xl md:text-2xl lg:text-3xl">
                {{ isset($advance_search_setting['featured_search_results_for_text']) ? $advance_search_setting['featured_search_results_for_text'] : 'Featured exporters for' }}
                ({{ $_GET['search'] }})
            </h4>
        </div>
    @endif
    <div class="rounded-lg bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4"
        id="canaidan-exporters-{{ $customerProfile->id }}">

        <div class="bg-white rounded-lg px-4 py-4 md:py-2 relative z-0">
            <div
                class="absolute top-2 {{ isset($lang, $lang->direction) && $lang->direction == 'ltr' ? 'right-2' : 'left-2' }} ">
                <img class="h-6 cursor-pointer md:mt-2 remove-item" data-type="business_categories"
                    data-id="{{ $customerProfile->id }}" src="{{ asset('assets/icons/19-X-inside-circle-2.png') }}"
                    alt="Candian Exporters">
            </div>
            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-2">
                <div class="h-32 w-32 rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                    <img src="{{ isset($customerProfile->customerMedia, $customerProfile->customerMedia->customerLogo) && file_exists($customerProfile->customerMedia->customerLogo->medium_image) ? asset($customerProfile->customerMedia->customerLogo->medium_image) : asset('/assets/image/logocanexp.png') }}"
                        class="h-full w-full object-contain rounded" alt="Candian Exporters">
                </div>
                <div class="md:p-4 flex-1">
                    <h2 class="text-xl md:text-xl lg:text-2xl text-gray-800 mb-2">{{ $customerProfile->company_name }}
                    </h2>
                    <p class="text-gray-600 mb-4 text-base md:text-base lg:text-lg">
                        {!! strlen($customerProfile->short_description) > 0
                            ? $customerProfile->short_description
                            : \Illuminate\Support\Str::limit(strip_tags($customerProfile->description), 100) !!}
                    </p>
                    <div class="flex gap-5 md:gap-2">
                        <div>
                            <a aria-label="Candian Exporters"
                                href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customerProfile->slug]) }}"
                                class="button-exp-fill">{{ isset($setting['view_company_profile_button_text'])
                                    ? $setting['view_company_profile_button_text']
                                    : "View
                                                                                                                                                                                                    company's profile" }}</a>
                        </div>
                        <div>
                            <a aria-label="Candian Exporters" href="{{ $customerProfile->website }}"
                                class="button-exp-no-fill"
                                target="_blank">{{ isset($business_profile_setting['visit_our_website_text']) ? $business_profile_setting['visit_our_website_text'] : '' }}</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endforeach
@php
    $premiumProfiles = $searchCustomerProfiles->where('package_type', 'premium');
@endphp
@foreach ($premiumProfiles as $customerProfile)
    @if ($loop->first)
        <div
            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-blue-500 via-blue-500 to-secondary rounded-md my-6">
            <h4 class="text-center text-white text-xl md:text-2xl lg:text-3xl">
                {{ isset($advance_search_setting['premium_search_results_for_text']) ? $advance_search_setting['premium_search_results_for_text'] : 'Premium exporters for' }}
                ({{ $_GET['search'] }})
            </h4>
        </div>
    @endif
    <div class="rounded-lg bg-gradient-to-r from-blue-500 to-blue-500 p-0.5 mb-4">
        <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2 relative z-0"
            id="canaidan-exporters-{{ $customerProfile->id }}">
            <div
                class="absolute top-2 {{ isset($lang, $lang->direction) && $lang->direction == 'ltr' ? 'right-2' : 'left-2' }} ">
                <img class="h-6 cursor-pointer md:mt-2 remove-item" data-type="business_categories"
                    data-id="{{ $customerProfile->id }}" src="{{ asset('assets/icons/19-X-inside-circle-2.png') }}"
                    alt="Candian Exporters">
            </div>
            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-2">
                <div class="h-28 w-28 rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                    <img src="{{ isset($customerProfile->customerMedia->customerLogo) && file_exists($customerProfile->customerMedia->customerLogo->medium_image) ? asset($customerProfile->customerMedia->customerLogo->medium_image) : asset('/assets/image/logocanexp.png') }}"
                        class="h-full w-full object-contain rounded" alt="Candian Exporters">
                </div>
                <div class="md:p-4 flex-1">
                    <h2 class="text-xl md:text-xl lg:text-2xl text-gray-800 mb-2">{{ $customerProfile->company_name }}</h2>
                    <p class="text-gray-600 mb-4 text-base md:text-base lg:text-lg">
                        {!! strlen($customerProfile->short_description) > 0
                            ? $customerProfile->short_description
                            : \Illuminate\Support\Str::limit(strip_tags($customerProfile->description), 100) !!}
                    </p>
                    <div class="flex gap-5 md:gap-2">

                        <div>

                            <a aria-label="Candian Exporters"
                                href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customerProfile->slug]) }}"
                                class="button-exp-fill">{{ isset($setting['view_company_profile_button_text'])
                                    ? $setting['view_company_profile_button_text']
                                    : "View
                                                                                                                                                        company's profile" }}</a>
                        </div>

                        <div>
                            <a aria-label="Candian Exporters" href="{{ $customerProfile->website }}"
                                class="button-exp-no-fill"
                                target="_blank">{{ isset($business_profile_setting['visit_our_website_text']) ? $business_profile_setting['visit_our_website_text'] : '' }}</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endforeach
@php
    $freeProfiles = $searchCustomerProfiles->where('package_type', 'free');
@endphp
@foreach ($freeProfiles as $customerProfile)
    @if ($loop->first)
        <div
            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-blue-400 via-blue-400 to-secondary rounded-md my-6">
            <h4 class="text-center text-white text-xl md:text-2xl lg:text-3xl">
                {{ isset($advance_search_setting['search_results_for_text']) ? $advance_search_setting['search_results_for_text'] : 'Search results for' }}
                ({{ $_GET['search'] }})
            </h4>
        </div>
    @endif
    <div class="bg-white rounded-lg shadow-md mb-4 px-4 py-4 md:py-2 relative z-0"
        id="canaidan-exporters-{{ $customerProfile->id }}">
        <div
            class="absolute top-2 {{ isset($lang, $lang->direction) && $lang->direction == 'ltr' ? 'right-2' : 'left-2' }} ">
            <img class="h-6 cursor-pointer md:mt-2 remove-item" data-type="business_categories"
                data-id="{{ $customerProfile->id }}" src="{{ asset('assets/icons/19-X-inside-circle-2.png') }}"
                alt="Candian Exporters">
        </div>
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-2">
            <div class="h-24 w-24 rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                <img src="{{ isset($customerProfile->customerMedia->customerLogo) && file_exists($customerProfile->customerMedia->customerLogo->medium_image) ? asset($customerProfile->customerMedia->customerLogo->medium_image) : asset('/assets/image/logocanexp.png') }}"
                    {{-- <img src="{{ asset('assets/image/logo-dark.png') }}" class="h-full w-full object-contain" --}} alt="Candian Exporters" class="h-full w-full object-contain">
            </div>
            <div class="md:p-4 flex-1">
                <h2 class="text-lg md:text-lg lg:text-xl text-gray-800 mb-2">{{ $customerProfile->company_name }}</h2>
                <p class="text-gray-600 mb-4 text-sm md:text-sm lg:text-base">
                    {!! strlen($customerProfile->short_description) > 0
                        ? $customerProfile->short_description
                        : \Illuminate\Support\Str::limit(strip_tags($customerProfile->description), 100) !!}
                </p>
                <a aria-label="Candian Exporters"
                    href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customerProfile->slug]) }}"
                    class="button-exp-fill">{{ isset($setting['view_company_profile_button_text'])
                        ? $setting['view_company_profile_button_text']
                        : "View
                                                                                                                            company's profile" }}</a>
            </div>
        </div>


    </div>
@endforeach
{{-- @if (count($searchCustomerProfiles) == 0)
    <h1 class="can-exp-h2 text-center text-primary">
        @php
            $setting = getStaticTranslationByKey($lang, 'general', ['no_result_found_text']);
        @endphp
        {{ isset($setting['no_result_found_text']) ? $setting['no_result_found_text'] : '' }}
    </h1>
@endif --}}

<div class="mt-10">
    {{ $searchCustomerProfiles->appends($_GET)->links() }}
</div>
