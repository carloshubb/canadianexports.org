@isset($page)
    <div class="h-full bg-gray-50 ">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 ">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section class="">

                    @isset($page->pageDetail[0])
                        <div class="">
                            @php
                                $page_detail = $page->pageDetail[0]->page_detail;
                            @endphp
                            @include('front.pages.widgets.render-widget-with-detail', [
                                'page_detail' => $page_detail,
                            ])
                        </div>
                    @endisset
                    <div class="container">
                        @php
                            $sponsors = getAllSponsors(30);
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mt-8">
                            @foreach ($sponsors as $sponsor)
                                <div class="bg-white w-full rounded border flex flex-col h-full">
                                    <div class="p-4 flex-1">
                                        <a aria-label="Candian Exporters" href="{{ $sponsor->url }}" target="_blank"
                                            class="rounded flex justify-center items-center aspect-video bg-gray-50 fix-url"
                                            onclick="fixUrls()">
                                            @php
                                                // Support both old Banner model and new Sponsor model
                                                $imageSource = null;
                                                if (isset($sponsor->logoMedia) && $sponsor->logoMedia) {
                                                    $imageSource = $sponsor->logoMedia->medium_image ?? $sponsor->logoMedia->path;
                                                } elseif (isset($sponsor->media) && $sponsor->media) {
                                                    $imageSource = $sponsor->media->medium_image ?? $sponsor->media->path;
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
                                            {!! $sponsor->summary ?? $sponsor->small_business_description ?? '' !!}
                                        </p>
                                    </div>

                                    <div class="bg-primary bg-opacity-10 w-full px-4 py-2 rounded-b flex-end text-center">
                                        <a aria-label="Candian Exporters"
                                            href="{{ route('user.sponsor-detail.show', ['abbreviation' => $lang->abbreviation, 'slug' => $sponsor->slug ?? $sponsor->id]) }}"
                                            class=" fix-url" onclick="fixUrls()">More about {!! $sponsor->business_name !!}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-10">
                            {{ $sponsors->links() }}
                        </div>

                    </div>

                </section>
            </div>
        </div>
    </div>

@endisset
