@extends('front.layouts.app')

@section('content')
<div class="h-full bg-gray-50">
    {{-- pt-[7.5rem] clears the fixed navbar #topnav (h-[120px]) --}}
    <div class="pt-[7.5rem] lg:pb-14 md:pb-10 pb-10">
        <div class="container mx-auto px-4">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary mb-2">{{ __('My Webinars') }}</h1>
                <p class="text-gray-600">{{ __('Create and manage your own webinars. Share your expertise with the community!') }}</p>
            </div>

            <my-webinars></my-webinars>
        </div>
    </div>
</div>
@endsection

