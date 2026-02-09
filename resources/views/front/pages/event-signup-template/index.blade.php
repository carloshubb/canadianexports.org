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
                                    $page_detail = '<h1 style="text-align: center; line-height: 1;">Update Your Event Details</h1>
                                                    <p dir="ltr" style="text-align: center; line-height: 1;"><span style="font-size: 18px;">List your trade show or event on Canada&rsquo;s premier trade discovery platform. Connect with industry leaders and reach a global audience of exporters and buyers.</span></p>
                                                    <p dir="ltr"><br>&bull; Complete this secure form to submit your Trade Show or Event details.</p>
                                                    <p dir="ltr">&bull; <strong id="docs-internal-guid-87b606bf-7fff-ec8d-7ae5-4d2e23fd0fba">Instant Activation: </strong>Your event listing goes live immediately after payment is confirmed.</p> 
                                                    <p dir="ltr">&bull; <strong id="docs-internal-guid-0ab3d756-7fff-2cb4-abc7-310c1caa614a">Quality Control: </strong>We reserve the right to remove or edit listings that do not meet our professional standards.</p> 
                                                    <p dir="ltr">&bull; <strong id="docs-internal-guid-dea970a8-7fff-9ccd-ec3f-3addbd16bfe5">Tax Transparency: </strong>Taxes are applied based on your location; 0% tax applies to most international organizers. Users are responsible for their own local tax reporting.</p> 
                                                    <p dir="ltr"><strong id="docs-internal-guid-8d3c5e19-7fff-f72d-834b-951c2b47ae32">&bull; Need assistance?&nbsp;</strong>Call us at +1 877-333-3014 (Mon&ndash;Fri, 9:30 AM&ndash;4:00 PM EST).</p> 
                                                    <p dir="ltr">&bull;Refine your event information to ensure maximum impact. Any changes you make here will be updated Live on our global platform immediately. Keep your listing fresh and accurate to attract the best international trade partners. </p>
                                                    <p dir="ltr">&nbsp;</p>
                                                    <p><strong id="docs-internal-guid-3bd1d111-7fff-9900-b4f1-3aa3ede040f9"></strong></p>
                                                    <p style="text-align: right;"><span style="color: #e74c3c;">* Indicates required fields</span></p>
                                                    ';
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
                                :languages='@json($languages)'
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
