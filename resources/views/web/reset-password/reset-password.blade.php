<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a aria-label="Candian Exporters" href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        
        <form method="POST" action="{{ route('user.password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)"
                    required autofocus />
                @error('email')
                    @include('front.pages.error', ['errorMessage' => "$message"])
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <reset-password-input id="password" name="password"></reset-password-input>
                @error('password')
                    @include('front.pages.error', ['errorMessage' => "$message"])
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm password')" />

                <reset-password-input id="password_confirmation" name="password_confirmation"></reset-password-input>
                @error('password_confirmation')
                    @include('front.pages.error', ['errorMessage' => "$message"])
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
