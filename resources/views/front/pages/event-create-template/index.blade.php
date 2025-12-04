@isset($eventCreateSettingDetail)
    <div class="h-full bg-gray-50">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section class="">
                    @if (session('status'))
                        <success-message type="{{ session('status') }}" message="{{ session('message') }}"></success-message>
                    @endif

                    @isset($page->pageDetail[0])
                        <div class="">
                            @php
                                $page_detail = isset($_GET['id']) ? $page->pageDetail[0]->edit_page_detail : $page->pageDetail[0]->page_detail;
                            @endphp
                            @include('front.pages.widgets.render-widget-with-detail', [
                                'page_detail' => $page_detail,
                            ])
                        </div>
                    @endisset
                    @php
                        $loggedInUser = null;
                        $languages = getAllLanguages();
                        $eventLink = isset($general_setting['user_event_listing_page']) ? $general_setting['user_event_listing_page'] : '#';
                    @endphp
                    @if (Auth::guard('customers')->check())
                        @php
                            $loggedInUser = Auth::guard('customers')
                                ->user()
                                ->loadMissing('registrationPackage');
                        @endphp
                    @endif

                    <div class="container">
                        @if ($loggedInUser)
                            @php
                                $event_id = isset($_GET['id']) ? $_GET['id'] : null;
                            @endphp
                            <create-event eventsetting="{{ $eventCreateSettingDetail }}" languages="{{ $languages }}"
                                url="{{ $eventLink }}" page_id="{{ $page->id }}" current_user="{{ $loggedInUser }}"
                                default_lang="{{ $lang }}" event_id="{{ $event_id }}">
                            </create-event>
                        @endif
                    </div>
                    {{-- <all-events></all-events> --}}
                    <!--Tabs-->
                </section>
            </div>
        </div>
    </div>

@endisset
