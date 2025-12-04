@php
    $banners = getRandomBanners('sponsor', 8, 'active');
    // Fallback to legacy banners table if new sponsors set is empty
    if (!$banners || count($banners) === 0) {
        $banners = getBanners('sponsor', 8);
    }
@endphp
<section class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 desktop:px-80">
    <div class="container">
        <h2 class="can-exp-h1 mb-4 text-center">
            {!! $homePageSettingDetail->section3_heading !!}
        </h2>

        <div class="">
            <div class="swiper sponsor-slider-container relative z-0">
                <div class="swiper-wrapper">
                    @foreach ($banners as $banner)
                        <div class="swiper-slide h-full">
                            <div class="relative bg-white w-full rounded border flex flex-col sponsor-swiper-slide">
                                <div class="absolute top-10 -left-2 h-fit w-fit py-1 px-8 text-white bg-primary">
                                    Sponsor
                                </div>
                                <div class="p-4 flex-1">
                                    <a aria-label="Candian Exporters" href="{{ $banner->url }}" target="_blank"
                                        class="rounded flex justify-center items-center aspect-video bg-gray-50 fix-url"
                                        onclick="fixUrls()">
                                        @php
                                            // Support both old Banner model and new Sponsor model
                                            $imageSource = null;
                                            if (isset($banner->logoMedia) && $banner->logoMedia) {
                                                $imageSource = $banner->logoMedia->medium_image ?? $banner->logoMedia->path;
                                            } elseif (isset($banner->media) && $banner->media) {
                                                $imageSource = $banner->media->medium_image ?? $banner->media->path;
                                            }
                                        @endphp
                                        @if ($imageSource && file_exists($imageSource))
                                            <img src="{{ asset($imageSource) }}"
                                                class="object-cover aspect-video w-full rounded" alt="sponsor banner" />
                                        @else
                                            <img src="{{ asset('assets/images/logocircle.png') }}"
                                                class="object-contain aspect-video w-full rounded"
                                                alt="sponsor banner" />
                                        @endif
                                    </a>

                                    <p class="my-4">
                                        {!! $banner->summary ?? $banner->small_business_description ?? '' !!}
                                    </p>
                                </div>

                                <div
                                    class="bg-primary bg-opacity-10 w-full px-4 py-2 rounded-b flex-end text-center flex-end">
                                    <a aria-label="Candian Exporters"
                                        href="{{ route('user.sponsor-detail.show', ['abbreviation' => $lang->abbreviation, 'slug' => $banner->slug ?? $banner->id]) }}"
                                        class="fix-url" onclick="fixUrls()">More about {!! $banner->business_name !!}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
                <div class="sponsor-button-next-exp absolute top-1/2 right-0 z-50">

                    <div
                        class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </div>
                </div>
                <div class="sponsor-button-prev-exp  absolute top-1/2 left-0 z-50">
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
        </div>
        <div class="mt-10 flex justify-center gap-4">
            @php
                $url = $homePageSettingDetail->section3_button_url;
                $url = langBasedURL($lang, $url);
            @endphp
            <a aria-label="Candian Exporters" href="{!! $url !!}" class="button-exp-fill">
                {!! $homePageSettingDetail->section3_button_text !!}
            </a>
            @php
                $url = $homePageSettingDetail->sponsor_value_button_url;
                $url = langBasedURL($lang, $url);
            @endphp
            <a aria-label="Candian Exporters" href="{{ $url }}" class="button-exp-no-fill">
                {!! $homePageSettingDetail->sponsor_value_button_text !!}
            </a>
        </div>


    </div>
</section>
