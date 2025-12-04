<x-web-layout>
    <x-slot:title>
        Home | Canadian Export
    </x-slot>
    <x-slot:styles>
        <link rel="stylesheet" href="{{ asset('plugins/swiper/swiper-bundle.min.css') }}" />
    </x-slot>
    @include('web.home.slider')
    <section class="px-4 py-6 md:p-12 desktop:px-80">
        <h2 class="can-exp-h1 text-center">Welcome to Canadian Exports business
            portal</h2>
        <p class="mb-6 lg:text-xl">
            Our mission is to promote Canadian Exports and help Canadian companies find buyers and distributors
            for their products and services. Our Canadian exports magazine, The export promotion magazine of
            Canada, reaches more than 100,000 importers and buyers in over 120 countries. <span
                class="text-primaryRed">Online Registration </span> takes only a couple of minutes
        </p>
        @include('web.home.business-categories')
    </section>
    @include('web.home.inquiries-to-buy')
    @include('web.home.sponsors')
    @include('web.home.featured-exporters')
    @include('web.home.events')
    @include('web.home.canadian-export-magazine')

    <x-slot:scripts>
        @include('web.home.scripts')
    </x-slot>
</x-web-layout>
