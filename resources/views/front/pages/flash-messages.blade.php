@extends('front.layouts.app')
@section('title', 'Canadian Exports | Canadian Products and Services')
@section('meta_description',
    'Canadian Exports is a Canadian export portal and a directory of Canadian exporters,
    showcasing lists of Canadian products and services, and promoting Canadian manufacturers and exporters. Canadian Exports
    is a Canadian business directory and a Canadian business database highlighting the Canadian industry')
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
    catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
    companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
@section('content')
    <section class="relative md:py-8 py-4">

        <div class="container md:mt-16 mt-4 pt-4">
            <div class="relative grid grid-cols-1 pb-8">
                @if (Session::has('message'))
                    <h3 class="text-center can-exp-h1">{{ Session::get('message') }}</h3>
                @endif
            </div>

            @php
                $url = isset($general_setting['user_signin_page']) ? route('front.index', $general_setting['user_signin_page']) : '#';
                $url = langBasedURL(null, $url);
            @endphp

            <div class="flex items-center justify-center">
                <a href="{{$url}}" aria-label="Candian Exporters" type="button" class="button-exp-fill">
                    Log in to your profile
                </a>
            </div>


        </div>
    </section>
@endsection
