<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a aria-label="Candian Exporters" href="/">
                <div class="mt-2 flex items-center gap-1" style="margin: 5px 0px 0px;"><img src="/assets/images/logocircle.png" class="max-w-[55px]" alt="Candian Exporters" style="width: 55px;"><img src="/assets/images/logotext.png" class="max-w-[165px]" alt="Candian Exporters" style="width: 160px;"></div>
            </a>
        </x-slot>
        <h2 class="my-2 can-exp-h2 text-primary text-center">
            {{ __('Forgot password') }}
        </h2>
        <p class="my-3 can-exp-p text-black">
            {{ __('Forgot your password? No problem') }}<br>{{ __('Just let us know your email address and we will email you a password reset link that will allow you to choose a new one') }}
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                {{-- <x-label for="email" :value="__('Email')" /> --}}

                <x-input id="email" placeholder="Enter email address" class="can-exp-input w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-button class="button-exp-fill">
                    {{ __('Email password reset link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
