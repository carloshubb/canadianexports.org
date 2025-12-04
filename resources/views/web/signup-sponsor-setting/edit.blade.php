@extends('front.layouts.app')
@section('title', 'Canadian Exports | Edit Sponsorship')
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
                @if (Session::has('type') &&
                        Session::get('type') == 'success' &&
                        Session::has('message') &&
                        Session::get('message') != '')
                    <message type="{{ Session::get('type') }}" message="{{ Session::get('message') }}"></message>
                @endif
                <div class="">
                    <div class="bg-white py-8 px-4 sm:px-10">
                        {{-- Back button --}}
                        <div class="mb-4">
                            @php
                                $langAbbr = app()->getLocale() ?? 'en';
                                $backUrl = "/{$langAbbr}/user/sponsor-settings";
                            @endphp
                            <a href="{{ $backUrl }}" class="text-primary hover:text-primary/80 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Sponsorships List
                            </a>
                        </div>
                        
                        {{-- Edit specific sponsorship --}}
                        <sponsor-profile-edit :sponsorship-id="{{ $id }}"></sponsor-profile-edit>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

