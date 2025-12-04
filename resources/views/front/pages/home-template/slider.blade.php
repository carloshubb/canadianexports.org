<div class="relative isolate overflow-hidden bg-gray-900 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
    <div class="absolute w-full h-full bg-opacity-60 bg-black top-0 right-0"></div>
    <img src="{{ asset($homePageSettingDetail->slider_image) }}" alt="slider image"
        class="absolute inset-0 -z-10 h-full w-full object-cover object-right md:object-center">

    <svg viewBox="0 0 1097 845" aria-hidden="true"
        class="hidden transform-gpu blur-3xl sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:w-[68.5625rem]">
        <path fill="url(#10724532-9d81-43d2-bb94-866e98dd6e42)" fill-opacity=".2"
            d="M301.174 646.641 193.541 844.786 0 546.172l301.174 100.469 193.845-356.855c1.241 164.891 42.802 431.935 199.124 180.978 195.402-313.696 143.295-588.18 284.729-419.266 113.148 135.13 124.068 367.989 115.378 467.527L811.753 372.553l20.102 451.119-530.681-177.031Z" />
        <defs>
            <linearGradient id="10724532-9d81-43d2-bb94-866e98dd6e42" x1="1097.04" x2="-141.165" y1=".22"
                y2="363.075" gradientUnits="userSpaceOnUse">
                <stop stop-color="#776FFF" />
                <stop offset="1" stop-color="#FF4694" />
            </linearGradient>
        </defs>
    </svg>
    <svg viewBox="0 0 1097 845" aria-hidden="true"
        class="absolute left-1/2 -top-52 -z-10 w-[68.5625rem] -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0">
        <path fill="url(#8ddc7edb-8983-4cd7-bccb-79ad21097d70)" fill-opacity=".2"
            d="M301.174 646.641 193.541 844.786 0 546.172l301.174 100.469 193.845-356.855c1.241 164.891 42.802 431.935 199.124 180.978 195.402-313.696 143.295-588.18 284.729-419.266 113.148 135.13 124.068 367.989 115.378 467.527L811.753 372.553l20.102 451.119-530.681-177.031Z" />
        <defs>
            <linearGradient id="8ddc7edb-8983-4cd7-bccb-79ad21097d70" x1="1097.04" x2="-141.165" y1=".22"
                y2="363.075" gradientUnits="userSpaceOnUse">
                <stop stop-color="#776FFF" />
                <stop offset="1" stop-color="#FF4694" />
            </linearGradient>
        </defs>
    </svg>
    <div class="container ">
        <div class="mx-auto lg:mx-0 pt-20">
            <h1 class="can-exp-h1 mb-4 text-center text-white">
                {!! $homePageSettingDetail->slider_heading !!}
            </h1>
            {{-- <h3 class="can-exp-h2">
                {!! $homePageSettingDetail->slider_description !!}
            </h3> --}}
        </div>
        {{-- rounded-md flex flex-col sm:flex-col md:flex-row lg:flex-row justify-between items-start divide-y --}}
        <div class="mx-auto mt-4 sm:w-[65%]">
            <div class="rounded-md flex flex-col sm:flex-col md:flex-row lg:flex-row items-start">
                <div class="subcribe-form w-full">
                    @php
                        $url = route('user.search.advanceSearch');
                        $url = langBasedURL($lang, $url);
                    @endphp
                    <form class="relative w-full" method="get" action="{{ $url }}">
                        <input type="hidden" name="sorting" value="a-z" />
                        <input type="hidden" name="canadian-exporters[]" value="all" />
                        <input type="hidden" name="inquaries-to-buy[]" value="all" />
                        <input type="hidden" name="trade-shows-and-events[]" value="all" />
                        <div class="bg-white rounded-md p-2 bg-opacity-40">
                            <div
                                class="rounded-md flex flex-col sm:flex-col md:flex-row lg:flex-row justify-between items-start">
                                <div class="w-full md:w-2/3 flex items-center">
                                    <input type="search" name="search"
                                        class="w-full py-2 px-3 lg:text-lg focus:outline-none focus:ring-none {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'rounded-l-md md:rounded-l-md' : 'rounded-r-md md:rounded-r-md' }}"
                                        placeholder="{!! $homePageSettingDetail->slider_search_placeholder !!}" />
                                    <button class="h-full button-exp-fill md:hidden {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'rounded-r-md lg:rounded-r-md rounded-l-none rounded-none' : 'rounded-l-md lg:rounded-l-md rounded-r-none rounded-none' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                @php
                                    $advSearchSetting = getI2bModalSetting($lang, ['advance_search']);
                                @endphp
                                <div class="w-full md:w-[60%] lg:w-[45%] xl:w-[40%] hidden md:block">
                                    <select id="category" name="category"
                                        class="w-full md:w-[255px] xl:w-full py-2 px-3 pr-8 lg:text-lg focus:outline-none focus:ring-none rounded-b-md md:rounded-none">
                                        <option value="canadian-exporters">
                                            {{ isset($advSearchSetting['canadian_exporters_text']) ? $advSearchSetting['canadian_exporters_text'] : '' }}
                                        </option>
                                        <option value="inquaries-to-buy">
                                            {{ isset($advSearchSetting['i2b_text']) ? $advSearchSetting['i2b_text'] : '' }}
                                        </option>
                                        <option value="trade-shows-and-events">
                                            {{ isset($advSearchSetting['events_text']) ? $advSearchSetting['events_text'] : '' }}
                                        </option>
                                    </select>
                                </div>
                                <button class="hidden md:block sm:py-[8px] md:py-[8px] lg:py-2.5 h-full  button-exp-fill {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'rounded-l-none' : 'rounded-r-none' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

                <div class="flex justify-center mt-4">
                    @php
                        $url = route('user.search.advanceSearch', ['canadian-exporters' => ['all']]);
                        $url = langBasedURL(null, $url);
                    @endphp
                    <div class="bg-white rounded-md p-2 py-3.5 bg-opacity-40">
                        <a aria-label="Candian Exporters" href="{{ $url }}" class="button-exp-fill">
                            {!! $homePageSettingDetail->slider_advance_search_text !!}
                        </a>
                    </div>
                </div>
        </div>
    </div>
</div>
