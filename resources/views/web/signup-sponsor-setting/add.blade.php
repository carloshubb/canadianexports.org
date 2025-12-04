@extends('front.layouts.app')
@section('title', 'Canadian Exports | Add New Sponsorship')
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
                    <div class="bg-white mt-10 py-8 px-4 sm:px-10">
                        @php
                            $langAbbr = app()->getLocale() ?? 'en';
                            $sponsorSettingsUrl = "/{$langAbbr}/user/sponsor-settings";
                        @endphp
                        <add-sponsorship-form 
                            sponsor-settings-url="{{ $sponsorSettingsUrl }}"
                            logged-in-user="{{ json_encode(auth()->guard('customers')->user()) }}"
                        ></add-sponsorship-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

