@isset($sponsorPageSettingDetail)
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
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <form class="lg:w-full" id="sponsor-form">
                                <div class="my-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block text-gray-900 mb-2"
                                            for="email">{!! $sponsorPageSettingDetail->email_label !!}</label>
                                        <input type="email"
                                            class="can-exp-input"
                                            placeholder="" id="email" required />
                                    </div>
                                    <div class="relative w-full mb-3">
                                        <label class="block text-gray-900 mb-2"
                                            for="contact">{!! $sponsorPageSettingDetail->contact_label !!}</label>
                                        <input type="text"
                                            class="can-exp-input"
                                            placeholder="" id="contact" required />
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}">
                                    </div>
                                    <div class="mt-8 flex justify-center items-center">
                                        <button aria-label="Candian Exporters" class="button-exp-fill" type="submit"
                                            id="send-message">{!! $sponsorPageSettingDetail->button_text !!}</button>
                                    </div>
                                </div>


                            </form>
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>

@endisset
