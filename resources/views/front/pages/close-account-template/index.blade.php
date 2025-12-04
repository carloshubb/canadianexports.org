@isset($closeAccountSettingDetail)
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="">
                <section class="rounded-md">
                    @isset($page->pageDetail[0])
                        <div class="">
                            @php
                                $page_detail = $page->pageDetail[0]->page_detail;
                            @endphp
                            @include('front.pages.widgets.render-widget-with-detail', [
                                'page_detail' => $page_detail,
                            ])
                        </div>
                        <h1 class="text-center">{{ $closeAccountSettingDetail->page_heading }}</h1>
                    @endisset
                    @php
                        $popup_setting = getStaticTranslationByKey($lang, 'general_messages', [
                            'message_30',
                            'message_31',
                            'message_32',
                            'message_33',
                        ]);
                    @endphp
                    <!--Tabs-->
                    {{-- <deactive-profile submit_url="{{ route('web.user.delete-profile') }}"
                        close_acc_setting="{{ $closeAccountSettingDetail }}"
                        popup_setting="{{ $popup_setting }}"></deactive-profile> --}}

                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <close-account close_account_setting="{{ $closeAccountSettingDetail }}"
                                submit_url="{{ route('web.user.delete-profile') }}" page_id="{{ $page->id }}"
                                popup_setting="{{ json_encode($popup_setting) }}">
                            </close-account>
                        </div>

                    </div>


                </section>
            </div>
        </div>
    </div>
@endisset
