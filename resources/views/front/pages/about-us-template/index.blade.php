@isset($page->pageDetail[0])
    <section class="relative lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 ">

        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 px-2">
            <div class="absolute inset-0 opacity-25 bg-map bg-no-repeat bg-center bg-cover"></div>

            <div class="relative grid grid-cols-1">
                <div class="can-exp-p text-secondary leading-6 text-justify">
                    @php
                        $page_detail = $page->pageDetail[0]->page_detail;
                    @endphp
                    @include('front.pages.widgets.render-widget-with-detail', [
                        'page_detail' => $page_detail,
                    ])
                </div>
            </div>
        </div>
    </section>
@endisset
