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
$forget_password_setting = getI2bModalSetting(null, ['forget_password_setting']);
@endphp
    <div class="h-full bg-gray-50 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
            <div class="flex min-h-full flex-col justify-center py-4 md:py-12 px-4 sm:px-6 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-md">
                    <h3 class="can-exp-h2 text-primary text-center">
                        {{isset($forget_password_setting['header_heading']) ? $forget_password_setting['header_heading'] : ''}}
                    </h3>
                </div>
                <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-md">
                    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                        <!-- Session Status -->
                        @if (session('status'))
                            <success-message type="pre_success" message="{{ session('status') }}"></success-message>
                        @endif
                        <form class="space-y-6" method="POST" action="{{ route('web.password.reset') }}">
                            @csrf
                            <p class="mt-2 can-exp-p">
                               <pre class="font-Nunito max-w-sm text-base md:text-base lg:text-lg break-words whitespace-pre-wrap">{{isset($forget_password_setting['header_text']) ? $forget_password_setting['header_text'] : ''}}</pre>
                            </p>
                            <div>
                                {{-- <label for="email" class="block leading-6">Email
                                    address</label> --}}
                                <div class="mt-2">
                                    <input type="text"
                                        class="can-exp-input"
                                        id="email" name="email" placeholder="{{isset($forget_password_setting['email_label_text']) ? $forget_password_setting['email_label_text'] : ''}}" value="{{ old('email') }}"
                                        autofocus />

                                </div>
                                @error('email')
                                    @include('front.pages.error', ['errorMessage' => "$message"])
                                @enderror
                            </div>

                            <div class="flex items-center justify-center mt-4">
                                <button aria-label="Candian Exporters" type="submit"
                                    class="button-exp-fill">
                                    {{isset($forget_password_setting['submit_button_text']) ? $forget_password_setting['submit_button_text'] : ''}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
