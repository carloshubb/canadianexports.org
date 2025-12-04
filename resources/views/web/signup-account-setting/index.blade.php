@extends('front.layouts.app')
@section('title', 'Canadian Exports | Register your account')
@section('meta_description',
    'Canadian Exports is a Canadian export portal and a directory of Canadian exporters,
    showcasing lists of Canadian products and services, and promoting Canadian manufacturers and exporters. Canadian Exports
    is a Canadian business directory and a Canadian business database highlighting the Canadian industry')
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
    catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
    companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
@section('content')
    <div class="bg-gray-50">
        <div class="py-10">
            <div class="container mx-auto flex min-h-full flex-col justify-center">
                <div class="">
                    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                        <h2 class="can-exp-h1"></h2>
                        @php
                            $page_id = getLatestRegPageId();
                            $user->package_expiry_date = date('m/d/Y', strtotime($user->package_expiry_date));
                        @endphp
                        @if (session('status'))
                            <success-message type="{{ session('status') }}"
                                message="{{ session('message') }}"></success-message>
                        @endif
                        <user-profile page_id="{{ $page_id }}" profile='1' user="{{ $user }}"></user-profile>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
