@php
    $event_detail_setting = getI2bModalSetting($lang, ['event_detail_setting']);
    $advSearchSetting = getI2bModalSetting($lang, ['advance_search']); // Fetch advance search settings
@endphp

<div class="h-full bg-gray-100">
    <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
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
                {{-- @if (Auth::guard('customers')->check())
                @php
                    $events_remaining = Auth::guard('customers')->user()->events_remaining;

                    // $validationRule = array_merge($validationRule, ['registration_package_id' => ['required', 'exists:registration_packages,id']]);

                    // $niceNames['registration_package_id'] = 'package';
                    // return $this->errorResponse("Your access to events is limited to the end; consider upgrading your package for extended privileges.");
                @endphp
            @endif
            @if (isset($events_remaining))
                @if ($events_remaining == null || $events_remaining <= 0)
                    <div class="flex justify-center">
                        @php
                            $url = $homePageSettingDetail->section5_add_event_url;
                            $url = langBasedURL($lang, $url);
                        @endphp
                        <a aria-label="Candian Exporters" href="{{ route('create_event_restriction') }}" class="button-exp-no-fill">
                            {!! $homePageSettingDetail->section5_add_event_text !!}
                        </a>
                    </div>
                @else
                    <div class="flex justify-center">
                        @php
                            $url = $homePageSettingDetail->section5_add_event_url;
                            $url = langBasedURL($lang, $url);
                        @endphp
                        <a aria-label="Candian Exporters" href="{!! $url !!}" class="button-exp-no-fill">
                            {!! $homePageSettingDetail->section5_add_event_text !!}
                        </a>
                    </div>
                @endif
            @else
                <div class="flex justify-center">
                    @php
                        $url = $homePageSettingDetail->section5_add_event_url;
                        $url = langBasedURL($lang, $url);
                    @endphp
                    <a aria-label="Candian Exporters" href="{!! $url !!}" class="button-exp-no-fill">
                        {!! $homePageSettingDetail->section5_add_event_text !!}
                    </a>
                </div>
            @endif --}}
            <div class="container mb-8">
            @if (Auth::guard('customers')->check())
            @php
                $user = Auth::guard('customers')->user();
                $events_remaining = Auth::guard('customers')->user()->events_remaining;
                $hasPaid = $user->is_package_amount_paid;
                $reviewConfirmationUrl = route('user.payment.index', [$lang->abbreviation]);
                // Always use event-signup page (all 5 steps)
                $general_setting = getSignleGeneralSettingByKey(['user_event_signup_page']);
                $eventSignupRoute = isset($general_setting['user_event_signup_page'])
                    ? route('front.index', $general_setting['user_event_signup_page'])
                    : '#';
                $addEventUrl = langBasedURL($lang, $eventSignupRoute);
            @endphp

            @if ($events_remaining == null || $events_remaining <= 0)
                <div class="flex justify-end">
                    <a aria-label="Canadian Exporters" href="{{ route('create_event_restriction') }}" class="button-exp-fill">
                        {!! $homePageSettingDetail->section5_add_event_text !!}
                    </a>
                </div>
            @else
                <div class="flex justify-end">
                    <a aria-label="Canadian Exporters" href="{{ $hasPaid ? $addEventUrl : $reviewConfirmationUrl }}" class="button-exp-fill">
                        {!! $homePageSettingDetail->section5_add_event_text !!}
                    </a>
                </div>
            @endif
            @else
            <div class="flex justify-end">
                @php
                    // Always use event-signup page (all 5 steps)
                    $general_setting = getSignleGeneralSettingByKey(['user_event_signup_page']);
                    $eventSignupRoute = isset($general_setting['user_event_signup_page'])
                        ? route('front.index', $general_setting['user_event_signup_page'])
                        : '#';
                    $addEventUrl = langBasedURL($lang, $eventSignupRoute);
                @endphp
                <a aria-label="Canadian Exporters" href="{!! $addEventUrl !!}" class="button-exp-fill">
                    {!! $homePageSettingDetail->section5_add_event_text !!}
                </a>
            </div>
            @endif
            </div>
                <div class="container">
                    <!-- Advanced Search Form -->
                    @php
                        $url = route('user.search.eventSearch'); // Route for event search
                        $url = langBasedURL(null, $url);
                    @endphp
                    <form method="get" action="{{ $url }}">
                        <input type="hidden" name="page_id" value="{{ $page->id }}" />
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4 place-items-end">
                            <!-- Search by Event Name -->
                            <div class="relative w-full mb-3">
                                <label class="mb-2 text-primary text-base md:text-base lg:text-lg font-medium" for="search">
                                    {{ isset($eventSettingDetail['search_label']) ? $eventSettingDetail['search_label'] : '' }}
                                </label>
                                <input type="text" class="can-exp-input py-1.5"
                                    placeholder="{{ isset($eventSettingDetail['search_placeholder']) ? $eventSettingDetail['search_placeholder'] : '' }}"
                                    id="search" name="search"
                                    value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                                @error('search')
                                    @include('front.pages.error', [
                                        'errorMessage' => "$message",
                                    ])
                                @enderror
                            </div>
