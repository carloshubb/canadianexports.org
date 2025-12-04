@extends('front.layouts.app')
@section('title', 'Canadian Exports | Register your account')
@section('meta_description', 'Canadian Exports is a Canadian export portal and a directory of Canadian exporters,
    showcasing lists of Canadian products and services, and promoting Canadian manufacturers and exporters. Canadian Exports
    is a Canadian business directory and a Canadian business database highlighting the Canadian industry')
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
    catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
    companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
@section('content')
    <div class="h-full bg-gray-50 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
            <div class="flex min-h-full flex-col justify-center py-4 md:py-12 px-4 sm:px-6 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-md">
                    <h2 class="mt-6 text-center can-exp-h1">Sign in to your account</h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Or
                        <a aria-label="Candian Exporters" href="{{ route('front.index', 'signup') }}"
                            class="font-medium text-primary hover:text-indigo-500">Register your Business profile</a>
                    </p>
                </div>

                <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-md">
                    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                        <form class="space-y-6" method="POST" action="{{ route('web.user.login') }}">
                            @csrf
                            {{-- Session Status --}}
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            {{-- Validation Errors --}}
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <div>
                                <label for="email" class="block leading-6">Email address</label>
                                <div class="mt-2">
                                    <input type="email" class="can-exp-input" id="email" name="email" placeholder=""
                                        value="{{ old('email') }}" required autofocus />
                                    <p class="mt-1 text-sm text-gray-500" id="email-description">We'll never share your
                                        email with anyone else</p>
                                </div>
                            </div>

                            <div>
                                <label for="password" class="block leading-6">Password</label>
                                <div class="mt-2">
                                    <input class="can-exp-input" id="password" type="password" name="password" required
                                        autocomplete="current-password" />
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember-me" name="remember-me" type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                                </div>
                                @php
                                    $url = route('web.password.request');
                                    $url = langBasedURL($lang, $url);
                                @endphp
                                <div class="text-sm">
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="font-medium text-primary hover:text-indigo-500">Forgot your password?</a>
                                </div>
                            </div>

                            <div>
                                <button aria-label="Candian Exporters" type="submit"
                                    class="flex font-Futura btn bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-full shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">Sign
                                    in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
