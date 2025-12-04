@extends('front.layouts.app')
@section('title', 'Canadian Exports | Register your account')
@section('meta_description',
    'Canadian Exports is a Canadian export portal and a directory of Canadian exporters,
    showcasing lists of Canadian products and services, and promoting Canadian manufacturers and exporters. Canadian Exports
    is a Canadian business directory and a Canadian business database highlighting the Canadian industry')
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
    catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
    companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
@section('content')
    @php
        $lang = getDefaultLanguage(true);
        $setting = getI2bModalSetting($lang, ['general']);
        $business_profile_setting = getI2bModalSetting($lang, ['business_profile_setting']);
    @endphp
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="container">
                <div class="flex justify-center">
                    <h2 class="text-center can-exp-h1">
                        @php
                            $category_name = strtolower($businessCategoryDetail->name);
                            $category_name = ucwords($category_name);
                        @endphp
                        {{ $category_name }}</h2>
                </div>
                @php
                    $featuredCustomers = $customers->where('package_type', 'featured');
                @endphp
                @foreach ($featuredCustomers as $customer)
                    @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md my-6">
                            <h4 class="text-center text-white text-xl md:text-2xl lg:text-3xl">
                                {{ isset($business_profile_setting['featured_heading_for_listing']) ? $business_profile_setting['featured_heading_for_listing'] : 'Featured exporters' }}
                            </h4>
                        </div>
                    @endif
                    <div class="rounded-lg bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                        <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2"
                            id="canaidan-exporters-{{ $customer->id }}">
                            <div class="">
                                <div class="flex justify-between items-start">
                                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-2">
                                        <div class="w-32 h-32 rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                                            <img src="{{ isset($customer->customerMedia, $customer->customerMedia->customerLogo) && file_exists($customer->customerMedia->customerLogo->medium_image) ? asset($customer->customerMedia->customerLogo->medium_image) : asset('/assets/image/logocanexp.png') }}"
                                                class="h-full w-full object-contain rounded" alt="Candian Exporters">
                                        </div>
                                        <div class="md:p-4 flex-1">
                                            <h2 class="text-xl md:text-xl lg:text-2xl text-gray-800 mb-2">
                                                {{ $customer->company_name }}
                                            </h2>
                                            <p class="text-gray-600 mb-4 text-base md:text-base lg:text-lg">
                                                {!! isset($customer->short_description) && str_word_count($customer->short_description) <= 30
                                                    ? $customer->short_description
                                                    : \Illuminate\Support\Str::words(strip_tags($customer->description), 30, '...') !!}
                                            </p>
                                            <div class="flex items-center gap-3">
                                                <div>
                                                    <a aria-label="Candian Exporters"
                                                        href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customer->slug]) }}">
                                                        <button aria-label="Candian Exporters" class="button-exp-fill block">
                                                            {{ isset($setting['view_company_profile_button_text'])
                                                                ? $setting['view_company_profile_button_text']
                                                                : "View company's profile" }}
                                                        </button>
                                                    </a>
                                                </div>
                                                <div>
                                                    <a aria-label="Candian Exporters" href="{{ $customer->website }}"
                                                        target="_blank" class="fix-url" onclick="fixUrls()">
                                                        <button aria-label="Candian Exporters" class="button-exp-no-fill block">
                                                            {{ isset($business_profile_setting['visit_our_website_text']) ? $business_profile_setting['visit_our_website_text'] : '' }}
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>


                        </div>
                    </div>
                @endforeach


                @php
                    $premiumCustomers = $customers->where('package_type', 'premium');
                @endphp
                @foreach ($premiumCustomers as $customer)
                    @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-blue-500 via-blue-500 to-secondary rounded-md my-6">
                            <h4 class="text-center text-white text-xl md:text-2xl lg:text-3xl">
                                {{ isset($business_profile_setting['premium_heading_for_listing']) ? $business_profile_setting['premium_heading_for_listing'] : 'Premium exporters' }}
                            </h4>
                        </div>
                    @endif
                    <div class="rounded-lg bg-gradient-to-r from-blue-500 to-blue-500 p-0.5 mb-4">
                        <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2"
                            id="canaidan-exporters-{{ $customer->id }}">
                            <div class="">
                                <div class="flex justify-between items-start">
                                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-2">
                                        <div class="w-28 h-28 rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                                            <img src="{{ isset($customer->customerMedia, $customer->customerMedia->customerLogo) && file_exists($customer->customerMedia->customerLogo->medium_image) ? asset($customer->customerMedia->customerLogo->medium_image) : asset('/assets/image/logocanexp.png') }}"
                                                class="h-full w-full object-contain rounded" alt="Candian Exporters">
                                        </div>
                                        <div class="md:p-4 flex-1">
                                            <h2 class="text-xl md:text-xl lg:text-2xl text-gray-800 mb-2">
                                                {{ $customer->company_name }}</h2>
                                            <p class="text-gray-600 mb-4 text-base md:text-base lg:text-lg">
                                                {!! strlen($customer->short_description) > 0
                                                    ? $customer->short_description
                                                    : \Illuminate\Support\Str::limit(strip_tags($customer->description), 100) !!}
                                            </p>
                                            <div class="flex gap-3 mt-3 sm:mt-0">
                                                <div>
                                                    <a aria-label="Candian Exporters"
                                                        href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customer->slug]) }}"
                                                        class="button-exp-fill">{{ isset($setting['view_company_profile_button_text'])
                                                            ? $setting['view_company_profile_button_text']
                                                            : "View company's profile" }}</a>
                                                </div>
                                                <div class="">
                                                    <a aria-label="Candian Exporters" href="{{ $customer->website }}"
                                                        target="_blank" class="button-exp-no-fill fix-url" onclick="fixUrls()">
                                                            {{ isset($business_profile_setting['visit_our_website_text']) ? $business_profile_setting['visit_our_website_text'] : '' }}
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>


                        </div>
                    </div>
                @endforeach

                @php
                    $freeCustomers = $customers->where('package_type', 'free');
                @endphp
                @foreach ($freeCustomers as $customer)
                    @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-blue-400 via-blue-400 to-secondary rounded-md my-6">
                            <h4 class="text-center text-white text-xl md:text-2xl lg:text-3xl">
                                {{ isset($business_profile_setting['basic_heading_for_listing']) ? $business_profile_setting['basic_heading_for_listing'] : 'Basic exporters' }}
                            </h4>
                        </div>
                    @endif
                    <div class="mb-4">
                        <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2"
                            id="canaidan-exporters-{{ $customer->id }}">
                            <div class="">
                                <div class="flex justify-between items-start">
                                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-2">
                                        <div class="w-24 h-24 rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                                            <img src="{{ isset($customer->customerMedia, $customer->customerMedia->customerLogo) && file_exists($customer->customerMedia->customerLogo->medium_image) ? asset($customer->customerMedia->customerLogo->medium_image) : asset('/assets/image/logocanexp.png') }}"
                                                class="h-full w-full object-contain rounded" alt="Candian Exporters">
                                        </div>
                                        <div class="md:p-4 flex-1">
                                            <h2 class="text-lg md:text-lg lg:text-xl text-gray-800 mb-2">
                                                {{ $customer->company_name }}</h2>
                                            <p class="text-gray-600 mb-4 text-sm md:text-sm lg:text-base">
                                                {!! strlen($customer->short_description) > 0
                                                    ? $customer->short_description
                                                    : \Illuminate\Support\Str::limit(strip_tags($customer->description), 100) !!}
                                            </p>
                                            <a aria-label="Candian Exporters"
                                                href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customer->slug]) }}"
                                                class="button-exp-fill">{{ isset($setting['view_company_profile_button_text'])
                                                    ? $setting['view_company_profile_button_text']
                                                    : "View company's profile" }}</a>
                                        </div>
                                    </div>


                                </div>
                            </div>


                        </div>
                    </div>
                @endforeach

                <div class="mt-10">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
