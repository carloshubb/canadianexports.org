@php
    $customerProfiles = getFeaturedProfile($page->id);
@endphp
<section class="home-container desktop:px-80 lg:py-[100px] md:pt-10 md:pb-10 pt-10 pb-10 bg-white">
        <h2 class="can-exp-h1 text-center font-semibold text-[#006EB7]">
            {!! $homePageSettingDetail->section4_heading !!}
        </h2>

        <div class="mt-12 relative">
            <div class="swiper featured-exporter-slider-container z-0" style="padding:0 !important;">
                <div class="swiper-wrapper">
                    @foreach ($customerProfiles as $customerProfile)
                    <div class="swiper-slide h-full">
                        <div class="w-full flex flex-col featured-exporter-swiper-slide">
                            <div class="flex-1 relative">
                                <a aria-label="Candian Exporters" href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customerProfile['slug']]) }}" target="_blank" class="rounded flex justify-center items-center fix-url" onclick="fixUrls()">
                                    @if (isset($customerProfile['customer_media']['customer_logo']['medium_image']) && $customerProfile['customer_media']['customer_logo']['medium_image'])
                                        <img src="{{ asset($customerProfile['customer_media']['customer_logo']['medium_image']) }}" class="object-cover aspect-square rounded-full" alt="sponsor banner" />
                                    @else
                                        <img src="{{ asset('assets/images/logocircle.png') }}" class="object-cover aspect-square rounded-full" alt="sponsor banner" />
                                    @endif
                                </a>

                                <div class="pt-8 text-center">
                                    <h4 class="font-semibold text-lg sm:text-xl lg:text-2xl text-black">
                                        {{ $customerProfile['company_name'] }}
                                    </h4>
                                    <p class="truncate text-sm text-center text-gray-600 pt-2"> {!! strlen($customerProfile['short_description']) > 0
                                        ? $customerProfile['short_description']
                                        : \Illuminate\Support\Str::limit(strip_tags($customerProfile['description']), 100) !!}</p>
                                    <a class="text-sm" href="{{ route('user.business-category.show', ['abbreviation' => $lang->abbreviation, 'slug' => $customerProfile['slug']]) }}">
                                        Learn more</a>
                                </div>
                            </div>


                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
            <div class="featured-exporter-button-next-exp absolute z-50" style="right: -72px; top: 38%; transform: translateY(-50%);">
                <div class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>
                </div>
            </div>
            <div class="featured-exporter-button-prev-exp absolute z-50" style="left: -72px; top: 38%; transform: translateY(-50%);">
                <div class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="mt-10 flex justify-center gap-4">
            @php
                $url = $homePageSettingDetail->contact_for_rates_btn_url;
                $url = langBasedURL($lang, $url);
            @endphp
            <a aria-label="Candian Exporters" href="{!! $url !!}" class="button-exp-fill flex justify-center items-center w-72 h-[56px] rounded-none">
                {!! $homePageSettingDetail->contact_for_rates_btn_text !!}
            </a>
        </div>


</section>