@isset($contactUsSettingDetail)
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="">
                <section class="rounded-md">
                    <h1 class="text-center">{{ $contactUsSettingDetail->page_heading }}</h1>
                    <div class="container">
                        {!! $contactUsSettingDetail->page_description !!}
                    </div>
                    <div class="container mx-auto mt-6">
                        <div class="relative isolate bg-white shadow">
                            <div class="mx-auto grid max-w-7xl grid-cols-1 lg:grid-cols-2">
                                <div class="px-6 md:py-10 lg:static lg:px-8 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 py-6">
                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->mail_address_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->mail_address }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->toll_free_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->toll_free }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->telephone_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->telephone }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->fax_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->fax }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->e_mail_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->e_mail }}</p>
                                    </div>
                                </div>
                                <div class="relative px-6 lg:static z-0 lg:px-8 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 py-6">
                                    <div class="absolute right-0 inset-y-0 -z-10 w-full overflow-hidden bg-gray-100  lg:w-1/2">
                                        <svg class="absolute inset-0 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
                                            aria-hidden="true">
                                            <rect width="100%" height="100%" stroke-width="0" fill="white"></rect>

                                        </svg>
                                    </div>

                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->website_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->website }}</p>
                                    </div>

                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->general_inquires_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->general_inquires }}</p>
                                    </div>

                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->sales_department_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->sales_department }}</p>
                                    </div>

                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->job_at_canadian_exporters_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->job_at_canadian_exporters }}</p>
                                    </div>

                                    <div>
                                        <h5 class="text-primary mt-3 w-full">{{ $contactUsSettingDetail->office_hours_label }}</h5>
                                        <p class="mt-1">{{ $contactUsSettingDetail->office_hours }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                        <h1 class="text-center mt-10">{{ $contactUsSettingDetail->heading }}</h1>
                    <div class="container">
                        <p class="text-red-500"><span class="text-red-500">*</span>
                            {{ $contactUsSettingDetail->required_field_text }}</p>
                    </div>
                    {{-- @isset($page->pageDetail[0])
                    <div class="">
                        @php
                            $page_detail = $page->pageDetail[0]->page_detail;
                        @endphp
                        @include('front.pages.widgets.render-widget-with-detail', [
                            'page_detail' => $page_detail,
                        ])
                    </div>
                    @endisset --}}
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <create-contact-us contact_us="{{ $contactUsSettingDetail }}"
                                submit_url="{{ route('user.contact-us.send-message') }}"
                                page_id="{{ $page->id }}"></create-contact-us>
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>
@endisset
