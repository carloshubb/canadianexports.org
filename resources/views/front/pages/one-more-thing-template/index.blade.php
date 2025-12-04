@isset($oneMoreThingSettingDetail)
    @php
        $oneMoreThings = getAllOneMoreThings(10, $lang);
    @endphp
    <div class="h-full bg-gray-50">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section class="">
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-4 container">
                        <h1 class="text-center">{{ $oneMoreThingSettingDetail->page_heading }}</h1>
                        @foreach ($oneMoreThings as $oneMoreThing)
                            <div class="mb-4">
                                <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2" id="canaidan-exporters-21">
                                    <div class="">
                                        <div class="flex justify-between items-start">
                                            <div
                                                class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-start space-2 w-full">
                                                @php
                                                    $imgClasses = '';
                                                @endphp
                                                @if (isset($oneMoreThing->media, $oneMoreThing->media) && file_exists($oneMoreThing->media->medium_image))
                                                    @php
                                                        $imgClasses = '';
                                                    @endphp
                                                @endif
                                                <div class="w-24 h-24 mt-2 rounded-lg mx-auto md:mx-0 flex-shrink-0 {{ $imgClasses }}">
                                                    @if (isset($oneMoreThing->media, $oneMoreThing->media) && file_exists($oneMoreThing->media->medium_image))
                                                        <img src="{{ asset($oneMoreThing->media->medium_image) }}"
                                                            class="h-full w-full object-cover rounded-full"
                                                            alt="Candian Exporters" />
                                                    @else
                                                        <img src="{{ asset('/assets/images/logocircle.png') }}"
                                                            class="h-full w-full object-contain rounded-full"
                                                            alt="Candian Exporters" />
                                                    @endif
                                                </div>
                                                <div class="md:px-4 md:py-3 flex-1">
                                                    <p
                                                        class="text-gray-600 mb-4 text-base md:text-base lg:text-lg mt-2 md:mt-0">
                                                        {{ isset($oneMoreThing->oneMoreThingDetail[0]) ? $oneMoreThing->oneMoreThingDetail[0]->description : '' }}
                                                    </p>
                                                    <div class="text-center md:text-left">
                                                        <a aria-label="Candian Exporters" href="{{ $oneMoreThing->url }}"
                                                            class="button-exp-fill mx-auto md:mx-0" target="_blank">
                                                            {{ $oneMoreThingSettingDetail->read_more_btn_text }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="my-4">
                            {{ $oneMoreThings->links() }}
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>
@endisset
