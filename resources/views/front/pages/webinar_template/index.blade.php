@php
    use App\Models\Webinar;

    $webinars = Webinar::where('status', 'published')
        ->orderBy('scheduled_at')
        ->get();
@endphp

<div class="h-full bg-gray-50">
    <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <section>
                @isset($page->pageDetail[0])
                    <div>
                        @php
                            $page_detail = $page->pageDetail[0]->page_detail;
                        @endphp
                        @include('front.pages.widgets.render-widget-with-detail', [
                            'page_detail' => $page_detail,
                        ])
                    </div>
                @endisset

                <div class="container mt-8">
                    <webinars-index
                        :webinars='@json($webinars)'
                        register-url="{{ url('api/webinars') }}"
                    ></webinars-index>
                </div>
            </section>
        </div>
    </div>
</div>

