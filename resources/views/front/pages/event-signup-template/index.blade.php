@isset($eventSignupSettingDetail)
    <div class="h-full bg-gray-50">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section class="">
                    @php
                        // Define variables first
                        $event_id = isset($_GET['id']) ? $_GET['id'] : null;
                        $event_slug = isset($_GET['slug']) ? $_GET['slug'] : null;
                        $languages = getAllLanguages();
                        $payment_setting = getI2bModalSetting($lang, ['payment_setting']);
                        $user = auth()->guard('customers')->user();
                        $submit_url = $user
                            ? route('web.event-signup.payment')
                            : route('web.event-signup.signup');
                    @endphp
                    @isset($page->pageDetail[0])
                        <div class="">
                            @php
                                $page_detail = $page->pageDetail[0]->page_detail;
                                // If editing an event, change the title
                                if ($event_id) {
                                    $page_detail = str_replace('Event Sign-up', 'Edit Event', $page_detail);
                                    $page_detail = str_replace('Event Signup', 'Edit Event', $page_detail);
                                }
                            @endphp
                            @include('front.pages.widgets.render-widget-with-detail', [
                                'page_detail' => $page_detail,
                            ])
                        </div>
                    @endisset
                    @if (session('status'))
                        <success-message type="{{ session('status') }}" message="{{ session('message') }}"></success-message>
                    @endif
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 mx-auto container">
                        <div class="order-2 md:order-1">
                            <create-event-signup event_detail="{{ $eventSignupSettingDetail }}"
                                eventsetting="{{ $eventCreateSettingDetail }}"
                                languages="{{ $languages }}"
                                submit_url="{{ $submit_url }}"
                                email_validation_url="{{ route('web.event-signup.signup-email-validation') }}"
                                page_id="{{ $page->id }}" create_page_id="{{ $page1->id }}" lang="{{ $lang }}"
                                payment_setting="{{ $payment_setting }}"
                                event_id="{{ $event_id }}"
                                event_slug="{{ $event_slug }}"
                                current_user="{{ json_encode($user) }}"></create-event-signup>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endisset
