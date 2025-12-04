<div class="h-full bg-gray-100">
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
                @php
// $upgrade_url = langBasedURL($lang, route('user.create-business-profile'));
                $logged_in_user = auth()->guard('customers')->user() ?? null;
$lang= app()->getLocale()
@endphp
                {{-- <div class="container"><all-sponsers sponsor_become="{{ $lang }}" page_id="{{$page->id}}" logged_in_user="{{$logged_in_user}}"></all-sponsers></div> --}}

                <div class="container">
                    <all-sponsers
                        sponsor_become="{{ $lang }}"
                        page_id="{{ $page->id }}"
                        logged_in_user="{{ $logged_in_user ? $logged_in_user->toJson() : 'null' }}"
                    ></all-sponsers>
                </div>

            </section>
        </div>
    </div>
</div>
