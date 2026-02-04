@php
$banners = getRandomBanners('sponsor', 8, 'active');
// Fallback to legacy banners table if new sponsors set is empty
if (!$banners || count($banners) === 0) {
$banners = getBanners('sponsor', 8);
}

@endphp
<section class="home-container bg-[#F3F7FA] lg:py-[100px] md:pt-10 md:pb-10 pt-10 pb-10 desktop:px-80">
        <h2 class="can-exp-h1 p-0 mb-4 text-left font-semibold text-[#006EB7]">
            {!! $homePageSettingDetail->section3_heading !!}
        </h2>
        <span class="text-gray-600">Explore these extensive Business Categories, each featuring reputable and export-ready and bring their high-quality products and services to your market.</span>
        <div class="mt-12 relative">
            <div class="swiper sponsor-slider-container z-0" style="padding: 0px !important;">
                <div class="swiper-wrapper">
                    @foreach ($banners as $banner)
                    <div class="swiper-slide h-full">
                        <div class="relative bg-white w-full border border-[#c9dbe9] shadow-md shadow-blue-500/20 flex flex-row h-[256px] overflow-hidden sponsor-swiper-slide">
                            {{-- Left half: image fills entirely, no padding or dead areas --}}
                            <a aria-label="Canadian Exporters" href="{{ $banner->url }}" target="_blank"
                                class="flex-[0_0_50%] flex shrink-0 self-stretch overflow-hidden fix-url"
                                onclick="fixUrls()">
                                @php
                                $imageSource = null;
                                if (isset($banner->logoMedia) && $banner->logoMedia) {
                                $imageSource = $banner->logoMedia->medium_image ?? $banner->logoMedia->path;
                                } elseif (isset($banner->media) && $banner->media) {
                                $imageSource = $banner->media->medium_image ?? $banner->media->path;
                                }
                                @endphp
                                @if ($imageSource && file_exists($imageSource))
                                <img src="{{ asset($imageSource) }}"
                                    class="object-cover w-full h-full min-w-full min-h-full" alt="sponsor banner" />
                                @else
                                <img src="{{ asset('assets/images/logocircle.png') }}"
                                    class="object-cover w-full h-full min-w-full min-h-full bg-gray-50"
                                    alt="sponsor banner" />
                                @endif
                            </a>

                            {{-- Right half: content --}}
                            <div class="flex-1 flex flex-col min-w-0 px-4 py-4 justify-between">
                                <div class="flex flex-col">
                                    <span class="bg-primary text-white text-xs inline-block w-fit px-5 py-1 rounded-md mb-4">
                                        {{ $banner->business_name ?? $banner->business_summary ?? '' }}
                                    </span>
                                    <h2 class="py-1 text-left text-2xl font-semibold text-[#000000] leading-tight">
                                        {{ Str::limit($banner->summary ?? '', 64, '...') }}
                                    </h2>
                                    <p class="py-1 text-gray-600 text-left text-sm leading-relaxed">
                                        {{ Str::limit($banner->detail_description ?? '', 136, '...') }}
                                    </p>
                                </div>
                                <div class="mt-4 text-left">
                                    <a aria-label="Canadian Exporters"
                                        href="{{ route('user.sponsor-detail.show', ['abbreviation' => $lang->abbreviation, 'slug' => $banner->slug ?? $banner->id]) }}"
                                        class="fix-url text-primary text-sm hover:underline font-medium" onclick="fixUrls()">More about {!! $banner->business_name !!}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="sponsor-button-next-exp absolute top-1/2 z-50" style="left: -72px;transform: translateY(-50%);">
                <div
                    class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>
                </div>
            </div>
            <div class="sponsor-button-prev-exp  absolute top-1/2  z-50" style="right: -72px;transform: translateY(-50%);">
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
        <h3 class="mt-10 text-center font-semibold text-[#000000]">
            The Supporters Who Make It Possible. Powered by Our Incredible Sponsors.
        </h3>
        <div class="mt-8 flex justify-center gap-4">
            @php
            $url = $homePageSettingDetail->section3_button_url;
            $url = langBasedURL($lang, $url);
            @endphp
            <a aria-label="Candian Exporters" href="{!! $url !!}" class="button-exp-fill flex justify-center items-center w-64 h-[56px] rounded-none">
                {!! $homePageSettingDetail->section3_button_text !!}
            </a>
            @php
            $url = $homePageSettingDetail->sponsor_value_button_url;
            $url = langBasedURL($lang, $url);
            @endphp
            <a aria-label="Candian Exporters" href="{{ $url }}" class="button-exp-no-fill bg-black text-white border-0 flex justify-center items-center w-64 h-[56px] rounded-none">
                {!! $homePageSettingDetail->sponsor_value_button_text !!}
            </a>
        </div>
</section>