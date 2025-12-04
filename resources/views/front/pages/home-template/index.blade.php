@isset($homePageSettingDetail)
    @if (session('status'))
        <success-message type="{{ session('status') }}" message="{{ session('message') }}"></success-message>
    @endif
    @include('front.pages.home-template.slider')
    @include('front.pages.home-template.slider-banner')
    @include('front.pages.home-template.business-categories')
    @include('front.pages.home-template.business-categories-banner')
    @include('front.pages.home-template.sponsors')
    @include('front.pages.home-template.sponsors-banner')
    @include('front.pages.home-template.featured-businesses', ['lang' => $lang])
    @include('front.pages.home-template.featured-businesses-banner')
    @include('front.pages.home-template.featured-events')
    @include('front.pages.home-template.featured-events-banner')
    @include('front.pages.home-template.I2C')
    @include('front.pages.home-template.I2C-banner')
    @include('front.pages.home-template.canadian-exports-magazine')
    @include('front.pages.home-template.canadian-exports-magazine-banner')
@endisset
