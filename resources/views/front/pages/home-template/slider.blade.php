<div class="relative isolate lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 min-h-[550px] flex items-center overflow-hidden mt-[120px]">
    <!-- Background Image Container - Fixed positioning -->
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset($homePageSettingDetail->slider_image) }}" alt="slider image"
            class="absolute inset-0 w-full h-full object-cover">
        <!-- Dark overlay on top of image -->
        <div class="absolute inset-0 bg-slider-over"></div>
    </div>

    <!-- Decorative SVG gradients -->
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

    <!-- Content Container - Now centered vertically and horizontally -->
    <div class="container relative z-10 w-full px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <div class="mx-auto lg:mx-0">
            <h1 class="can-exp-h1 mb-4 text-center text-white text-4xl sm:text-5xl lg:text-6xl">
                {!! $homePageSettingDetail->slider_heading !!}
            </h1>
        </div>

        <div class="mx-auto mt-4 sm:w-[90%] md:w-[75%] lg:w-[65%]">
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
                                class="rounded-md flex flex-col sm:flex-col md:flex-row lg:flex-row justify-between items-stretch h-[50px] gap-0">
                                <div class="w-full md:w-2/3 flex items-stretch text-lg sm:text-xl min-h-0">
                                    <input type="search" name="search" id="search-input"
                                        class="flex-1 min-w-0 h-full min-h-[50px] sm:min-h-[50px] md:min-h-0 md:h-full py-0 px-3 focus:outline-none focus:ring-none {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'rounded-l-[0.25rem] md:rounded-l-[0.25rem]' : 'rounded-r-[0.25rem] md:rounded-r-[0.25rem]' }}"
                                        placeholder="Search over 50,000+ Canadian suppliers..." />
                                    <button type="submit" class="h-full min-h-[50px] md:min-h-0 flex-shrink-0 flex items-center justify-center !py-0 button-exp-fill md:hidden {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'rounded-r-[0.25rem] lg:rounded-r-[0.25rem] rounded-l-none rounded-none' : 'rounded-l-[0.25rem] lg:rounded-l-[0.25rem] rounded-r-none rounded-none' }}">
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
                                <div class="w-full md:w-[60%] lg:w-[45%] xl:w-[40%] hidden md:flex items-stretch min-h-0">
                                    <select id="category" name="category"
                                        class="w-full h-full min-h-0 py-0 px-3 pr-8 focus:outline-none focus:ring-none rounded-b-md md:rounded-none">
                                        <option value="canadian-exporters">
                                            {{ isset($advSearchSetting['canadian_exporters_text']) ? $advSearchSetting['canadian_exporters_text'] : '' }}
                                        </option>
                                        <option value="inquaries-to-buy">
                                            {{ isset($advSearchSetting['i2b_text']) ? $advSearchSetting['i2b_text'] : '' }}
                                        </option>
                                        <option value="trade-shows-and-events">
                                            {{ isset($advSearchSetting['events_text']) ? str_replace(' and ', ' & ', $advSearchSetting['events_text']) : '' }}
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="hidden md:flex h-full min-h-0 items-center justify-center !py-0 button-exp-fill {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'rounded-l-none' : 'rounded-r-none' }}">
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

            <div class="flex justify-center mt-8">
                @php
                $url = route('user.search.advanceSearch');
                $url = langBasedURL(null, $url);
                @endphp
                <div class="bg-white rounded-md p-2 bg-opacity-40">
                    <a aria-label="Candian Exporters" href="{{ $url }}" class="button-exp-fill inline-flex items-center h-[50px] text-lg sm:text-xl">
                        {!! $homePageSettingDetail->slider_advance_search_text !!}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const searchInput = document.getElementById('search-input');
        
        // Placeholder texts for each category
        const placeholders = {
            'canadian-exporters': 'Search over 30,000+ Canadian suppliers...',
            'inquaries-to-buy': 'Search for specific buying requests...',
            'trade-shows-and-events': 'Try: \'Mining Expo\', \'Toronto\', or \'May 2026\'...'
        };
        
        // Set initial placeholder based on default selected value
        if (categorySelect && searchInput) {
            const initialValue = categorySelect.value || 'canadian-exporters';
            searchInput.placeholder = placeholders[initialValue] || placeholders['canadian-exporters'];
            
            // Update placeholder when category changes
            categorySelect.addEventListener('change', function() {
                const selectedValue = this.value;
                searchInput.placeholder = placeholders[selectedValue] || placeholders['canadian-exporters'];
            });
        }
    });
</script>