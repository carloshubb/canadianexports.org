@isset($infoLetterSettingDetail)
    <div class="h-full bg-gray-50">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section>
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
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <create-info-letter info_letter="{{ $infoLetterSettingDetail }}"
                                submit_url="{{ route('user.info-letter.send-message') }}" page_id="{{ $page->id }}">
                            </create-info-letter>
                        </div>

                    </div>

                </section>

            <div class="text-gray-800 leading-6">
                @php
                    $pattern = '/\[short_code=widget-(\d+)\]/';
                    $page_detail = $infoLetterSettingDetail->widget_name;
                @endphp
                @include('front.pages.widgets.render-widget-with-detail', [
                    'page_detail' => $infoLetterSettingDetail->widget_name,
                ])
            </div>
        </div>
        </div>
    </div>

@endisset
