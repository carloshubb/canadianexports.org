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
                <div class="mt-20">
                    <div class="bg-white py-8 px-4 sm:px-10">
                        <h1 class="font-FuturaMdCnBT text-2xl md:text-3xl text-gray-900 mb-4">{{ __('Your Sponsor Profile') }}</h1>
                        <p class="text-gray-600 mb-6" style="margin-top: 60px;" >{{ __('Welcome to your command center. Everything you share here helps Canadian exporters and international buyers find you. You can update your company details, media, and contact information at any time to keep your profile fresh and engaging.') }}</p>

                        {{-- Edit specific sponsorship --}}
                        <sponsor-profile-edit :sponsorship-id="{{ $id }}"></sponsor-profile-edit>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

