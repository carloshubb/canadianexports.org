@isset($exportingFairSettingDetail)
    @php
        $exportingFairs = getAllUpcomingExportingFairs(10, $lang);
        $exportFairSetting = getI2bModalSetting($lang, ['exporting_fair_detail_setting']);
    @endphp
    <div class="h-full bg-gray-50">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section class="">
                    <!--Tabs-->
                    <div class="grid grid-cols-1 container">
                        <h1 class="text-center">{{ $exportingFairSettingDetail->page_heading }}</h1>
                        @foreach ($exportingFairs as $exportingFair)
                            <section class="mt-8">
                                <div class="grid grid-cols-12 bg-white rounded shadow p-6 mb-4 transition-all">
                                    <div class="col-span-12 md:col-span-4 w-full">
                                        <a aria-label="Candian Exporters" href="#"
                                            class="h-60 rounded shadow">
                                            <img class="h-60 rounded object-cover w-full"
                                                src="{{ isset($exportingFair->media, $exportingFair->media->medium_image) && file_exists($exportingFair->media->medium_image) ? asset($exportingFair->media->medium_image) : asset('assets/images/logocanexp.png') }}"
                                                alt="Candian Exporters" />
                                        </a>
                                        @php
                                            $url = route('user.exporting-fair.show', ['abbreviation' => $lang->abbreviation, 'id' => $exportingFair->id]);
                                        @endphp
                                        <a aria-label="Candian Exporters" href="{{ $url }}" class="w-full button-exp-fill mt-2 hidden md:block">
                                            {{ isset($exportFairSetting['ef_event_detail_button_text']) ? $exportFairSetting['ef_event_detail_button_text'] : '' }}
                                        </a>
                                    </div>
                                    <div class="col-span-12 md:col-span-8 w-full md:px-4 pt-4 md:pt-0">
                                        <div>
                                            <h2 class="text-primary card-heading">
                                                {{ isset($exportingFair->exportingFairDetail[0]) ? $exportingFair->exportingFairDetail[0]->title : '' }}
                                            </h2>
                                        </div>
                                        <table class="border-spacing-y-3 border-separate px-0 text-lg border-none">
                                            <tbody class=" border-none">
                                                <tr class=" border-none">
                                                    <td
                                                        class="text-primary whitespace-nowrap text-base md:text-base lg:text-lg border-none align-top">
                                                        {{ isset($exportFairSetting['ef_event_date_text']) ? $exportFairSetting['ef_event_date_text'] : '' }}
                                                    </td>
                                                    <td class="text-base md:text-base lg:text-lg border-none pl-3">
                                                        {{ date('F d, Y', strtotime($exportingFair->start_date)) }} -
                                                        {{ date('F d, Y', strtotime($exportingFair->end_date)) }}
                                                    </td>
                                                </tr>
                                                <tr class=" border-none">
                                                    <td
                                                        class="text-primary whitespace-nowrap text-base md:text-base lg:text-lg border-none align-top">
                                                        {{ isset($exportFairSetting['ef_booth_number_text']) ? $exportFairSetting['ef_booth_number_text'] : '' }}
                                                    </td>
                                                    <td class="text-base md:text-base lg:text-lg border-none pl-3">
                                                        {{ $exportingFair->booth_number }}
                                                    </td>
                                                </tr>
                                                <tr class=" border-none">
                                                    <td
                                                        class="text-primary whitespace-nowrap text-base md:text-base lg:text-lg border-none align-top">
                                                        {{ isset($exportFairSetting['ef_venue_text']) ? $exportFairSetting['ef_venue_text'] : '' }}
                                                    </td>
                                                    <td class="text-base md:text-base lg:text-lg border-none pl-3">
                                                        {{ isset($exportingFair->exportingFairDetail[0]) ? $exportingFair->exportingFairDetail[0]->address : '' }}
                                                    </td>
                                                </tr>
                                                <tr class="border-none">
                                                    <td
                                                        class="text-primary whitespace-nowrap text-base md:text-base lg:text-lg border-none align-top">
                                                        {{ isset($exportFairSetting['ef_location_text']) ? $exportFairSetting['ef_location_text'] : '' }}
                                                    </td>
                                                    <td class="text-base md:text-base lg:text-lg border-none pl-3">
                                                        {{ isset($exportingFair->exportingFairDetail[0]) ? $exportingFair->exportingFairDetail[0]->city : '' }},
                                                        {{ isset($exportingFair->exportingFairDetail[0]) ? $exportingFair->exportingFairDetail[0]->country : '' }}
                                                    </td>
                                                </tr>
                                                <tr class=" border-none">
                                                    <td
                                                        class="text-primary whitespace-nowrap text-base md:text-base lg:text-lg border-none align-top">
                                                        {{ isset($exportFairSetting['ef_short_description_text']) ? $exportFairSetting['ef_short_description_text'] : '' }}
                                                    </td>
                                                    <td class="text-base md:text-base lg:text-lg border-none pl-3">
                                                        {{ isset($exportingFair->exportingFairDetail[0]) ? $exportingFair->exportingFairDetail[0]->short_description : '' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="w-full mt-2 block md:hidden">
                                            <a aria-label="Candian Exporters" href="{{ $url }}" class="w-full button-exp-fill">
                                                {{ isset($exportFairSetting['ef_event_detail_button_text']) ? $exportFairSetting['ef_event_detail_button_text'] : '' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endforeach

                        <div class="my-4">
                            {{ $exportingFairs->links() }}
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>
@endisset
