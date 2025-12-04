@extends('front.layouts.app')
@section('title', 'Canadian Exports | Register your account')
@section('meta_description',
    'Canadian Exports is a Canadian export portal and a directory of Canadian exporters,
    showcasing lists of Canadian products and services, and promoting Canadian manufacturers and exporters. Canadian Exports
    is a Canadian business directory and a Canadian business database highlighting the Canadian industry')
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
    catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
    companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
@section('content')
    @php
        Session::put('validation_redirect', 0);
        $lang = getDefaultLanguage(true);
        $advSearchSetting = getI2bModalSetting($lang, ['advance_search']);
    @endphp
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="container">
                <section class="">
                    <div class="flex justify-center mb-4">
                        <h2 class="can-exp-h1 text-center">
                            {{ isset($advSearchSetting['advance_search_heading']) ? $advSearchSetting['advance_search_heading'] : '' }}
                        </h2>
                    </div>
                    @if (count($searchCustomerProfiles) == 0 && isset($_GET['search']) && $_GET['search'] != '' && isset($_GET['category']) && $_GET['category'] == 'canadian-exporters')
    <h1 class="can-exp-h2 text-center text-primary">
        @php
            $setting = getStaticTranslationByKey($lang, 'general', ['no_result_found_text']);
        @endphp
        {{ isset($setting['no_result_found_text']) ? $setting['no_result_found_text'] : '' }}
    </h1>
@elseif (count($searchEvents) == 0 && isset($_GET['search']) && $_GET['search'] != '' && isset($_GET['category']) && $_GET['category'] == 'trade-shows-and-events')
    <h1 class="can-exp-h2 text-center text-primary">
        @php
            $setting = getStaticTranslationByKey($lang, 'general', ['no_result_found_text']);
        @endphp
        {{ isset($setting['no_result_found_text']) ? $setting['no_result_found_text'] : '' }}
    </h1>
@elseif (count($searchI2bs) == 0 && isset($_GET['search']) && $_GET['search'] != '' && isset($_GET['category']) && $_GET['category'] == 'inquaries-to-buy')
    <h1 class="can-exp-h2 text-center text-primary">
        @php
            $setting = getStaticTranslationByKey($lang, 'general', ['no_result_found_text']);
        @endphp
        {{ isset($setting['no_result_found_text']) ? $setting['no_result_found_text'] : '' }}
    </h1>
@else
                    @php
                        $url = route('user.search.advanceSearch');
                        $url = langBasedURL(null, $url);
                    @endphp
                    <form method="get" action="{{ $url }}">
                        <div class="grid lg:grid-cols-5 md:grid-cols-5 sm:grid-cols-1 gap-4 items-end">
                            <div class="relative w-full mb-3">
                                <label class="mb-2 text-primary text-base md:text-base lg:text-lg"
                                    for="">{{ isset($advSearchSetting['search_input_label']) ? $advSearchSetting['search_input_label'] : '' }}</label>
                                <input type="text" class="can-exp-input"
                                    placeholder="{{ isset($advSearchSetting['search_input_placeholder']) ? $advSearchSetting['search_input_placeholder'] : '' }}"
                                    id="search" name="search"
                                    value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                                @error('search')
                                    @include('front.pages.error', [
                                        'errorMessage' => "$message",
                                        'postion' => 'absolute',
                                    ])
                                @enderror
                            </div>
                            {{-- <div class="relative w-full mb-3">
                                <label class="mb-2 text-primary text-base md:text-base lg:text-lg"
                                    for="">{{ isset($advSearchSetting['search_criteria_label']) ? $advSearchSetting['search_criteria_label'] : '' }}</label>
                                <select class="block appearance-none can-exp-input pr-8" name="criteria" id="criteria">
                                    @php
                                        $criteriaSelected = isset($_GET['criteria']) ? $_GET['criteria'] : 'all-words';
                                    @endphp
                                    <option value="all-words" {{ $criteriaSelected == 'all-words' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['all_words_text']) ? $advSearchSetting['all_words_text'] : '' }}
                                    </option>
                                    <option value="any-words" {{ $criteriaSelected == 'any-words' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['any_words_text']) ? $advSearchSetting['any_words_text'] : '' }}
                                    </option>
                                    <option value="exact-phrase"
                                        {{ $criteriaSelected == 'exact-phrase' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['exact_pharse_text']) ? $advSearchSetting['exact_pharse_text'] : '' }}
                                    </option>
                                </select>
                            </div> --}}
                            <div class="relative w-full mb-3">
                                <label class="mb-2 text-primary text-base md:text-base lg:text-lg"
                                    for="">{{ isset($advSearchSetting['search_cat_select_category_label']) ? $advSearchSetting['search_cat_select_category_label'] : '' }}</label>
                                <select class="block appearance-none  can-exp-input pr-8" name="category" id="category">
                                    @php
                                        $categorySelected = isset($_GET['category'])
                                            ? $_GET['category']
                                            : 'canadian-exporters';
                                    @endphp
                                    <option value="canadian-exporters"
                                        {{ $categorySelected == 'canadian-exporters' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['canadian_exporters_text']) ? $advSearchSetting['canadian_exporters_text'] : '' }}
                                    </option>
                                    <option value="inquaries-to-buy"
                                        {{ $categorySelected == 'inquaries-to-buy' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['i2b_text']) ? $advSearchSetting['i2b_text'] : '' }}
                                    </option>
                                    <option value="trade-shows-and-events"
                                        {{ $categorySelected == 'trade-shows-and-events' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['events_text']) ? $advSearchSetting['events_text'] : '' }}
                                    </option>
                                </select>
                            </div>
                            <div class="relative w-full mb-3 md:col-span-2">
                                <label class="mb-2 text-primary text-base md:text-base lg:text-lg"
                                    for="">{{ isset($advSearchSetting['select_industry_label']) ? $advSearchSetting['select_industry_label'] : '' }}</label>
                                @php
                                    $businessCategories = getAllBusinessCategories();
                                    $i2bs = getAllInquiries(0);
                                    $events = getAllEvents(0);
                                @endphp
                                <div id="canadian-exporters"
                                    class="{{ $categorySelected == 'canadian-exporters' ? 'block' : 'hidden' }}">
                                    <select
                                        class="js-example-basic-multiple appearance-none w-full can-exp-input pr-8 category-options"
                                        id="canadian-exporters-select" name="canadian-exporters[]" multiple="multiple">
                                        {{-- <option value="">
                                        {{ isset($advSearchSetting['select_industry_text']) ? $advSearchSetting['select_industry_text'] : '' }}
                                    </option> --}}
                                        @php
                                            $selectedCandianExportes = null;
                                        @endphp
                                        @if (isset($_GET['canadian-exporters']) && in_array('all', $_GET['canadian-exporters']))
                                            @php
                                                $selectedCandianExportes = 'selected';
                                            @endphp
                                        @endif
                                        <option value="all" {{ $selectedCandianExportes }}>
                                            {{ isset($advSearchSetting['all_option_text']) ? $advSearchSetting['all_option_text'] : '' }}
                                        </option>
                                        @foreach ($businessCategories as $businessCategory)
                                            @php
                                                $selectedCandianExportes = '';
                                            @endphp
                                            @if (isset($_GET['canadian-exporters']) && in_array($businessCategory->id, $_GET['canadian-exporters']))
                                                @php
                                                    $selectedCandianExportes = 'selected';
                                                @endphp
                                            @endif
                                            <option value="{{ $businessCategory->id }}" {{ $selectedCandianExportes }}>
                                                @php
                                                    $businessCategoryName = strtolower(
                                                        $businessCategory->category_name,
                                                    );
                                                    $businessCategoryName = ucwords($businessCategoryName);
                                                @endphp

                                                {{ $businessCategoryName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="inquaries-to-buy"
                                    class="{{ $categorySelected == 'inquaries-to-buy' ? 'block' : 'hidden' }}">
                                    <select
                                        class="js-example-basic-multiple appearance-none w-full p-0 can-exp-input pr-8 category-options"
                                        id="inquaries-to-buy-select" name="inquaries-to-buy[]" multiple="multiple">
                                        {{-- <option value="">Select i2b</option> --}}
                                        @php
                                            $selectedI2b = '';
                                        @endphp
                                        @if (isset($_GET['inquaries-to-buy']) && in_array('all', $_GET['inquaries-to-buy']))
                                            @php
                                                $selectedI2b = 'selected';
                                            @endphp
                                        @endif
                                        <option value="all" {{ $selectedI2b }}>
                                            {{ isset($advSearchSetting['all_option_text']) ? $advSearchSetting['all_option_text'] : '' }}
                                        </option>
                                        @foreach ($i2bs as $i2b)
                                            @php
                                                $selectedI2b = '';
                                            @endphp
                                            @if (isset($_GET['inquaries-to-buy']) && in_array($i2b->id, $_GET['inquaries-to-buy']))
                                                @php
                                                    $selectedI2b = 'selected';
                                                @endphp
                                            @endif
                                            <option value="{{ $i2b->id }}" {{ $selectedI2b }}>
                                                {{ isset($i2b->i2bDetail[0]) ? $i2b->i2bDetail[0]->name : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="trade-shows-and-events"
                                    class="{{ $categorySelected == 'trade-shows-and-events' ? 'block' : 'hidden' }}">
                                    <select
                                        class="js-example-basic-multiple appearance-none w-full can-exp-input pr-8 category-options"
                                        id="trade-shows-and-events-select" name="trade-shows-and-events[]"
                                        multiple="multiple">
                                        {{-- <option value="">Select event</option> --}}
                                        @php
                                            $selectedEvents = '';
                                        @endphp
                                        @if (isset($_GET['trade-shows-and-events']) && in_array('all', $_GET['trade-shows-and-events']))
                                            @php
                                                $selectedEvents = 'selected';
                                            @endphp
                                        @endif
                                        <option value="all" {{ $selectedEvents }}>
                                            {{ isset($advSearchSetting['all_option_text']) ? $advSearchSetting['all_option_text'] : '' }}
                                        </option>
                                        @foreach ($events as $event)
                                            @php
                                                $selectedEvents = '';
                                            @endphp
                                            @if (isset($_GET['trade-shows-and-events']) && in_array($event->id, $_GET['trade-shows-and-events']))
                                                @php
                                                    $selectedEvents = 'selected';
                                                @endphp
                                            @endif
                                            <option value="{{ $event->id }}" {{ $selectedEvents }}>
                                                {{ isset($event->eventDetail[0]) ? $event->eventDetail[0]->title : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('canadian-exporters')
                                    @include('front.pages.error', [
                                        'errorMessage' => "$message",
                                        'postion' => 'absolute',
                                    ])
                                @enderror
                                @error('inquaries-to-buy')
                                    @include('front.pages.error', [
                                        'errorMessage' => "$message",
                                        'postion' => 'absolute',
                                    ])
                                @enderror
                                @error('trade-shows-and-events')
                                    @include('front.pages.error', [
                                        'errorMessage' => "$message",
                                        'postion' => 'absolute',
                                    ])
                                @enderror
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="mb-2 text-primary text-base md:text-base lg:text-lg" for=""
                                    id="sorting-label">
                                    @if ($categorySelected == 'canadian-exporters')
                                        {{ isset($advSearchSetting['ce_sorting_order_label']) ? $advSearchSetting['ce_sorting_order_label'] : '' }}
                                    @elseif($categorySelected == 'inquaries-to-buy')
                                        {{ isset($advSearchSetting['i2b_sorting_order_label']) ? $advSearchSetting['i2b_sorting_order_label'] : '' }}
                                    @elseif($categorySelected == 'trade-shows-and-events')
                                        {{ isset($advSearchSetting['events_sorting_order_label']) ? $advSearchSetting['events_sorting_order_label'] : '' }}
                                    @endif
                                </label>
                                <select class="block appearance-none can-exp-input pr-8" name="sorting" id="sorting">
                                    @php
                                        $sortingSelected = isset($_GET['sorting']) ? $_GET['sorting'] : 'a-z';
                                    @endphp
                                    <option value="a-z" {{ $sortingSelected == 'a-z' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['alphabetical_order_a_z']) ? $advSearchSetting['alphabetical_order_a_z'] : '' }}
                                    </option>
                                    <option value="z-a" {{ $sortingSelected == 'z-a' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['alphabetical_order_z_a']) ? $advSearchSetting['alphabetical_order_z_a'] : '' }}
                                    </option>
                                    @if ($categorySelected == 'trade-shows-and-events')
                                        <option value="display-past-events"
                                            {{ $sortingSelected == 'display-past-events' ? 'selected' : '' }}>
                                            {{ isset($advSearchSetting['display_past_events']) ? $advSearchSetting['display_past_events'] : '' }}
                                        </option>
                                    @endif
                                    @if ($categorySelected == 'inquaries-to-buy')
                                        <option value="include-expired"
                                            {{ $sortingSelected == 'include-expired' ? 'selected' : '' }}>
                                            {{ isset($advSearchSetting['include_expired']) ? $advSearchSetting['include_expired'] : '' }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-center mt-1">
                            <button aria-label="Candian Exporters" type="submit"
                                class="button-exp-fill">{{ isset($advSearchSetting['search_type_btn_text']) ? $advSearchSetting['search_type_btn_text'] : '' }}</button>
                        </div>
                    </form>
                    @endif
                </section>
                @if (isset($_GET['search']))
                    <div class="justify-center mb-8 mt-8">
                        @if (!empty($searchCustomerProfiles))
                            @include('web.advance-search.business-categories', [
                                'searchCustomerProfiles' => $searchCustomerProfiles,
                                'lang' => $lang,
                                'advSearchSetting' => $advSearchSetting,
                            ])
                        @elseif (!empty($searchI2bs))
                            {{-- <h1 class="can-exp-h2 text-center text-primary">
                                {{ isset($advSearchSetting['i2b_search_results_for_text']) ? $advSearchSetting['i2b_search_results_for_text'] : '' }}
                                ({{ $_GET['search'] }})
                            </h1> --}}
                            @include('web.advance-search.i2b', [
                                'searchI2bs' => $searchI2bs,
                                'advSearchSetting' => $advSearchSetting,
                            ])
                        @elseif (!empty($searchEvents))
                            {{-- <h1 class="can-exp-h2 text-center text-primary">
                                {{ isset($advSearchSetting['events_search_results_for_text']) ? $advSearchSetting['events_search_results_for_text'] : '' }}
                                ({{ $_GET['search'] }})
                            </h1> --}}
                            @include('web.advance-search.events', [
                                'searchEvents' => $searchEvents,
                                'advSearchSetting' => $advSearchSetting,
                            ])
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var elements = document.getElementsByClassName('remove-item');
        var removeCustomerProfile = function() {
            var attribute = this.getAttribute("data-id");
            var type = this.getAttribute("data-type");
            axios.post('{{ route('user.search.removeExportsFromSearch') }}', {
                id: attribute,
                type: type
            });
            document.querySelector(`#canaidan-exporters-${attribute}`).classList.add("hidden");
        };
        for (var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('click', removeCustomerProfile, false);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const sortingSelect = document.getElementById("sorting");

            document.getElementById('category').addEventListener('change', function() {
                sortingSelect.innerHTML = '';

                document.querySelector('#canadian-exporters').classList.add("hidden");
                // document.querySelector('#canadian-exporters').value = "all";
                $("#canadian-exporters-select").select2("val", ["all"]);
                document.querySelector('#inquaries-to-buy').classList.add("hidden");
                // document.querySelector('#inquaries-to-buy').value = 'all';
                $("#inquaries-to-buy-select").select2("val", ["all"]);
                document.querySelector('#trade-shows-and-events').classList.add("hidden");
                // document.querySelector('#trade-shows-and-events').value = 'all';
                $("#trade-shows-and-events-select").select2("val", ["all"]);

                if (this.value) {
                    const el = document.querySelector('#' + this.value);
                    el.classList.remove("hidden");
                }
                if (this.value == 'inquaries-to-buy') {
                    document.getElementById("sorting-label").innerHTML =
                        "{{ isset($advSearchSetting['i2b_sorting_order_label']) ? $advSearchSetting['i2b_sorting_order_label'] : '' }}";

                    addSortingOption("a-z",
                        "{{ isset($advSearchSetting['alphabetical_order_a_z']) ? $advSearchSetting['alphabetical_order_a_z'] : '' }}"
                    );
                    addSortingOption("z-a",
                        "{{ isset($advSearchSetting['alphabetical_order_z_a']) ? $advSearchSetting['alphabetical_order_z_a'] : '' }}"
                    );
                    addSortingOption("include-expired",
                        "{{ isset($advSearchSetting['include_expired']) ? $advSearchSetting['include_expired'] : '' }}"
                    );
                } else if (this.value == 'trade-shows-and-events') {
                    document.getElementById("sorting-label").innerHTML =
                        "{{ isset($advSearchSetting['events_sorting_order_label']) ? $advSearchSetting['events_sorting_order_label'] : '' }}";

                    addSortingOption("a-z",
                        "{{ isset($advSearchSetting['alphabetical_order_a_z']) ? $advSearchSetting['alphabetical_order_a_z'] : '' }}"
                    );
                    addSortingOption("z-a",
                        "{{ isset($advSearchSetting['alphabetical_order_z_a']) ? $advSearchSetting['alphabetical_order_z_a'] : '' }}"
                    );
                    addSortingOption("display-past-events",
                        "{{ isset($advSearchSetting['display_past_events']) ? $advSearchSetting['display_past_events'] : '' }}"
                    );
                } else {
                    document.getElementById("sorting-label").innerHTML =
                        "{{ isset($advSearchSetting['ce_sorting_order_label']) ? $advSearchSetting['ce_sorting_order_label'] : '' }}";

                    addSortingOption("a-z",
                        "{{ isset($advSearchSetting['alphabetical_order_a_z']) ? $advSearchSetting['alphabetical_order_a_z'] : '' }}"
                    );
                    addSortingOption("z-a",
                        "{{ isset($advSearchSetting['alphabetical_order_z_a']) ? $advSearchSetting['alphabetical_order_z_a'] : '' }}"
                    );
                }
            });


            function addSortingOption(value, text) {
                const option = document.createElement("option");
                option.value = value;
                option.textContent = text;
                sortingSelect.appendChild(option);
            }
        });

//         document.addEventListener("DOMContentLoaded", function() {
//     const sortingSelect = document.getElementById("sorting");

//     document.getElementById('category').addEventListener('change', function() {
//         sortingSelect.innerHTML = '';

//         // Hide all category-specific elements
//         document.querySelectorAll('.category-specific').forEach(el => el.classList.add("hidden"));

//         // Reset select2 values
//         document.querySelectorAll('.category-select').forEach(select => {
//             $(select).select2("val", ["all"]);
//         });

//         if (this.value) {
//             const el = document.querySelector('#' + this.value);
//             el.classList.remove("hidden");
//         }

//         let sortingOptions = [];
//         if (this.value === 'inquaries-to-buy') {
//             document.getElementById("sorting-label").innerHTML =
//                 "{{ isset($advSearchSetting['i2b_sorting_order_label']) ? $advSearchSetting['i2b_sorting_order_label'] : '' }}";
//             sortingOptions = [
//                 { value: "a-z", text: "{{ isset($advSearchSetting['alphabetical_order_a_z']) ? $advSearchSetting['alphabetical_order_a_z'] : '' }}" },
//                 { value: "z-a", text: "{{ isset($advSearchSetting['alphabetical_order_z_a']) ? $advSearchSetting['alphabetical_order_z_a'] : '' }}" },
//                 { value: "include-expired", text: "{{ isset($advSearchSetting['include_expired']) ? $advSearchSetting['include_expired'] : '' }}" }
//             ];
//         } else if (this.value === 'trade-shows-and-events') {
//             document.getElementById("sorting-label").innerHTML =
//                 "{{ isset($advSearchSetting['events_sorting_order_label']) ? $advSearchSetting['events_sorting_order_label'] : '' }}";
//             sortingOptions = [
//                 { value: "a-z", text: "{{ isset($advSearchSetting['alphabetical_order_a_z']) ? $advSearchSetting['alphabetical_order_a_z'] : '' }}" },
//                 { value: "z-a", text: "{{ isset($advSearchSetting['alphabetical_order_z_a']) ? $advSearchSetting['alphabetical_order_z_a'] : '' }}" },
//                 { value: "display-past-events", text: "{{ isset($advSearchSetting['display_past_events']) ? $advSearchSetting['display_past_events'] : '' }}" }
//             ];
//         } else {
//             document.getElementById("sorting-label").innerHTML =
//                 "{{ isset($advSearchSetting['ce_sorting_order_label']) ? $advSearchSetting['ce_sorting_order_label'] : '' }}";
//             sortingOptions = [
//                 { value: "a-z", text: "{{ isset($advSearchSetting['alphabetical_order_a_z']) ? $advSearchSetting['alphabetical_order_a_z'] : '' }}" },
//                 { value: "z-a", text: "{{ isset($advSearchSetting['alphabetical_order_z_a']) ? $advSearchSetting['alphabetical_order_z_a'] : '' }}" }
//             ];
//         }

//         sortingOptions.sort((a, b) => a.text.localeCompare(b.text, '{{ app()->getLocale() }}'));

//         sortingOptions.forEach(option => {
//             addSortingOption(option.value, option.text);
//         });
//     });

//     function addSortingOption(value, text) {
//         const option = document.createElement("option");
//         option.value = value;
//         option.textContent = text;
//         sortingSelect.appendChild(option);
//     }
// });

    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.remove-item', function() {
            let attribute = this.getAttribute("data-id");
            let type = this.getAttribute("data-type");
            Swal.fire({
                html: `<p class="text-center">Are you sure you want to remove this listing from your search results?</p>`,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Yes",
                denyButtonText: `No`,
                buttonsStyling: false,
            customClass: {
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
                confirmButton: 'button-exp-fill focus:outline-none mx-2',
                denyButton: 'button-exp-no-fill focus:outline-none',
            },
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post('{{ route('user.search.removeExportsFromSearch') }}', {
                        id: attribute,
                        type: type
                    });
                    document.querySelector(`#canaidan-exporters-${attribute}`).classList.add("hidden");
                } else if (result.isDenied) {}
            });
        })
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                width: '100%',
                language: {
                    noResults: function() {
                        return "This Business Category does not exist. Please select from the menu"; // Customize this message
                    }
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {

            $('#canadian-exporters-select').on('select2:select', function(e) {
                const selectedValues = $('#canadian-exporters-select').val() || [];

                var selectedData = e.params.data;
                var selectedValue = selectedData.id;
                if (selectedValue == 'all') {
                    $('#canadian-exporters-select').val(['all']).trigger('change');
                } else if (selectedValues.includes('all')) {
                    let withoutAll = [];
                    withoutAll = selectedValues.filter(value => value !== 'all');
                    $('#canadian-exporters-select').val(withoutAll).trigger('change');
                }
            });

            $('#canadian-exporters-select').on('select2:unselect', function(e) {
                const selectedValues = $('#canadian-exporters-select').val() || [];

                if (selectedValues.length === 0) {
                    $('#canadian-exporters-select').val(['all']).trigger('change');
                }
            });

            $('#inquaries-to-buy-select').on('select2:select', function(e) {
                const selectedValues = $('#inquaries-to-buy-select').val() || [];

                var selectedData = e.params.data;
                var selectedValue = selectedData.id;
                if (selectedValue == 'all') {
                    $('#inquaries-to-buy-select').val(['all']).trigger('change');
                } else if (selectedValues.includes('all')) {
                    let withoutAll = [];
                    withoutAll = selectedValues.filter(value => value !== 'all');
                    $('#inquaries-to-buy-select').val(withoutAll).trigger('change');
                }
            });

            $('#inquaries-to-buy-select').on('select2:unselect', function(e) {
                const selectedValues = $('#inquaries-to-buy-select').val() || [];

                if (selectedValues.length === 0) {
                    $('#inquaries-to-buy-select').val(['all']).trigger('change');
                }
            });

            $('#trade-shows-and-events-select').on('select2:select', function(e) {
                const selectedValues = $('#trade-shows-and-events-select').val() || [];

                var selectedData = e.params.data;
                var selectedValue = selectedData.id;
                if (selectedValue == 'all') {
                    $('#trade-shows-and-events-select').val(['all']).trigger('change');
                } else if (selectedValues.includes('all')) {
                    let withoutAll = [];
                    withoutAll = selectedValues.filter(value => value !== 'all');
                    $('#trade-shows-and-events-select').val(withoutAll).trigger('change');
                }
            });

            $('#trade-shows-and-events-select').on('select2:unselect', function(e) {
                const selectedValues = $('#trade-shows-and-events-select').val() || [];

                if (selectedValues.length === 0) {
                    $('#trade-shows-and-events-select').val(['all']).trigger('change');
                }
            });
        });
    </script>
@endsection
