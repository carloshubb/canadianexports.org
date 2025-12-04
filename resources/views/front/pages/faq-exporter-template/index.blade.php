    {{-- <div class="h-full bg-gray-100">
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

                        <div class="mt-8 gap-5">
                            @php
                                $faqs = getAllFaqs('exporter', 0, $lang);
                            @endphp
                            @foreach ($faqs as $faq)
                                @isset($faq->faqDetail[0])
                                    <div
                                        class="">
                                        <p class="text-primary mb-2 mt-4">{!! $faq->faqDetail[0]->question !!}</p>
                                        {!! $faq->faqDetail[0]->answer !!}
                                    </div>
                                @endisset
                            @endforeach

                        </div>
                        <div class="my-4">
                            {{ $faqs->links() }}
                        </div>
                    </div>



                </section>
            </div>
        </div>
    </div> --}}


    @isset($faqExporterSettingDetail)
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
                        <div class="mt-8 gap-5">
                            @php
                                $faqs = getAllFaqs('exporter', 0, $lang);
                            @endphp
                            @foreach ($faqs as $faq)
                                @isset($faq->faqDetail[0])
                                    <div
                                        class="">
                                        <p class="text-primary mb-2 mt-4">{!! $faq->faqDetail[0]->question !!}</p>
                                        {!! $faq->faqDetail[0]->answer !!}
                                    </div>
                                @endisset
                            @endforeach

                        </div>
                        <div class="my-4">
                            {{ $faqs->links() }}
                        </div>
                        <h1 class="text-center">{{ $faqExporterSettingDetail->page_heading }}</h1>
                        <p class="text-red-500"><span class="text-red-500">*</span>
                            {{ $faqExporterSettingDetail->required_fields_text }}</p>
                    </div>
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <faq-exporter faq_exporter_setting="{{ $faqExporterSettingDetail }}"
                                submit_url="{{ route('user.faq-exporter.send-message') }}" page_id="{{ $page->id }}">
                            </faq-exporter>
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>
@endisset
