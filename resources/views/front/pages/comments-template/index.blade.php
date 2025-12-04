@isset($commentsSettingDetail)
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="">
                <section class="rounded-md">
                    @isset($page->pageDetail[0])
                        <h1 class="text-center">{{ $commentsSettingDetail->page_heading }}</h1>
                        <div class="container">
                            {!! $commentsSettingDetail->page_description !!}
                        </div>
                        <h1 class="text-center mt-10">{{ $commentsSettingDetail->heading }}</h1>
                        <div class="container">
                            <p class="text-red-500"><span class="text-red-500">*</span> {{ $commentsSettingDetail->required_field_text }}</p>
                        </div>
                        {{-- <div class="">
                        @php
                            $page_detail = $page->pageDetail[0]->page_detail;
                        @endphp
                        @include('front.pages.widgets.render-widget-with-detail', [
                            'page_detail' => $page_detail,
                        ])
                    </div> --}}
                    @endisset
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <create-comments comments="{{ $commentsSettingDetail }}"
                                submit_url="{{ route('user.comments.send-message') }}"
                                page_id="{{ $page->id }}"></create-comments>
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>
@endisset
