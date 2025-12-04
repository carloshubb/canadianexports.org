@extends('front.layouts.app')
@section('title', 'Canadian Exports | Register your account')
@section('meta_description',
    'Canadian Exports is a Canadian export portal and a directory of Canadian exporters,
    showcasing lists of Canadian products and services, and promoting Canadian manufacturers and exporters. Canadian Exports
    is a Canadian business directory and a Canadian business database highlighting the Canadian industry')
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
    catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
    companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
    @php
    $unsubscribe_email_setting = getI2bModalSetting(null, ['unsubscribe_email_setting']);
    @endphp
@section('content')
    <div class="h-full bg-gray-50 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
            <div class="flex min-h-full flex-col justify-center py-4 md:py-12 px-4 sm:px-6 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
                    <h3 class="can-exp-h2 text-primary text-center">
                        {{isset($unsubscribe_email_setting['heading_text']) ? $unsubscribe_email_setting['heading_text'] : ''}}
                    </h3>
                </div>
                <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-2xl">
                    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                        {{-- <h3 class="can-exp-h2 text-primary text-center">
                            {{isset($unsubscribe_email_setting['header_subheading_holiday']) ? $unsubscribe_email_setting['header_subheading_holiday'] : ''}}
                        </h3>
                        <hr /> --}}
                        <!-- Session Status -->
                        @if (session('status'))
                            <success-message type="success" message="{{ session('status') }}"></success-message>
                        @endif
                        <form class="space-y-6" method="POST" action="{{ route('front.unsubscribe-holiday') }}">
                            @csrf
                            <input type="hidden" class="can-exp-input" name="q" value="{{ $_GET['q'] }}" />
                            @error('q')
                                <div>
                                    @include('front.pages.error', ['errorMessage' => "$message"])
                                </div>
                            @enderror

                            {{-- <p>
                                Are you sure you want to miss out on all the valuable updates, insights, and exclusive
                                information from our Holiday Email?
                            </p>
                            <p>

                                By clicking Unsubscribe, you’ll be removed from all our general email communications
                            </p> --}}
                            {{isset($unsubscribe_email_setting['paragraph_text']) ? $unsubscribe_email_setting['paragraph_text'] : ''}}

                            {{-- <p>

                                If you change your mind in the future, you can re-subscribe by updating your preferences on
                                our website.
                            </p> --}}

                            <div class="flex items-center justify-center mt-4">
                                <button aria-label="Candian Exporters" type="submit" class="button-exp-fill">
                                    {{-- Unsubscribe --}}
                                    {{isset($unsubscribe_email_setting['submit_button_text']) ? $unsubscribe_email_setting['submit_button_text'] : ''}}

                                </button>
                            </div>
                            {{-- <hr /> --}}
                            {{-- <p>This will not unsubscribe you from Holiday related emails</p> --}}
                            {{-- <p>{{isset($unsubscribe_email_setting['footer_holiday_text']) ? $unsubscribe_email_setting['footer_holiday_text'] : ''}}</p> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
