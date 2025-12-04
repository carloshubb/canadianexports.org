@php
    $customerProfiles = getFeaturedProfile($page->id);
@endphp
<section class="desktop:px-80 bg-primary lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
    <div class="container">
    <h2 class="can-exp-h1 text-center text-white">
            {!! $homePageSettingDetail->section4_heading !!}
        </h2>

        <div class="">
            <div class="swiper featured-exporter-slider-container relative z-0">
                <div class="swiper-wrapper">
                    @foreach ($customerProfiles as $customerProfile)
                    <div class="swiper-slide h-full">
                        <div class="bg-white w-full rounded border flex flex-col featured-exporter-swiper-slide">
                            <div class="p-4 flex-1">
                                <a aria-label="Candian Exporters" href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customerProfile['slug']]) }}" target="_blank" class="rounded flex justify-center items-center aspect-video bg-gray-50 fix-url" onclick="fixUrls()">
                                    @if (isset($customerProfile['customer_media']['customer_logo']['medium_image']) && $customerProfile['customer_media']['customer_logo']['medium_image'])
                                        <img src="{{ asset($customerProfile['customer_media']['customer_logo']['medium_image']) }}" class="object-cover aspect-video w-full rounded" alt="sponsor banner" />
                                    @else
                                        <img src="{{ asset('assets/images/logocircle.png') }}" class="object-contain aspect-video w-full rounded" alt="sponsor banner" />
                                    @endif
                                </a>

                                <div class="p-2 bg-gray-50 rounded-b">
                                    <h4 class="">
                                        <a class="text-lg sm:text-xl lg:text-2xl" href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customerProfile['slug']]) }}">
                                            {{ $customerProfile['company_name'] }}
                                        </a>
                                    </h4>
                                    <p class="truncate"> {!! strlen($customerProfile['short_description']) > 0
                                        ? $customerProfile['short_description']
                                        : \Illuminate\Support\Str::limit(strip_tags($customerProfile['description']), 100) !!}</p>
                                </div>
                            </div>


                        </div>
                    </div>
                    @endforeach


                </div>
                <div class="featured-exporter-button-next-exp absolute top-1/2 right-0 z-50">

                    <div class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </div>
                </div>
                <div class="featured-exporter-button-prev-exp  absolute top-1/2 left-0 z-50">
                    <div class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-10 flex justify-center gap-4">
            @php
                $url = $homePageSettingDetail->contact_for_rates_btn_url;
                $url = langBasedURL($lang, $url);
            @endphp
            <a aria-label="Candian Exporters" href="{!! $url !!}" class="button-exp-fill border-white">
                {!! $homePageSettingDetail->contact_for_rates_btn_text !!}
            </a>
        </div>


    </div>
</section>