<!-- Filter by Event Category -->
@php
    $eventCategories = getAllEventCategories(); // Fetch event titles as categories
@endphp
<div class="relative w-full mb-3">
    <label class="mb-2 text-primary text-base md:text-base lg:text-lg font-medium" for="event-categories">
        {{ isset($eventSettingDetail['business_categories_label']) ? $eventSettingDetail['business_categories_label'] : '' }}
    </label>
    <select class="js-example-basic-multiple appearance-none w-full can-exp-input pr-8 category-options"
        id="event-categories-select" name="event-categories[]" multiple="multiple">
        @php
            $selectedEventCategories = null;
        @endphp
        @if (isset($_GET['event-categories']) && in_array('all', $_GET['event-categories']))
            @php
                $selectedEventCategories = 'selected';
            @endphp
        @endif
        <option value="all" {{ $selectedEventCategories || !isset($_GET['event-categories']) ? 'selected' : '' }}>
            {{ isset($eventSettingDetail['business_categories_all_text']) ? $eventSettingDetail['business_categories_all_text'] : '' }}
        </option>
        @foreach ($eventCategories as $id => $title)
            @php
                $selectedEventCategories = '';
            @endphp
            @if (isset($_GET['event-categories']) && in_array($id, $_GET['event-categories']))
                @php
                    $selectedEventCategories = 'selected';
                @endphp
            @endif
            <option value="{{ $id }}" {{ $selectedEventCategories }}>
                {{ ucwords(strtolower($title)) }}
            </option>
        @endforeach
    </select>
    @error('event-categories')
        @include('front.pages.error', [
            'errorMessage' => "$message",
        ])
    @enderror
</div>
                            <!-- Sorting -->
                            <div class="relative w-full mb-3">
                                <label class="mb-2 text-primary text-base md:text-base lg:text-lg font-medium" for="sorting">
                                    {{ isset($eventSettingDetail['deadline_heading']) ? $eventSettingDetail['deadline_heading'] : '' }}
                                </label>
                                <select class="block appearance-none can-exp-input pr-8 py-1.5" name="sorting" id="sorting">
                                    @php
                                        $sortingSelected = isset($_GET['sorting']) ? $_GET['sorting'] : 'a-z';
                                    @endphp
                                    <option value="a-z" {{ $sortingSelected == 'a-z' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['alphabetical_order_a_z']) ? $advSearchSetting['alphabetical_order_a_z'] : 'A-Z' }}
                                    </option>
                                    <option value="z-a" {{ $sortingSelected == 'z-a' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['alphabetical_order_z_a']) ? $advSearchSetting['alphabetical_order_z_a'] : 'Z-A' }}
                                    </option>
                                    <option value="display_past_events" {{ $sortingSelected == 'display_past_events' ? 'selected' : '' }}>
                                        {{ isset($advSearchSetting['display_past_events']) ? $advSearchSetting['display_past_events'] : 'Display Past Events' }}
                                    </option>
                                </select>
                                @error('sorting')
                                    @include('front.pages.error', [
                                        'errorMessage' => "$message",
                                    ])
                                @enderror
                            </div>
                        </div>
                        <div class="relative w-full mb-3 flex justify-center">
                            <button aria-label="Search Events" type="submit" class="button-exp-fill">
                                {{ isset($eventSettingDetail['search_button_text']) ? $eventSettingDetail['search_button_text'] : 'Search' }}
                            </button>
                        </div>
                    </form>

                    @php
                    $events = getAllEvents(30, $lang, 'title', isset($_GET['search']) ? $_GET['search'] : null, isset($_GET['event-categories']) ? $_GET['event-categories'] : null, isset($_GET['countries']) ? $_GET['countries'] : null, isset($_GET['sorting']) ? $_GET['sorting'] : null);

                    // Separate featured and non-featured events from the paginated collection
                    $featuredEvents = collect($events->items())->where('package_type', 'featured');
                    $otherEvents = collect($events->items())->where('package_type', '!=', 'featured');
                @endphp

                @if ($featuredEvents->count() > 0)
                    <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-blue-400 via-blue-400 to-secondary rounded-md my-6">
                        <h4 class="text-center text-white text-xl md:text-2xl lg:text-3xl">
                            Featured Trade Shows & Events
                        </h4>
                    </div>

                    @foreach ($featuredEvents as $event)
                        @if (isset($event->media) && file_exists($event->media->medium_image))
                            @php
                                $event->media_path = asset($event->media->medium_image);
                            @endphp
                        @endif
                        @php
                            $event->start_date = isset($event->start_date) ? date('F d, Y', strtotime($event->start_date)) : '';
                            $event->end_date = isset($event->end_date) ? date('F d, Y', strtotime($event->end_date)) : '';
                            $url = route('user.event.show', ['abbreviation' => $lang->abbreviation, 'id' => $event->id]);
                        @endphp
                        <event-listing-grid event="{{ $event }}" home_page_setting="{{ $homePageSettingDetail }}"
                            event_detail_setting="{{ $event_detail_setting }}" url="{{ $url }}">
                        </event-listing-grid>
                    @endforeach
                @endif

                @if ($otherEvents->count() > 0)
                    <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-blue-400 via-blue-400 to-secondary rounded-md my-6">
                        <h4 class="text-center text-white text-xl md:text-2xl lg:text-3xl">
                            Trade Shows & Events
                        </h4>
                    </div>

                    @foreach ($otherEvents as $event)
                        @if (isset($event->media) && file_exists($event->media->medium_image))
                            @php
                                $event->media_path = asset($event->media->medium_image);
                            @endphp
                        @endif
                        @php
                            $event->start_date = isset($event->start_date) ? date('F d, Y', strtotime($event->start_date)) : '';
                            $event->end_date = isset($event->end_date) ? date('F d, Y', strtotime($event->end_date)) : '';
                            $url = route('user.event.show', ['abbreviation' => $lang->abbreviation, 'id' => $event->id]);
                        @endphp
                        <event-listing-grid event="{{ $event }}" home_page_setting="{{ $homePageSettingDetail }}"
                            event_detail_setting="{{ $event_detail_setting }}" url="{{ $url }}">
                        </event-listing-grid>
                    @endforeach
                @endif

                @if (isset($_GET['search']) && $events->count() == 0)
                    <div class="justify-center mb-8 mt-8">
                        <h1 class="can-exp-h2 text-center text-primary">
                            @php
                                $setting = getStaticTranslationByKey($lang, 'general', ['no_result_found_text']);
                            @endphp
                            {{ isset($setting['no_result_found_text']) ? $setting['no_result_found_text'] : '' }}
                        </h1>
                    </div>
                @endif

                <div class="mt-10">
                    {{ $events->appends(request()->query())->links() }}
                </div>
