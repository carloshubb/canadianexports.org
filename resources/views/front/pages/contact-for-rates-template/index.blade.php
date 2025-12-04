@isset($contactForRateSettingDetail)
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
                    @endisset
                    <div class="container">
                        <p class="text-red-500"><span class="text-red-500">*</span>
                            {{ $contactForRateSettingDetail->required_fields_text }}</p>
                    </div>
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <contact-for-rate-form contact_for_rate_setting="{{ $contactForRateSettingDetail }}"
                                submit_url="{{ route('user.contact-for-rates.send-message') }}" page_id="{{ $page->id }}">
                            </contact-for-rate-form>
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>
@endisset
