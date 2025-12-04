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
        $event_detail_setting = getI2bModalSetting($lang, ['event_detail_setting']);
    @endphp
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 container">
            <div class="">

                <section class="mb-4">
                    <div class=" bg-white rounded shadow pt-6">
                        <div class="px-4 md:px-12 desktop:px-80">
                            <h2 class="text-primary text-center">
                                @isset($event->eventDetail[0])
                                    {!! $event->eventDetail[0]->title !!}
                                @endisset
                            </h2>
                        </div>
                        <div class="px-4 md:px-12 desktop:px-80">
                            <p class="">
                                @isset($event->eventDetail[0])
                                    {!! $event->eventDetail[0]->short_description !!}
                                @endisset
                            </p>
                        </div>
                        <div class="px-4 md:px-12 desktop:px-80 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 mt-8">
                            <div class="order-2 md:order-2 lg:order-1 mt-[5px]">
                                <table class="border-spacing-y-3 border-separate border-none">
                                    <tbody>
                                        <tr class="mb-3 border-none">
                                            <td
                                                class="text-primary mr-4 text-base md:text-base lg:text-lg border-none break-all align-top whitespace-nowrap">
                                                {{ isset($event_detail_setting['event_date_text']) ? $event_detail_setting['event_date_text'] : '' }}
                                            </td>
                                            <td
                                                class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                {{ date('F d, Y', strtotime($event->start_date)) }} -
                                                {{ date('F d, Y', strtotime($event->end_date)) }}</td>
                                        </tr>
                                        <tr class="mb-3 border-none">
                                            <td
                                                class="text-primary mr-4 text-base md:text-base lg:text-lg border-none break-all align-top whitespace-nowrap">
                                                {{ isset($event_detail_setting['venue_text']) ? $event_detail_setting['venue_text'] : '' }}
                                            </td>
                                            <td
                                                class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                @isset($event->eventDetail[0])
                                                    {!! $event->eventDetail[0]->venue !!}
                                                @endisset
                                            </td>
                                        </tr>
                                        <tr class="mb-3 border-none">
                                            <td
                                                class="text-primary mr-4 text-base md:text-base lg:text-lg border-none break-all align-top whitespace-nowrap">
                                                {{ isset($event_detail_setting['location_text']) ? $event_detail_setting['location_text'] : '' }}
                                            </td>
                                            <td
                                                class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                @isset($event->eventDetail[0])
                                                    {!! $event->eventDetail[0]->city !!},
                                                @endisset

                                                @isset($event->eventDetail[0])
                                                    {!! $event->eventDetail[0]->country !!}
                                                @endisset

                                            </td>
                                        </tr>
                                        <tr class="mb-3 border-none">
                                            <td
                                                class="text-primary mr-4 text-base md:text-base lg:text-lg border-none break-all align-top whitespace-nowrap">
                                                {{ isset($event_detail_setting['product_search_text']) ? $event_detail_setting['product_search_text'] : '' }}
                                            </td>
                                            <td
                                                class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                @isset($event->eventDetail[0])
                                                    {!! $event->eventDetail[0]->product_search !!}
                                                @endisset
                                            </td>
                                        </tr>

                                        <tr class="mb-3 border-none">


                                        </tr>


                                    </tbody>
                                </table>
                                <div class="text-base md:text-base lg:text-lg border-none break-all align-top flex flex-col sm:flex-col md:flex-row lg:flex-row gap-4 items-center">
                                    <button class="button-exp-fill whitespace-nowrap">
                                        <a class="text-white fix-url" onclick="fixUrls()" aria-label="Candian Exporters"
                                            href="{{ $event->exibitors_url }}" target="_blank">
                                            {{ isset($event_detail_setting['for_exibitor_url_text']) ? $event_detail_setting['for_exibitor_url_text'] : '' }}
                                        </a>
                                    </button>
                                    <button class="button-exp-fill whitespace-nowrap">
                                        <a class="text-white fix-url" onclick="fixUrls()" aria-label="Candian Exporters"
                                            href="{{ $event->visitors_url }}" target="_blank">
                                            {{ isset($event_detail_setting['for_visitor_url_text']) ? $event_detail_setting['for_visitor_url_text'] : '' }}
                                        </a>
                                    </button>
                                    <button class="button-exp-fill whitespace-nowrap">
                                        <a class="text-white fix-url" onclick="fixUrls()" aria-label="Candian Exporters" href="{{ $event->press_url }}"
                                            target="_blank">
                                            {{ isset($event_detail_setting['for_press_url_text']) ? $event_detail_setting['for_press_url_text'] : '' }}
                                        </a>
                                    </button>
                                </div>

                                <div class="flex flex-col sm:flex-row md:flex-row lg:flex-row items-center gap-4 mt-4 w-full">
                                    <div class="flex items-center gap-4 my-2">
                                        @isset($event->facebook_url)
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ $event->facebook_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url" onclick="fixUrls()">
                                                <img class="h-4 md:h-5"
                                                    src="{{ asset('/assets/icons/facebook canexp.png') }}"
                                                    alt="facebook icon">
                                            </a>
                                        @endisset
                                        @isset($event->twitter_url)
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ $event->twitter_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url" onclick="fixUrls()">
                                                <img class="h-3 md:h-4" src="{{ asset('/assets/icons/twitter canexp.png') }}"
                                                    alt="twitter icon">
                                            </a>
                                        @endisset
                                        @isset($event->linkedin_url)
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ $event->linkedin_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url" onclick="fixUrls()">
                                                <img class="h-3 md:h-5"
                                                    src="{{ asset('/assets/icons/linkedin canexp.png') }}"
                                                    alt="linkedin icon">
                                            </a>
                                        @endisset
                                        @isset($event->youtube_url)
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ $event->youtube_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url" onclick="fixUrls()">
                                                <img class="h-3 md:h-4" src="{{ asset('/assets/icons/youtube canexp.png') }}"
                                                    alt="youtube icon">
                                            </a>
                                        @endisset
                                    </div>
                                    <div class="flex items-center gap-4 my-2">

                                        @isset($event->pintrest_url)
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ $event->pintrest_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url" onclick="fixUrls()">
                                                <img class="h-4 md:h-5"
                                                    src="{{ asset('/assets/icons/pintrest canexp.png') }}"
                                                    alt="pintrest icon">
                                            </a>
                                        @endisset
                                        @isset($event->instagram_url)
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ $event->instagram_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url" onclick="fixUrls()">
                                                <img class="h-4 md:h-5"
                                                    src="{{ asset('/assets/icons/instagaram canexp.png') }}"
                                                    alt="instagram icon">
                                            </a>
                                        @endisset
                                        @isset($event->snapchat_url)
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ $event->snapchat_url }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url" onclick="fixUrls()">
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

                                    @isset($event->eventMedia)
                                        <div class="swiper mySwiper1 event-slider">
                                            <div class="swiper-wrapper">
                                                @foreach ($event->eventMedia as $eventMedia)
                                                    <div class="swiper-slide h-60 md:h-80 rounded bg-gray-50">
                                                        @isset($eventMedia->media->large_image)
                                                            <img class="h-60 md:h-80 w-full object-cover rounded"
                                                                src="{{ asset($eventMedia->media->large_image) }}"
                                                                alt="Candian Exporters">
                                                        @endisset
                                                    </div>
                                                @endforeach

                                            </div>
                                            @if (count($event->eventMedia) > 1)
                                            <div class="swiper-pagination"></div>
                                            <div class="swiper-button-next-event">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6 md:h-9 md:w-9 text-primaryRed">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="swiper-button-prev-event">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6 md:h-9 md:w-9 text-primaryRed">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            @endif
                                        </div>
                                    @endisset
                                    @if (count($event->eventMedia) > 1)
                                        <div class="swiper mySwiper2 event-slider-thumbnails">
                                            <div class="swiper-wrapper">
                                                @foreach ($event->eventMedia as $eventMedia)
                                                    <div class="swiper-slide">
                                                        @isset($eventMedia->media->thumbnail_image)
                                                            <img class="w-full h-20 object-cover rounded"
                                                                src="{{ asset($eventMedia->media->thumbnail_image) }}"
                                                                alt="Thumbnail">
                                                        @endisset
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif



                                </div>

                            </div>

                        </div>

                        <div class="px-4 md:px-12 desktop:px-80 mt-4">
                            <div class="square">
                                <div class="text-primary can-exp-h2 mt-2">
                                    {{ isset($event_detail_setting['description_text']) ? $event_detail_setting['description_text'] : '' }}
                                </div>
                                <div class="sm:pl-4 pb-2 pt-2 mb-4 md:float-right">
                                    <div class="border rounded-lg overflow-hidden">
                                            @if ($event->video_url)
                                                @php
                                                    $youtubeUrl = $event->video_url;
                                                    // Extract the video ID from the URL
                                                    parse_str(parse_url($youtubeUrl, PHP_URL_QUERY), $query);
                                                    $videoId = $query['v'] ?? '';
                                                @endphp

                                                @if (!empty($videoId))
                                                {{-- Embed the YouTube video using an iframe --}}
                                                <iframe class="mx-auto rounded-md md:w-[500px] md:h-[300px] w-full h-[300px]" 
                                                src="https://www.youtube.com/embed/{{ $videoId }}">
                                            </iframe>
                                            @else
                                                <div class="aspect-video h-64 iframe_wrapper">
                                                    {!! $event->video_url !!}
                                                </div>
                                                @endif
                                            @endif
                                    </div>
                                </div>

                                <p class="can-exp-p">
                                    @isset($event->eventDetail[0])
                                        {!! $event->eventDetail[0]->description !!}
                                    @endisset
                                </p>
                            </div>
                        </div>
                        <div class="clear-both mt-4">
                            @php
                                $contacts = isset($event->eventContacts) ? $event->eventContacts : [];
                            @endphp
                            @if (count($contacts) > 0)
                                <div class="px-4 md:px-12 desktop:px-80">
                                    <h1 class="text-primary ">
                                        {{ isset($event_detail_setting['organizer_contact_heading']) ? $event_detail_setting['organizer_contact_heading'] : '' }}
                                    </h1>
                                </div>
                                <div
                                    class="px-4 md:px-12 desktop:px-80 my-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($contacts as $contact)
                                        <ul role="list" class="list-none p-0">
                                            <li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
                                                <div class="flex w-full items-center justify-between space-x-6 p-6">
                                                    <div class="flex-1 truncate">
                                                        <div class="flex items-center space-x-3">
                                                            <h4 class="text-primary truncate">{{ $contact->name }}</h4>

                                                        </div>
                                                        <p class="mt-1 truncate">{{ $contact->designation }}</p>
                                                    </div>
                                                    @if (isset($contact->image_path) && file_exists($contact->image_path))
                                                        @php
                                                            $image_path = $contact->image_path;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $image_path = 'https://ui-avatars.com/api/?name={{ $contact->name }}&color=7F9CF5&background=EBF4FF';
                                                        @endphp
                                                    @endif
                                                    <img class="h-14 w-14 rounded-full shadow bg-gray-50"
                                                        src="{{ $contact->image_path }}" alt="profile image" />
                                                </div>
                                                <div>
                                                    <div class="-mt-px flex divide-x divide-gray-200">
                                                        <div class="flex w-0 flex-1">
                                                            <a href="mailto:{{ $contact->email }}"
                                                                class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 px-2 text-sm font-semibold text-gray-900">
                                                                <div>
                                                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                                    fill="currentColor" aria-hidden="true">
                                                                    <path
                                                                        d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                                                    <path
                                                                        d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                                                    </svg>
                                                                </div>
                                                               <div class="truncate">
                                                                     <!-- {{ isset($event_detail_setting['contact_email_text']) ? $event_detail_setting['contact_email_text'] : '' }} -->
                                                                    {{$contact->email}}
                                                               </div>
                                                            </a>
                                                        </div>
                                                        <div class="-ml-px flex w-0 flex-1">
                                                            <a href="tel:{{ $contact->phone }}"
                                                                class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 px-2 text-sm font-semibold text-gray-900">
                                                                <div>
                                                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                                    fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd"
                                                                        d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                                                        clip-rule="evenodd" />
                                                                    </svg>
                                                                </div>
                                                                <div class="truncate">
                                                                    <!-- {{ isset($event_detail_setting['contact_phone_text']) ? $event_detail_setting['contact_phone_text'] : '' }} -->
                                                                {{$contact->phone}}
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <!-- More people... -->
                                        </ul>
                                    @endforeach

                                </div>
                            @endif


                            <div
                                class="px-4 md:px-12 desktop:px-80 flex flex-col sm:flex-col md:flex-row lg:flex-row justify-between items-center mt-3 bg-gray-50 py-2 rounded gap-6">

                                <div class="w-full flex justify-center">
                                    <a aria-label="Candian Exporters" href="{{ $event->event_website }}" target="_blank"
                                        class="button-exp-fill fix-url" onclick="fixUrls()">{{ isset($event_detail_setting['book_a_stand_text']) ? $event_detail_setting['book_a_stand_text'] : '' }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>


            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        setTimeout(() => {
            const mainSlider = new Swiper(".mySwiper1", {
                // Main slider parameters
                slidesPerView: 1,
                spaceBetween: 40,
                speed: 400,
                pagination: {
                    el: ".swiper-pagination",
                },
                navigation: {
                    nextEl: ".swiper-button-next-event",
                    prevEl: ".swiper-button-prev-event",
                },
                thumbs: {
                    swiper: {
                        el: ".mySwiper2",
                        slidesPerView: 4, // Number of thumbnails per view
                    },
                },
            });

            const thumbsSlider = new Swiper(".mySwiper2", {
                // Thumbnail slider parameters
                spaceBetween: 10,
                slidesPerView: 4,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
            });
        }, 3000);
    </script>

@endsection
