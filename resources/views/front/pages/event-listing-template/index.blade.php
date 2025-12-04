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
                    @php
                    // Use event-signup page for both creating and editing events (all 5 steps)
                    $general_setting = getSignleGeneralSettingByKey(['user_event_signup_page']);
                    $createEventLink = isset($general_setting['user_event_signup_page']) ? $general_setting['user_event_signup_page'] : '#';
                    $upgrade_url = langBasedURL($lang, route('user.create-business-profile'));
                    $logged_in_user = auth()->guard('customers')->user() ?? null;
                    @endphp
                    <div class="container"><all-events page_id="{{$page->id}}" url="{{$createEventLink}}" upgrade_url="{{$upgrade_url}}" logged_in_user="{{$logged_in_user}}"></all-events></div>




                </section>
            </div>
        </div>
    </div>
