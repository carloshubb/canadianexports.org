@php
    $issues = getLatestCurrentIssue($lang);
@endphp
<section class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 desktop:px-80">
    <div class="container">
        <h2 class="can-exp-h1 mb-4 text-center">{!! $homePageSettingDetail->section6_heading !!}</h2>
        <div class="text-center">{!! $homePageSettingDetail->section6_description !!}</div>

        <div class="swiper magazine-slider-container relative z-0">
            <div class="swiper-wrapper">
                @for ($i = 0; $i < count($issues); $i++)
                <div class="swiper-slide">
                    <div class="flex items-center gap-4 justify-center">
                        <a aria-label="Canadian Exporters" target="_blank" class="w-80 p-1 bg-white flex justify-center items-center rounded" href="{{ isset($issues[$i]->pdf) ? $issues[$i]->pdf : '#' }}">
                            <img src="{{ isset($issues[$i]->media) && file_exists(($issues[$i]->media->medium_image)) ? asset($issues[$i]->media->medium_image) : asset('assets/images/logocircle.png') }}" class="object-contain aspect-square rounded" alt="Canadian Exports magazine" />
                        </a>
                    </div>
                </div>
            @endfor


            </div>
            <div class="magazine-button-next-exp absolute top-1/2 right-0 z-50">

                <div
                    class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>
                </div>
            </div>
            <div class="magazine-button-prev-exp  absolute top-1/2 left-0 z-50">
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
        <div class="mt-10 w-full flex justify-center">
            @php
                $url = isset($general_setting['see_all_magazine_page']) ? route('front.index', $general_setting['see_all_magazine_page']) : '#';
                $url = langBasedURL($lang, $url);
            @endphp
            <a aria-label="Candian Exporters" href="{{ $url }}" class="button-exp-fill border-white">{!! $homePageSettingDetail->section6_see_all_button !!}</a>
        </div>


    </div>
</section>

