@extends('front.layouts.app')
@php
$mediaId = getSignleGeneralSettingByKey(['facebook_meta_image']);
$facebook = isset($mediaId) ? getMediaById($mediaId) : null;
$facebook = isset($facebook) ? asset($facebook->path) : null;
@endphp

@php
$meta_desc = null;
@endphp
@section('title', 'Canadian Exports | Canadian Products and Services')
@section('meta_description', $meta_desc)
@section('facebook_meta_image', isset($facebook) ? $facebook : null)
@section('twitter_meta_image', isset($facebook) ? $facebook : null)
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
@section('content')
@php
$languages = getAllLanguages();
$coffee_wall_setting = getI2bModalSetting($lang, ['coffee_wall_setting']);
$payment_setting = getI2bModalSetting($lang, ['payment_setting']);
@endphp

<div class="h-full bg-gray-50">
    <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <section class="">
                <div class="grid grid-cols-1 gap-12 mx-auto container">
                    <div class="order-2 md:order-1">
                        <create-coffee-wall coffee_wall_setting="{{ $coffee_wall_setting }}"
                            languages="{{ $languages }}" lang="{{ $lang }}"
                            submit_url="{{ route('coffee_on_wall.store') }}"
                            payment_setting="{{ $payment_setting }}"></create-coffee-wall>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection