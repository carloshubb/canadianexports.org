@extends('front.layouts.app')

@section('content')
<div class="h-full bg-gray-50">
    <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="container mx-auto px-4">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary mb-2">My Webinars</h1>
                <p class="text-gray-600">Create and manage your own webinars. Share your expertise with the community!</p>
            </div>

            <my-webinars></my-webinars>
        </div>
    </div>
</div>
@endsection

