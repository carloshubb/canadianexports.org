@isset($scamAlertSettingDetail)
    <div class="h-full bg-gray-50">
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
                        <h1 class="text-center">{{ $scamAlertSettingDetail->page_heading }}</h1>
                    @endisset
                    <div class="container">
                        <p class="text-red-500"><span class="text-red-500">*</span>
                            {{ $scamAlertSettingDetail->required_fields_text }}</p>
                    </div>
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <scam-alert scam_alert_setting="{{ $scamAlertSettingDetail }}"
                                submit_url="{{ route('user.scam-alert.send-message') }}" page_id="{{ $page->id }}">
                            </scam-alert>
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>
@endisset
