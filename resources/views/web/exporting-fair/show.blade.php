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
        $exporting_fair_detail_setting = getI2bModalSetting($lang, ['exporting_fair_detail_setting']);
    @endphp
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 container">
            <div class="">

                <section class="mb-4">
                    <div class=" bg-white rounded shadow py-6">
                        <div class="px-4 md:px-12 desktop:px-80">
                            <h2 class="text-primary text-center">
                                @isset($exportingFair->exportingFairDetail[0])
                                    {!! $exportingFair->exportingFairDetail[0]->title !!}
                                @endisset
                            </h2>
                        </div>
                        <div class="px-4 md:px-12 desktop:px-80">
                            <p class="">
                                @isset($exportingFair->exportingFairDetail[0])
                                    {!! $exportingFair->exportingFairDetail[0]->short_description !!}
                                @endisset
                            </p>
                        </div>
                        <div class="px-4 md:px-12 desktop:px-80 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 mt-8">
                            <div class="order-2 md:order-2 lg:order-1 mt-[5px]">
                                <table class="border-spacing-y-3 border-separate border-none">
                                    <tbody>
                                        <tr class="mb-3 border-none">
                                            <td
                                                class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">
                                                {{ isset($exporting_fair_detail_setting['ef_event_date_text']) ? $exporting_fair_detail_setting['ef_event_date_text'] : '' }}
                                            </td>
                                            <td
                                                class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                {{ date('F d, Y', strtotime($exportingFair->start_date)) }} -
                                                {{ date('F d, Y', strtotime($exportingFair->end_date)) }}</td>
                                        </tr>
                                        <tr class="mb-3 border-none">
                                            <td
                                                class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">
                                                {{ isset($exporting_fair_detail_setting['ef_booth_number_text']) ? $exporting_fair_detail_setting['ef_booth_number_text'] : '' }}
                                            </td>
                                            <td
                                                class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                @isset($exportingFair->exportingFairDetail[0])
                                                    {!! $exportingFair->booth_number !!}
                                                @endisset
                                            </td>
                                        </tr>
                                        <tr class="mb-3 border-none">
                                            <td
                                                class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">
                                                {{ isset($exporting_fair_detail_setting['ef_venue_text']) ? $exporting_fair_detail_setting['ef_venue_text'] : '' }}
                                            </td>
                                            <td
                                                class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                @isset($exportingFair->exportingFairDetail[0])
                                                    {!! $exportingFair->exportingFairDetail[0]->address !!}
                                                @endisset
                                            </td>
                                        </tr>
                                        <tr class="mb-3 border-none">
                                            <td
                                                class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">

                                                {{ isset($exporting_fair_detail_setting['ef_location_text']) ? $exporting_fair_detail_setting['ef_location_text'] : '' }}

                                            </td>
                                            <td
                                                class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                @isset($exportingFair->exportingFairDetail[0])
                                                    {!! $exportingFair->exportingFairDetail[0]->city !!},
                                                @endisset

                                                @isset($exportingFair->exportingFairDetail[0])
                                                    {!! $exportingFair->exportingFairDetail[0]->country !!}
                                                @endisset
                                            </td>
                                        </tr>
                                        <tr class="mb-3 border-none">
                                            <td
                                                class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">
                                                {{ isset($exporting_fair_detail_setting['ef_product_search_text']) ? $exporting_fair_detail_setting['ef_product_search_text'] : '' }}
                                            </td>
                                            <td
                                                class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                @isset($exportingFair->exportingFairDetail[0])
                                                    {!! $exportingFair->exportingFairDetail[0]->product_search !!}
                                                @endisset
                                            </td>
                                        </tr>

                                        <tr class="mb-3 border-none">


                                        </tr>


                                    </tbody>
                                </table>
                                <div
                                    class="text-base md:text-base lg:text-lg border-none break-all align-top flex flex-col sm:flex-col md:flex-row lg:flex-row gap-4 items-center">
                                    <button class="button-exp-fill whitespace-nowrap">
                                        <a class="text-white fix-url" aria-label="Candian Exporters"
                                            href="{{ $exportingFair->exibitors_url }}" target="_blank" onclick="fixUrls()">
                                            {{ isset($exporting_fair_detail_setting['ef_for_exibitor_url_text']) ? $exporting_fair_detail_setting['ef_for_exibitor_url_text'] : '' }}
                                        </a>
                                    </button>
                                    <button class="button-exp-fill whitespace-nowrap">
                                        <a class="text-white fix-url" aria-label="Candian Exporters"
                                            href="{{ $exportingFair->visitors_url }}" target="_blank" onclick="fixUrls()">
                                            {{ isset($exporting_fair_detail_setting['ef_for_visitor_url_text']) ? $exporting_fair_detail_setting['ef_for_visitor_url_text'] : '' }}
                                        </a>
                                    </button>
                                    <button class="button-exp-fill whitespace-nowrap">
                                        <a class="text-white fix-url" aria-label="Candian Exporters"
                                            href="{{ $exportingFair->press_url }}" target="_blank" onclick="fixUrls()">
                                            {{ isset($exporting_fair_detail_setting['ef_for_press_url_text']) ? $exporting_fair_detail_setting['ef_for_press_url_text'] : '' }}
                                        </a>
                                    </button>
                                </div>


                                <div class="flex flex-col sm:flex-row md:flex-row lg:flex-row items-center gap-4 mt-4">
                                    <div class="flex items-center gap-4 my-2">
                                        @isset($exportingFair->facebook_url)
                                            <a aria-label="Candian Exporters" target="_blank" onclick="fixUrls()"
                                                href="{{ $exportingFair->facebook_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url">
                                                <img class="h-4 md:h-5" src="{{ asset('/assets/icons/facebook canexp.png') }}"
                                                    alt="facebook icon">
                                            </a>
                                        @endisset
                                        @isset($exportingFair->twitter_url)
                                            <a aria-label="Candian Exporters" target="_blank" onclick="fixUrls()"
                                                href="{{ $exportingFair->twitter_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url">
                                                <img class="h-3 md:h-4" src="{{ asset('/assets/icons/twitter canexp.png') }}"
                                                    alt="twitter icon">
                                            </a>
                                        @endisset
                                        @isset($exportingFair->linkedin_url)
                                            <a aria-label="Candian Exporters" target="_blank" onclick="fixUrls()"
                                                href="{{ $exportingFair->linkedin_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url">
                                                <img class="h-3 md:h-5" src="{{ asset('/assets/icons/linkedin canexp.png') }}"
                                                    alt="linkedin icon">
                                            </a>
                                        @endisset
                                        @isset($exportingFair->youtube_url)
                                            <a aria-label="Candian Exporters" target="_blank" onclick="fixUrls()"
                                                href="{{ $exportingFair->youtube_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url">
                                                <img class="h-3 md:h-4" src="{{ asset('/assets/icons/youtube canexp.png') }}"
                                                    alt="youtube icon">
                                            </a>
                                        @endisset
                                    </div>
                                    <div class="flex items-center gap-4 my-2">

                                        @isset($exportingFair->pintrest_url)
                                            <a aria-label="Candian Exporters" target="_blank" onclick="fixUrls()"
                                                href="{{ $exportingFair->pintrest_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url">
                                                <img class="h-4 md:h-5" src="{{ asset('/assets/icons/pintrest canexp.png') }}"
                                                    alt="pintrest icon">
                                            </a>
                                        @endisset
                                        @isset($exportingFair->instagram_url)
                                            <a aria-label="Candian Exporters" target="_blank" onclick="fixUrls()"
                                                href="{{ $exportingFair->instagram_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url">
                                                <img class="h-4 md:h-5"
                                                    src="{{ asset('/assets/icons/instagaram canexp.png') }}"
                                                    alt="instagram icon">
                                            </a>
                                        @endisset
                                        @isset($exportingFair->snapchat_url)
                                            <a aria-label="Candian Exporters" target="_blank" onclick="fixUrls()"
                                                href="{{ $exportingFair->snapchat_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url">
                                                <img class="h-4 md:h-6"
                                                    src="{{ asset('/assets/icons/snapchat canexp.png') }}"
                                                    alt="snapchat icon">
                                            </a>
                                        @endisset
                                    </div>
                                </div>



                            </div>

                            <div class="order-1 md:order-1 lg:order-2">
                                <div class="">
                                    @isset($exportingFair->media)
                                        <div class="swiper mySwiper1 event-slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide h-60 md:h-80 rounded bg-gray-50">
                                                    @isset($exportingFair->media->large_image)
                                                        <img class="h-60 md:h-80 w-full object-cover rounded"
                                                            src="{{ asset($exportingFair->media->large_image) }}"
                                                            alt="Candian Exporters" />
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>
                                    @endisset



                                </div>

                            </div>

                        </div>

                        <div class="px-4 md:px-12 desktop:px-80 mt-4">
                            <div class="square">
                                <div class="text-primary can-exp-h2 mt-2">
                                    {{ isset($exporting_fair_detail_setting['description_text']) ? $exporting_fair_detail_setting['description_text'] : 'Description' }}
                                </div>
                                <div class="sm:pl-4 pb-2 pt-2 mb-4 md:float-right">
                                    <div class="border rounded">
                                        <div class="wrapper">
                                            @isset($exportingFair->video_url)
                                                {!! $exportingFair->video_url !!}
                                            @endisset
                                        </div>
                                    </div>
                                </div>

                                <p class="can-exp-p">
                                    @isset($exportingFair->exportingFairDetail[0])
                                        {!! $exportingFair->exportingFairDetail[0]->description !!}
                                    @endisset
                                </p>
                            </div>
                        </div>
                        <div class="clear-both mt-4">
                            <div class="px-4 md:px-12 desktop:px-80">
                                <h1 class="text-primary ">
                                    {{ isset($exporting_fair_detail_setting['organizer_contact_heading']) ? $exporting_fair_detail_setting['organizer_contact_heading'] : 'Contact organizer' }}
                                </h1>
                            </div>
                            <div
                                class="px-4 md:px-12 desktop:px-80 my-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <ul role="list" class="list-none p-0">
                                    <li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
                                        <div class="flex w-full items-center justify-between space-x-6 p-6">
                                            <div class="flex-1 truncate">
                                                <div class="flex items-center space-x-3">
                                                    <h4 class="text-primary truncate">
                                                        {{ $exportingFair->contact_name }}</h4>

                                                </div>
                                                <p class="mt-1 truncate">
                                                    {{ $exportingFair->contact_designation }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="flex w-0 flex-1">
                                                    <a href="mailto:{{ $exportingFair->contact_email }}"
                                                        class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
                                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                                            <path
                                                                d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                                        </svg>
                                                        <!-- {{ isset($exporting_fair_detail_setting['contact_email_text']) ? $exporting_fair_detail_setting['contact_email_text'] : '' }} -->
                                                        {{ $exportingFair->contact_email }}
                                                    </a>
                                                </div>
                                                <div class="-ml-px flex w-0 flex-1">
                                                    <a href="tel:{{ $exportingFair->contact_phone }}"
                                                        class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
                                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <!-- {{ isset($exporting_fair_detail_setting['contact_phone_text']) ? $exporting_fair_detail_setting['contact_phone_text'] : '' }} -->
                                                        {{ $exportingFair->contact_phone }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- More people... -->
                                </ul>

                            </div>
                        </div>
                    </div>

                </section>



            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection
