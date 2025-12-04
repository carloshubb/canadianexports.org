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
    @if ($request->route('abbreviation') != null)
        @php
            updateLangByAbber($request->route('abbreviation'));
        @endphp
    @endif
    @php
        $lang = getDefaultLanguage(true);
        $reset_password_setting = getI2bModalSetting(null, ['reset_password_setting']);
    @endphp
    <div class="h-full bg-gray-50 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
            <div class="flex min-h-full flex-col justify-center py-4 md:py-12 px-4 sm:px-6 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-md">
                    <h3 class="can-exp-h2 text-primary text-center">
                        {{isset($reset_password_setting['header_heading']) ? $reset_password_setting['header_heading'] : ''}}
                    </h3>
                </div>
                <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-md">
                    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                        <!-- Session Status -->
                        @if (session('status'))
                            <success-message type="success" message="{{ session('status') }}"></success-message>
                        @endif
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            @isset($_GET['validity'])
                                <input type="hidden" name="validity" value="{{ $_GET['validity'] }}">
                            @endisset

                            <!-- Email Address -->
                            <div>
                                <x-label for="email" value="{{ $reset_password_setting['email_label_text'] }}" />

                                <x-input id="email" class="block mt-1 w-full" type="text" name="email"
                                    :value="old('email', $request->email)" autofocus />
                                @error('email')
                                    @include('front.pages.error', ['errorMessage' => "$message"])
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-label for="password" value="{{ $reset_password_setting['password_text'] }}" />

                                <reset-password-input lang="{{ $lang }}" id="password"
                                    name="password"></reset-password-input>
                                @error('password')
                                    @include('front.pages.error', ['errorMessage' => "$message"])
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-label for="password_confirmation"
                                    value="{{ $reset_password_setting['confirm_password_text'] }}" />

                                <reset-password-input lang="{{ $lang }}" id="password_confirmation"
                                    name="password_confirmation"></reset-password-input>
                                @error('password_confirmation')
                                    @include('front.pages.error', ['errorMessage' => "$message"])
                                @enderror
                            </div>

                            <div class="flex items-center justify-center mt-4">
                                <x-button>{{ $reset_password_setting['submit_button_text'] }}</x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
