@php
    $issues = getLatestCurrentIssue($lang);
@endphp
<section class="home-container lg:pt-14 lg:py-[100px] md:pt-10 md:pb-10 pt-10 pb-10 desktop:px-80 bg-[#F3F7FA]">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div class="text-left">
                <h2 class="can-exp-h1 text-left font-semibold text-[#006EB7]">{!! $homePageSettingDetail->section6_heading !!}</h2>
                <div class="text-left text-gray-500">{!! $homePageSettingDetail->section6_description !!}</div>
            </div>
            
            <div class="flex justify-end flex-shrink-0">
                @php
                    $url = isset($general_setting['see_all_magazine_page']) ? route('front.index', $general_setting['see_all_magazine_page']) : '#';
                    $url = langBasedURL($lang, $url);
                @endphp
                <a aria-label="{{ __('Canadian Exporters') }}" href="{{ $url }}" class="button-exp-no-fill rounded-none" >{!! $homePageSettingDetail->section6_see_all_button !!}</a>
            </div>
        </div>
        <div class="mt-2 relative">
            <div class="swiper magazine-slider-container z-0" style="padding: 0px !important;">
                <div class="swiper-wrapper">
                    @for ($i = 0; $i < count($issues); $i++)
                    <div class="swiper-slide border border-[#c9dbe9] shadow-md shadow-blue-500/20">
                        <div class="flex items-center gap-4 justify-center">
                            <a aria-label="{{ __('Canadian Exporters') }}" target="_blank" class="w-full h-[412px] bg-white flex justify-center items-center" href="{{ isset($issues[$i]->pdf) ? $issues[$i]->pdf : '#' }}">
                                <img src="{{ isset($issues[$i]->media) && file_exists(($issues[$i]->media->medium_image)) ? asset($issues[$i]->media->medium_image) : asset('assets/images/logocircle.png') }}" class="object-cover" alt="{{ __('Canadian Exports magazine') }}" />
                            </a>
                        </div>
                        <div class="p-6">
                           <p>{{ $issues[$i]?->issueDetail[0]->title ?? '' }}</p>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            <div class="magazine-button-next-exp absolute top-1/2 z-50" style="right: -72px; transform: translateY(-50%);">
                <div
                    class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>
                </div>
            </div>
            <div class="magazine-button-prev-exp absolute top-1/2 z-50" style="left: -72px; transform: translateY(-50%);">
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
</section>