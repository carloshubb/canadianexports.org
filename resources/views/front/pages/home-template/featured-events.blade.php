@php
$event_detail_setting = getI2bModalSetting($lang, ['event_detail_setting']);
$events = getAllEvents(30, $lang, 'package_type');
$events = $events->where('package_type', 'featured');
$events = $events->where('featured', true);
@endphp
<section class="relative lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
    <div class="container">
        <div class="grid grid-cols-1 text-center">
            <h2 class="can-exp-h1 mb-4">
                {!! $homePageSettingDetail->section5_heading !!}
            </h2>
        </div>

        <div class="">
            <div class="swiper featured-events-slider-container relative z-0">
                <div class="swiper-wrapper">
                    @foreach ($events as $event)
                    <div class="swiper-slide h-full">
                        <div class="bg-white w-full rounded border flex flex-col featured-events-swiper-slide">
                            @if (isset($event->media) && file_exists($event->media->medium_image))
                            @php
                            $event->media_path = asset($event->media->medium_image);
                            @endphp
                            @endif
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
                            @endphp
                            <event-listing event="{{ $event }}"
                                home_page_setting="{{ $homePageSettingDetail }}" url="{{ $url }}"
                                event_detail_setting="{{ $event_detail_setting }}">
                            </event-listing>
                        </div>
                    </div>
                    @endforeach


                </div>
                <div class="featured-events-button-next-exp absolute top-1/2 right-0 z-50">

                    <div
                        class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 md:w-6 md:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </div>
                </div>
                <div class="featured-events-button-prev-exp  absolute top-1/2 left-0 z-50">
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

        <div class="mt-10 flex justify-center items-center gap-2">
            <div class="flex justify-center">
                @php
                $url = $homePageSettingDetail->section5_see_all_button_url;
                $url = langBasedURL($lang, $url);
                // Get dynamic messages
                $general_messages = getStaticTranslationByKey($lang ?? null, 'general_messages', [
                'message_66',
                'message_66',
                ]);
                $message_66 = $general_messages['message_66'] ?? 'Sponsor accounts cannot access event listings.';
                $message_66 = $general_messages['message_66'] ?? 'Sponsor accounts cannot create events.';
                @endphp
                @if (Auth::guard('customers')->check() && Auth::guard('customers')->user()->type === 'sponsor')
                <a aria-label="Canadian Exporters" href="{!! $url !!}" class="button-exp-fill">
                    {!! $homePageSettingDetail->section5_see_all_button_text !!}
                </a>
                @else
                <a aria-label="Canadian Exporters" href="{!! $url !!}" class="button-exp-fill">
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
            <div class="flex justify-center">
                <a aria-label="Canadian Exporters" href="{!! $eventSignupUrl !!}" class="button-exp-no-fill">
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
                <div class="flex justify-center">
                <a aria-label="Canadian Exporters" href="{{ route('create_event_restriction') }}"
                    class="button-exp-no-fill">
                    {!! $homePageSettingDetail->section5_add_event_text !!}
                </a>
        </div>
        @else
        <div class="flex justify-center">
            <a aria-label="Canadian Exporters"
                href="{{ $hasPaid ? $addEventUrl : $reviewConfirmationUrl }}"
                class="button-exp-no-fill">
                {!! $homePageSettingDetail->section5_add_event_text !!}
            </a>
        </div>
        @endif
        @endif
        @else
        <div class="flex justify-center">
            <a aria-label="Canadian Exporters" href="{!! $eventSignupUrl !!}" class="button-exp-no-fill">
                {!! $homePageSettingDetail->section5_add_event_text !!}
            </a>
        </div>
        @endif
    </div>
    <div id="sponsorRestrictionModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <p id="restrictionMessage" class="mb-4"></p>
            <div class="flex justify-center">
                <button onclick="document.getElementById('sponsorRestrictionModal').classList.add('hidden')"
                    class="px-4 py-2 bg-primary text-white rounded">
                    close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Define messages in JavaScript from PHP
        const restrictionMessages = {
            see_all: {
                !!json_encode($message_66) !!
            },
            add_event: {
                !!json_encode($message_66) !!
            }
        };

        function showSponsorRestrictionPopup(action) {
            const modal = document.getElementById('sponsorRestrictionModal');
            const messageElement = document.getElementById('restrictionMessage');

            // Set the appropriate message based on the action
            messageElement.textContent = restrictionMessages[action] ||
                'This action is restricted for sponsor accounts.';

            // Show the modal
            modal.classList.remove('hidden');
        }
    </script>
</section>