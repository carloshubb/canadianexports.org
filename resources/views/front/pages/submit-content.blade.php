@extends('front.layouts.app')
@section('title', 'Submit Content | Canadian Exports')
@section('content')
<div class="h-full bg-gray-50">
    <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="container mx-auto px-4">
            <submit-content
                :event-create-url="'{{ addslashes($eventCreateUrl ?? '#') }}'"
                :my-webinars-url="'{{ addslashes($myWebinarsUrl ?? '#') }}'"
            ></submit-content>
        </div>
    </div>
</div>
@endsection
