    <div class="h-full bg-gray-100">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section ction class="">
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
                        <div class="grid lg:grid-cols-4 md:grid-cols-4 grid-cols-2 mt-8 gap-6 gap-y-8 items-center">
                            @php
                                $magazines = getAllMagazines(30, $lang);
                            @endphp
                            @foreach ($magazines as $magazine)
                                <div class="flex flex-col h-full">
                                    <h3 class="flex-1 text-primary card-heading mb-3">
                                        {{ isset($magazine->issueDetail[0]) ? $magazine->issueDetail[0]->title : '' }}
                                    </h3>

                                    <a aria-label="Candian Exporters" class="flex-end flex justify-center items-center p-1 rounded shadow bg-white h-60" target="_blank"
                                        href="{{ isset($magazine->pdf) ? $magazine->pdf : '#' }}">
                                        @if(isset($magazine->media) && file_exists(($magazine->media->medium_image)))
                                        <img src="{{ asset($magazine->media->medium_image) }}"
                                            class="object-cover h-full" alt="Canadian Exports magazine" />
                                            @else
                                            <img src="{{ asset('assets/images/logocircle.png')}}"
                                                class="object-contain h-full" alt="Canadian Exports magazine" />
                                        @endif
                                    </a>
                                </div>
                            @endforeach

                        </div>
                        <div class="mt-10">
                            {{ $magazines->links() }}
                        </div>

                    </div>


                </section>
            </div>
        </div>
    </div>
