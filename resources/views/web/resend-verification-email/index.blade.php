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
@php
$resend_email_verification_setting = getI2bModalSetting(null, ['resend_email_verification_setting']);
@endphp
    <div class="h-full bg-gray-50 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
            <div class="flex min-h-full flex-col justify-center py-4 md:py-12 px-4 sm:px-6 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-md">
                    <h3 class="can-exp-h2 text-primary text-center">
                        {{isset($resend_email_verification_setting['header_heading']) ? $resend_email_verification_setting['header_heading'] : ''}}
                    </h3>
                </div>
                <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-md">
                    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                        <!-- Session Status -->
                        @if (session('status'))
                            <success-message type="success" message="{{ session('status') }}"></success-message>
                        @endif
                        <form class="space-y-6" method="POST" action="{{ route('web.resend-verification-email.reset') }}">
                            @csrf
                            <p class="mt-2 can-exp-p">
                                {{isset($resend_email_verification_setting['header_text']) ? $resend_email_verification_setting['header_text'] : ''}}
                            </p>
                            <div>
                                {{-- <label for="email" class="block leading-6">Email
                                    address</label> --}}
                                <div class="mt-2">
                                    <input type="text"
                                        class="can-exp-input"
                                        id="email" name="email" placeholder="{{isset($resend_email_verification_setting['email_label_text']) ? $resend_email_verification_setting['email_label_text'] : ''}}" value="{{ old('email') }}"
                                        autofocus />

                                </div>
                                @error('email')
                                    @include('front.pages.error', ['errorMessage' => "$message"])
                                @enderror
                            </div>

                            <div class="flex items-center justify-center mt-4">
                                <button aria-label="Candian Exporters" type="submit"
                                    class="button-exp-fill">
                                    {{isset($resend_email_verification_setting['submit_button_text']) ? $resend_email_verification_setting['submit_button_text'] : ''}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
