@php
$event_detail_setting = getI2bModalSetting($lang, ['event_detail_setting']);
$events = getAllEvents(30, $lang, 'package_type');
// $events = $events->where('package_type', 'featured');
// $events = $events->where('featured', true);
@endphp
<section class="home-container relative lg:py-[100px] md:pt-10 md:pb-10 pt-10 pb-10 bg-[#F3F7FA]">
    <div class="">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 ">
            <h2 class="can-exp-h1 mb-0 text-left font-semibold text-[#006EB7]">
                {!! $homePageSettingDetail->section5_heading !!}
            </h2>
            
            <div class="flex flex-wrap justify-end items-center gap-2">
                <div class="flex justify-center">
                    @php
                    $url = $homePageSettingDetail->section5_see_all_button_url;
                    $url = langBasedURL($lang, $url);
                    // Get dynamic messages
                    $general_messages = getStaticTranslationByKey($lang ?? null, 'general_messages', [
                    'message_66',
                    'message_67',
                    ]);
                    $message_66 = $general_messages['message_66'] ?? 'Sponsor accounts cannot access event listings.';
                    $message_67 = $general_messages['message_67'] ?? 'Sponsor accounts cannot create events.';
                    @endphp
                    @if (Auth::guard('customers')->check() && Auth::guard('customers')->user()->type === 'sponsor')
                    <a aria-label="{{ __('Canadian Exporters') }}" href="{!! $url !!}" class="button-exp-fill flex justify-center items-center h-[40px] rounded-none">
                        {!! $homePageSettingDetail->section5_see_all_button_text !!}
                    </a>
                    @else
                    <a aria-label="{{ __('Canadian Exporters') }}" href="{!! $url !!}" class="button-exp-fill flex justify-center items-center h-[40px] rounded-none">
                        {!! $homePageSettingDetail->section5_see_all_button_text !!}
                    </a>
                    @endif
                </div>

                @php
                $general_setting = getSignleGeneralSettingByKey(['user_event_signup_page']);
                $eventSignupRoute = isset($general_setting['user_event_signup_page'])
                ? route('front.index', $general_setting['user_event_signup_page'])
                : '#';
                $eventSignupUrl = langBasedURL($lang, $eventSignupRoute);
                @endphp

                @if (Auth::guard('customers')->check())
                @php
                $user = Auth::guard('customers')->user();
                @endphp

                @if ($user->type !== 'event')
                {{-- Free exporter: show membership notice modal first --}}
                <div class="flex justify-center">
                    <a aria-label="{{ __('Canadian Exporters') }}" href="javascript:void(0)" onclick="openMembershipNoticeEventPostingModal(); return false;" class="button-exp-no-fill flex justify-center items-center h-[40px] rounded-none">
                        {!! $homePageSettingDetail->section5_add_event_text !!}
                    </a>
                </div>
                @else
                @php
                $events_remaining = $user->events_remaining;
                $hasPaid = $user->is_package_amount_paid;
                $reviewConfirmationUrl = route('user.payment.index', [$lang->abbreviation]);
                // Always use event-signup page (all 5 steps)
                $eventSignupRoute = isset($general_setting['user_event_signup_page'])
                ? route('front.index', $general_setting['user_event_signup_page'])
                : '#';
                $addEventUrl = langBasedURL($lang, $eventSignupRoute);
                @endphp

                @if ($events_remaining == null || $events_remaining <= 0)
                    {{-- Free exporter (no event credits): show membership notice modal first --}}
                    <div class="flex justify-center">
                    <a aria-label="{{ __('Canadian Exporters') }}" href="javascript:void(0)" onclick="openMembershipNoticeEventPostingModal(); return false;" class="button-exp-no-fill flex justify-center items-center h-[40px] rounded-none">
                        {!! $homePageSettingDetail->section5_add_event_text !!}
                    </a>
            </div>
            @else
            <div class="flex justify-center">
                <a aria-label="{{ __('Canadian Exporters') }}"
                    href="{{ $hasPaid ? $addEventUrl : $reviewConfirmationUrl }}"
                    class="button-exp-no-fill flex justify-center items-center h-[40px] rounded-none">
                    {!! $homePageSettingDetail->section5_add_event_text !!}
                </a>
            </div>
            @endif
            @endif
            @else
            <div class="flex justify-center">
                <a aria-label="{{ __('Canadian Exporters') }}" href="{!! $eventSignupUrl !!}" class="button-exp-no-fill flex justify-center items-center h-[40px] rounded-none">
                    {!! $homePageSettingDetail->section5_add_event_text !!}
                </a>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-2 relative">
        <div class="swiper featured-events-slider-container relative z-0" style="padding: 0px !important;">
            <div class="swiper-wrapper">
                @foreach ($events as $event)
                <div class="swiper-slide h-full">
                    <div class="bg-white w-full border border-[#c9dbe9] shadow-md shadow-blue-500/20 h-[480px] flex flex-col featured-events-swiper-slide overflow-hidden">
                        @php
                        $event->start_date = isset($event->start_date)
                        ? date('F d, Y', strtotime($event->start_date))
                        : '';
                        $event->end_date = isset($event->end_date)
                        ? date('F d, Y', strtotime($event->end_date))
                        : '';
                        $url = route('user.event.show', [
                        'abbreviation' => $lang->abbreviation,
                        'id' => $event->id,
                        ]);
                        $eventDetail = $event->eventDetail->where('language_id', $lang->id)->first() ?? $event->eventDetail->first();
                        @endphp
                        
                        {{-- Image at top --}}
                        <div class="w-full h-[236px] overflow-hidden">
                            @if (isset($event->media) && file_exists($event->media->medium_image))
                                <img src="{{ asset($event->media->medium_image) }}" 
                                    class="object-cover w-full h-full" 
                                    alt="{{ $eventDetail->title ?? __('Event') }}" />
                            @else
                                <img src="{{ asset('assets/images/logocircle.png') }}" 
                                    class="object-cover w-full h-full bg-gray-50" 
                                    alt="{{ __('Event') }}" />
                            @endif
                        </div>

                        {{-- Content section --}}
                        <div class="flex-1 flex flex-col min-w-0 px-4 py-4 justify-between">
                            <div class="flex flex-col">
                                <h2 class="mb-3 text-left text-2xl font-semibold text-[#000000] leading-tight">
                                    {{ Str::limit($eventDetail->title ?? '', 64, '...') }}
                                </h2>
                                <p class="mb-4 text-gray-600 text-left text-sm leading-relaxed">
                                    {{ Str::limit($eventDetail->description ?? $eventDetail->short_description ?? '', 136, '...') }}
                                </p>
                                
                                {{-- Event details with icons --}}
                                <div class="flex flex-col gap-2 mb-4 text-left">
                                    @if ($eventDetail && ($eventDetail->street_name || $eventDetail->city || $eventDetail->venue))
                                        <div class="flex items-start gap-2 text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mt-0.5 flex-shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                            </svg>
                                            <span class="truncate">
                                                @if ($eventDetail->venue)
                                                    {{ $eventDetail->venue }},
                                                @endif
                                                @if ($eventDetail->street_name)
                                                    {{ $eventDetail->street_name }},
                                                @endif
                                                @if ($eventDetail->city)
                                                    {{ $eventDetail->city }}
                                                @endif
                                                @if ($eventDetail->country)
                                                    , {{ $eventDetail->country }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if ($event->start_date || $event->end_date)
                                        <div class="flex items-start gap-2 text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mt-0.5 flex-shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            <span>
                                                @if ($event->start_date && $event->end_date)
                                                    {{ $event->start_date }} - {{ $event->end_date }}
                                                @elseif ($event->start_date)
                                                    {{ $event->start_date }}
                                                @elseif ($event->end_date)
                                                    {{ $event->end_date }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if ($event->event_website)
                                        <div class="flex items-start gap-2 text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mt-0.5 flex-shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m-2.715-9.253a8.959 8.959 0 00-9.002 0m9.002 0a11.94 11.94 0 01-3.287 5.022m-11.43 0a11.94 11.94 0 013.287-5.022" />
                                            </svg>
                                            <span class="break-all">{{ $event->event_website }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- More Event Details link --}}
                            <div class="text-left">
                                <a aria-label="{{ __('Canadian Exporters') }}" href="{{ $url }}"
                                    class="text-primary text-sm hover:underline font-medium">
                                    <span data-i18n="More Event Details">{{ __('More Event Details') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
        <div class="featured-events-button-next-exp absolute z-50" style="right: -72px; top: 50%; transform: translateY(-50%);">
            <div
                class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                </svg>
            </div>
        </div>
        <div class="featured-events-button-prev-exp absolute z-50" style="left: -72px; top: 50%; transform: translateY(-50%);">
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
    
    @include('front.pages.partials.membership-notice-event-posting-modal', ['eventSignupUrl' => $eventSignupUrl])
    <div id="sponsorRestrictionModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <p id="restrictionMessage" class="mb-4"></p>
            <div class="flex justify-center">
                <button onclick="document.getElementById('sponsorRestrictionModal').classList.add('hidden')"
                    class="px-4 py-2 bg-primary text-white rounded">
                    {{ __('close') }}
                </button>
            </div>
        </div>
    </div>
@section('scripts')
@parent
    <script>
        // Define messages in JavaScript from PHP
        const restrictionMessages = {
            see_all: {!! json_encode($message_66) !!},
            add_event: {!! json_encode($message_67) !!}
        };

        function showSponsorRestrictionPopup(action) {
            const modal = document.getElementById('sponsorRestrictionModal');
            const messageElement = document.getElementById('restrictionMessage');

            // Set the appropriate message based on the action
            messageElement.textContent = restrictionMessages[action] ||
                @json(__('This action is restricted for sponsor accounts.'));

            // Show the modal
            modal.classList.remove('hidden');
        }
    </script>
@endsection
</section>