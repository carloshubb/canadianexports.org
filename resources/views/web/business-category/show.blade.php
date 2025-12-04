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
        $page = isset($general_setting['business_profile_page']) ? $general_setting['business_profile_page'] : null;
        $page = getPageBySlug($page);
        $advertiserSetting = getI2bModalSetting(null, ['business_profile_setting']);
    @endphp
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="container">
                <section class="">
                    <div class="flex justify-center mb-8 items-center space-x-2">
                        @isset($customer->customerMedia->customerLogo)
                            <img src="{{ asset($customer->customerMedia->customerLogo->thumbnail_image) }}" class="w-32"
                                alt="Candian Exporters">
                        @endisset
                        <h2 class="can-exp-h1 text-center mb-0">
                            {{ $customer->company_name }}</h2>
                    </div>
                    <!--Tabs-->
                    <div class="flex flex-wrap" id="tabs-id">
                        <div class="w-full">
                            <div class="flex list-none flex-wrap justify-center md:justify-start gap-2 mb-4 flex-row">
                                <a aria-label="Candian Exporters"
                                    class="button-exp-fill cursor-pointer business-profile-tab"
                                    onclick="changeAtiveTab(event,'tab-overview')"
                                    id="tab-overview-btn">{{ isset($advertiserSetting) ? $advertiserSetting['overview_tab_text'] : 'Overview' }}</a>
                                <a aria-label="Candian Exporters"
                                    class="button-exp-no-fill cursor-pointer business-profile-tab"
                                    onclick="changeAtiveTab(event,'tab-media')"
                                    id="tab-media-btn">{{ isset($advertiserSetting) ? $advertiserSetting['media_tab_text'] : 'Media' }}</a>
                                <a aria-label="Candian Exporters"
                                    class="button-exp-no-fill cursor-pointer business-profile-tab"
                                    onclick="changeAtiveTab(event,'tab-contact')"
                                    id="tab-contact-btn">{{ isset($advertiserSetting) ? $advertiserSetting['contact_tab_text'] : 'Contact' }}</a>
                            </div>
                            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow rounded">
                                <div class="flex-auto">
                                    <div class="tab-content tab-space">
                                        <div class="block p-4" id="tab-overview">
                                            <div class="square">
                                                <div class="sm:pl-4 pb-4 pt-2 md:float-right">
                                                    <div class="border rounded">
                                                        <div class="wrapper">
                                                            <div id="iframe-placeholder"></div>
                                                        </div>
                                                        <div class="my-5 flex justify-center">
                                                            <a aria-label="Candian Exporters"
                                                                href="{{ $customer->website }}"
                                                                class="button-exp-fill fix-url" onclick="fixUrls()"
                                                                target="_blank">
                                                                {{ isset($advertiserSetting) ? $advertiserSetting['visit_our_website_text'] : 'Visit our website' }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="text-justify lg:text-lg">
                                                    {!! $customer->description !!}
                                                </p>
                                            </div>

                                        </div>
                                        <div class="hidden p-4" id="tab-media">
                                            <h3 class="can-exp-h2">
                                                {{ $customer->customerMedia->title ?? '' }}
                                            </h3>
                                            <p class="">
                                                {{ $customer->customerMedia->description ?? '' }}
                                            </p>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 my-10">
                                                @php
                                                    $galleryImages = isset(
                                                        $customer->customerMedia,
                                                        $customer->customerMedia->customerGalleryImages,
                                                    )
                                                        ? $customer->customerMedia->customerGalleryImages
                                                        : null;
                                                @endphp
                                                @isset($galleryImages)
                                                    @foreach ($galleryImages as $galleryImage)
                                                        @if (isset($galleryImage->media))
                                                            <div class="border rounded shadow p-1 bg-gray-50 aspect-video">
                                                                <a href="{{ asset($galleryImage->media->large_image) }}"
                                                                    data-lightbox="image-1">
                                                                    <img class=" object-contain aspect-video w-full xelent-image-zoom"
                                                                        src="{{ asset($galleryImage->media->thumbnail_image) }}"
                                                                        data-lightbox="roadtrip" alt="image 1" />
                                                                </a>

                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endisset
                                            </div>
                                        </div>
                                        <div class="hidden" id="tab-contact">

                                            <!--new tab-->
                                            <div class="relative isolate bg-white">
                                                <div class="mx-auto grid max-w-7xl grid-cols-1 lg:grid-cols-2">

                                                    <form action="#" method="POST"
                                                        class="px-6 py-2 md:py-10 lg:static lg:px-8 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10">
                                                        <div class="mb-8">
                                                            <h3 class="can-exp-h2">
                                                                {{ isset($advertiserSetting) ? $advertiserSetting['contact_tab_heading'] : 'Send us a message' }}
                                                                {{ $customer->company_name }}
                                                            </h3>
                                                            <p class="flex items-center text-red-600">
                                                                <span class="text-red-600 mr-1 mt-2 text-base">*</span>
                                                                {{ isset($advertiserSetting) ? $advertiserSetting['contact_tab_required_fields_text'] : '' }}
                                                            </p>
                                                        </div>
                                                        <advertisers-contact-form
                                                            aria-label="Candian Exporters"dvertisers-contact-form
                                                            submit_url="{{ route('user.business-category.send-message') }}"
                                                            customer_id="{{ $customer->id }}"
                                                            advertiser_setting="{{ $advertiserSetting }}"
                                                            page_id="{{ isset($page) ? $page->id : null }}">
                                                        </advertisers-contact-form>
                                                    </form>
                                                    <div
                                                        class="relative px-6 pt-10 pb-10 lg:static lg:px-8 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10">

                                                        <div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
                                                            <div
                                                                class="absolute right-0 inset-y-0 -z-10 w-full overflow-hidden bg-gray-100 ring-1 ring-gray-900/10 lg:w-1/2">
                                                                <svg class="absolute inset-0 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
                                                                    aria-hidden="true">
                                                                    <rect width="100%" height="100%" stroke-width="0"
                                                                        fill="white" />

                                                                </svg>
                                                            </div>
                                                            <h3 class="can-exp-h2">
                                                                {{ isset($advertiserSetting['contact_information_heading_text'])
                                                                    ? $advertiserSetting['contact_information_heading_text']
                                                                    : 'Contact information' }}
                                                            </h3>
                                                            {{-- <p class="card-heading text-primary">
                                                                {{ isset($customer->customer->name) ? $customer->customer->name : '' }}
                                                            </p> --}}
                                                            <dl class="mt-1 space-y-4 leading-7 text-gray-600">
                                                                <div class="flex gap-x-4">
                                                                    <dt class="flex-none">
                                                                        <span class="sr-only">Name</span>
                                                                        <svg class="h-7 w-6 text-gray-400" fill="none"
                                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                                            stroke="currentColor" aria-hidden="true">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M15.75 9A3.75 3.75 0 1112 5.25 3.75 3.75 0 0115.75 9zm-9 11.25a9 9 0 1118 0H6.75z" />
                                                                        </svg>
                                                                    </dt>
                                                                    <dd>
                                                                        <a aria-label="Canadian Exporters"
                                                                            class="text-gray-800 break-all">
                                                                            <pre class="font-Nunito">{{ $customer->customer->name }}</pre>
                                                                        </a>
                                                                    </dd>
                                                                </div>
                                                                <div class="flex gap-x-4">
                                                                    <dt class="flex-none">
                                                                        <span class="sr-only">Address</span>
                                                                        <svg class="h-7 w-6 text-gray-400" fill="none"
                                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                                            stroke="currentColor" aria-hidden="true">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                                                        </svg>
                                                                    </dt>
                                                                    <dd> <a aria-label="Candian Exporters"
                                                                            class="text-gray-800 break-all">
                                                                            <pre class="font-Nunito">{{ $customer->address }}</pre>
                                                                        </a>
                                                                    </dd>
                                                                </div>
                                                                <div class="flex gap-x-4">
                                                                    <dt class="flex-none">
                                                                        <span class="sr-only">Telephone</span>
                                                                        <svg class="h-7 w-6 text-gray-400" fill="none"
                                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                                            stroke="currentColor" aria-hidden="true">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                                                        </svg>
                                                                    </dt>
                                                                    <dd><a aria-label="Candian Exporters"
                                                                            href="tel:{{ $customer->phone }}"
                                                                            class="text-gray-800 break-all">{{ $customer->phone }}</a>
                                                                    </dd>
                                                                </div>
                                                                <div class="flex gap-x-4">
                                                                    <dt class="flex-none">
                                                                        <span class="sr-only">Email</span>
                                                                        <svg class="h-7 w-6 text-gray-400" fill="none"
                                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                                            stroke="currentColor" aria-hidden="true">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                                        </svg>
                                                                    </dt>
                                                                    <dd><a aria-label="Candian Exporters"
                                                                            href="mailto:{{ $customer->company_email }}"
                                                                            class="text-gray-800 break-all">{{ $customer->company_email }}</a>
                                                                    </dd>
                                                                </div>
                                                                <div class="flex gap-x-4">
                                                                    <dt class="flex-none">
                                                                        <span class="sr-only">link</span>
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-6 h-6 text-gray-400">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                                                        </svg>
                                                                    </dt>
                                                                    <dd><a aria-label="Candian Exporters"
                                                                            href="{{ $customer->website }}"
                                                                            target="_blank"
                                                                            class="text-gray-800 break-all fix-url"
                                                                            onclick="fixUrls()">{{ $customer->website }}</a>
                                                                    </dd>
                                                                </div>
                                                                <div class="flex gap-x-4">
                                                                    @php
                                                                        $ctaLink = $customer->cta_link ?? '';
                                                                        $ctaBtn = $customer->cta_btn ?? '';

                                                                        if (
                                                                            !empty($ctaLink) &&
                                                                            !str_starts_with($ctaLink, 'http://') &&
                                                                            !str_starts_with($ctaLink, 'https://')
                                                                        ) {
                                                                            $ctaLink = 'https://' . $ctaLink; // Automatically add https:// if missing
                                                                        }
                                                                    @endphp

                                                                    @if (!empty($ctaLink) && !empty($ctaBtn))
                                                                        <a href="{{ $ctaLink }}" target="_blank"
                                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                                                            id="cta-button">
                                                                            {{ $ctaBtn }}
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    class="flex flex-col sm:flex-col md:flex-row lg:flex-row justify-between items-center py-2 rounded gap-6">
                                                                    <div
                                                                        class="flex flex-col sm:flex-row md:flex-row lg:flex-row items-center gap-4 my-2">
                                                                        <div class="flex items-center gap-4 my-2">
                                                                            @if (isset($customer->customer->customerSocialMedia->facebook))
                                                                                <a aria-label="Candian Exporters"
                                                                                    target="_blank"
                                                                                    href="{{ $customer->customer->customerSocialMedia->facebook }}"
                                                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url"
                                                                                    onclick="fixUrls()">
                                                                                    <img class="h-4 md:h-5"
                                                                                        src="{{ asset('/assets/icons/facebook canexp.png') }}"
                                                                                        alt="facebook icon">
                                                                                </a>
                                                                            @endif
                                                                            @if (isset($customer->customer->customerSocialMedia->twitter))
                                                                                <a aria-label="Candian Exporters"
                                                                                    target="_blank"
                                                                                    href="{{ $customer->customer->customerSocialMedia->twitter }}"
                                                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url"
                                                                                    onclick="fixUrls()">
                                                                                    <img class="h-3 md:h-4"
                                                                                        src="{{ asset('/assets/icons/twitter canexp.png') }}"
                                                                                        alt="twitter icon">
                                                                                </a>
                                                                            @endif
                                                                            @if (isset($customer->customer->customerSocialMedia->linked_in))
                                                                                <a aria-label="Candian Exporters"
                                                                                    target="_blank"
                                                                                    href="{{ $customer->customer->customerSocialMedia->linked_in }}"
                                                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url"
                                                                                    onclick="fixUrls()">
                                                                                    <img class="h-3 md:h-5"
                                                                                        src="{{ asset('/assets/icons/linkedin canexp.png') }}"
                                                                                        alt="linkedin icon">
                                                                                </a>
                                                                            @endif
                                                                            @if (isset($customer->customer->customerSocialMedia->youtube))
                                                                                <a aria-label="Candian Exporters"
                                                                                    target="_blank"
                                                                                    href="{{ $customer->customer->customerSocialMedia->youtube }}"
                                                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url"
                                                                                    onclick="fixUrls()">
                                                                                    <img class="h-3 md:h-4"
                                                                                        src="{{ asset('/assets/icons/youtube canexp.png') }}"
                                                                                        alt="youtube icon">
                                                                                </a>
                                                                            @endif
                                                                            @if (isset($customer->customer->customerSocialMedia->social_media5))
                                                                                <a aria-label="Candian Exporters"
                                                                                    target="_blank"
                                                                                    href="{{ $customer->customer->customerSocialMedia->social_media5 }}"
                                                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 fix-url"
                                                                                    onclick="fixUrls()">
                                                                                    {{-- <img class="h-3 md:h-4"
                                src="{{ asset('/assets/icons/google canexp.png') }}"
                                alt="google icon"> --}}
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        fill="none" viewBox="0 0 24 24"
                                                                                        stroke-width="1.5"
                                                                                        stroke="currentColor"
                                                                                        class="h-3 md:h-4">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                                                                    </svg>

                                                                                </a>
                                                                            @endif
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>





                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </section>
            </div>
        </div>
    </div>
    <div id="script-placeholder"></div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('plugins/lightbox2-2.11.4/dist/css/lightbox.min.css') }}">
    <script src="{{ asset('plugins/lightbox2-2.11.4/dist/js/lightbox.min.js') }}"></script>
    <script type="text/javascript">
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        });

        function loadScript() {
            const scriptPlaceholder = document.getElementById('script-placeholder');
            const script = document.createElement('script');
            script.src = 'https://www.google.com/recaptcha/api.js';
            scriptPlaceholder.appendChild(script);
        }


        // window.addEventListener('load', function() {
        //     const iframeHtml = `{!! isset($customer->customerMedia->video);
        //         ? $customer->customerMedia->video_frame
        //         : '<iframe class="media-iframe" src="https://www.youtube.com/embed/xZGPCklgdGc?si=iGzu5XP5J6NNmKr9" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' !!}`;

        //     const iframePlaceholder = document.getElementById('iframe-placeholder');
        //     iframePlaceholder.innerHTML = iframeHtml;

        //     const iframe = iframePlaceholder.querySelector('iframe');
        //     if (iframe) {
        //         iframe.classList.add('media-iframe'); // Add your class here
        //     }

        //     loadScript();
        // });
        window.addEventListener('load', function() {
            let videoUrl = `{!! isset($customer->customerMedia->video) ? $customer->customerMedia->video : '' !!}`;

            function convertToEmbed(url) {
                let videoId = '';
                if (url.includes("youtube.com/watch?v=")) {
                    videoId = url.split("v=")[1].split("&")[0]; // Extract video ID
                } else if (url.includes("youtu.be/")) {
                    videoId = url.split("youtu.be/")[1].split("?")[0]; // Extract from shortened URL
                }

                return videoId ? `https://www.youtube.com/embed/${videoId}` :
                    'https://www.youtube.com/embed/xZGPCklgdGc?si=iGzu5XP5J6NNmKr9';
            }

            let embedUrl = convertToEmbed(videoUrl);

            const iframeHtml =
                `<iframe class="media-iframe" src="${embedUrl}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;

            const iframePlaceholder = document.getElementById('iframe-placeholder');
            iframePlaceholder.innerHTML = iframeHtml;

            const iframe = iframePlaceholder.querySelector('iframe');
            if (iframe) {
                iframe.classList.add('media-iframe');
            }
        });


        function changeAtiveTab(event, tabID) {
            if (tabID == 'tab-overview') {
                document.getElementById("tab-media").classList.add("hidden");
                document.getElementById("tab-media").classList.remove("block");
                document.getElementById("tab-contact").classList.add("hidden");
                document.getElementById("tab-contact").classList.remove("block");
                document.getElementById("tab-overview").classList.add("block");
                document.getElementById("tab-overview").classList.remove("hidden");

                document.getElementById("tab-overview-btn").classList.add("button-exp-fill");
                document.getElementById("tab-overview-btn").classList.remove("button-exp-no-fill");
                document.getElementById("tab-contact-btn").classList.remove("button-exp-fill");
                document.getElementById("tab-media-btn").classList.remove("button-exp-fill");
                document.getElementById("tab-contact-btn").classList.add("button-exp-no-fill");
                document.getElementById("tab-media-btn").classList.add("button-exp-no-fill");
            } else if (tabID == 'tab-media') {
                document.getElementById("tab-overview").classList.add("hidden");
                document.getElementById("tab-overview").classList.remove("block");
                document.getElementById("tab-contact").classList.add("hidden");
                document.getElementById("tab-contact").classList.remove("block");
                document.getElementById("tab-media").classList.add("block");
                document.getElementById("tab-media").classList.remove("hidden");

                document.getElementById("tab-media-btn").classList.add("button-exp-fill");
                document.getElementById("tab-media-btn").classList.remove("button-exp-no-fill");
                document.getElementById("tab-contact-btn").classList.remove("button-exp-fill");
                document.getElementById("tab-overview-btn").classList.remove("button-exp-fill");
                document.getElementById("tab-contact-btn").classList.add("button-exp-no-fill");
                document.getElementById("tab-overview-btn").classList.add("button-exp-no-fill");
            } else if (tabID == 'tab-contact') {
                document.getElementById("tab-overview").classList.add("hidden");
                document.getElementById("tab-overview").classList.remove("block");
                document.getElementById("tab-media").classList.add("hidden");
                document.getElementById("tab-media").classList.remove("block");
                document.getElementById("tab-contact").classList.add("block");
                document.getElementById("tab-contact").classList.remove("hidden");

                document.getElementById("tab-contact-btn").classList.add("button-exp-fill");
                document.getElementById("tab-contact-btn").classList.remove("button-exp-no-fill");
                document.getElementById("tab-media-btn").classList.remove("button-exp-fill");
                document.getElementById("tab-overview-btn").classList.remove("button-exp-fill");
                document.getElementById("tab-media-btn").classList.add("button-exp-no-fill");
                document.getElementById("tab-overview-btn").classList.add("button-exp-no-fill");
            }
            let postObj = {
                type: tabID,
                profile_id: '{{ $customer->id }}'
            };

            let xhr = new XMLHttpRequest();

            let url = '{{ route('web.api.visitor-stats') }}';
            xhr.open("POST", url, true);
            xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
            xhr.setRequestHeader('X-CSRF-TOKEN', document.head.querySelector('meta[name="csrf-token"]').content)

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
            }

            xhr.send(JSON.stringify(postObj));
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener for CTA button click
            const ctaButton = document.getElementById('cta-button');
            if (ctaButton) {
                ctaButton.addEventListener('click', function() {
                    let postObj = {
                        type: 'cta_click',
                        profile_id: '{{ $customer->id }}'
                    };

                    let xhr = new XMLHttpRequest();

                    let url = '{{ route('web.api.visitor-stats') }}';
                    xhr.open("POST", url, true);
                    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.head.querySelector(
                        'meta[name="csrf-token"]').content);

                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText);
                        }
                    };

                    xhr.send(JSON.stringify(postObj));
                });
            }
        });
    </script>
@endsection
