<x-guest-layout>
<div class="h-screen">
    <div class="relative isolate overflow-hidden bg-white rounded-md h-full flex justify-center items-center">
        <img src="https://images.unsplash.com/photo-1490623970972-ae8bb3da443e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&crop=focalpoint&fp-y=.8&w=2830&h=1500&q=80" alt="Candian Exporters" class="absolute inset-0 -z-10 h-full w-full object-cover">
        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
          <svg viewBox="0 0 1266 975" aria-hidden="true" class="absolute -bottom-8 -left-96 -z-10 w-[79.125rem] transform-gpu blur-3xl sm:-left-40 sm:-bottom-64 lg:left-8 lg:-bottom-32 xl:-left-10">
            <path fill="url(#05f95398-6ec0-404d-8f7d-a69a4504684d)" fill-opacity=".2" d="M347.52 746.149 223.324 974.786 0 630.219l347.52 115.93 223.675-411.77c1.431 190.266 49.389 498.404 229.766 208.829C1026.43 181.239 966.307-135.484 1129.51 59.422c130.55 155.925 143.15 424.618 133.13 539.473L936.67 429.884l23.195 520.539L347.52 746.149Z" />
            <defs>
              <linearGradient id="05f95398-6ec0-404d-8f7d-a69a4504684d" x1="1265.86" x2="-162.888" y1=".254" y2="418.947" gradientUnits="userSpaceOnUse">
                <stop stop-color="#776FFF" />
                <stop offset="1" stop-color="#FF4694" />
              </linearGradient>
            </defs>
          </svg>
          <div class="mx-auto max-w-2xl lg:max-w-xl">
            <div class="flex min-h-full flex-col justify-center py-4 md:py-12 px-4 sm:px-6 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-md">
                    <img src="{{asset('assets/images/logo.png')}}" class="l-light text-center mx-auto" alt="Candian Exporters">
                  <h2 class="mt-6 text-center can-exp-h2 text-primary">Sign in to your account</h2>
                </div>

                <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-xl md:min-w-[26rem]">
                  <div class="bg-white py-8 px-4 shadow rounded-md sm:px-10">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form class="space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf
                      <div>
                        <label for="email" class="block text-md leading-6 text-gray-900">Email address</label>
                        <div class="mt-2">
                            <input id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" type="email" name="email" value="{{old('email')}}" required autofocus />
                        </div>
                      </div>

                      <div>
                        <label for="password" class="block text-md leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" id="password" type="password" name="password" required autocomplete="current-password" />
                        </div>
                      </div>

                      <div class="flex items-center justify-between flex-col sm:flex-col md:flex-row lg:flex-row">
                        <div class="flex items-center">
                          <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                          <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                        </div>

                        <div class="text-sm">
                            {{-- @if (Route::has('password.request'))
                            <a tabindex="-1" href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-indigo-500 text-sm md:text-base">Forgot your password?</a>
                            @endif --}}
                            @if (Route::has('password.request'))
                            <a aria-label="Candian Exporters" tabindex="-1" href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-indigo-500 text-sm md:text-base ">Forgot your password?</a>
                            @endif
                        </div>
                      </div>

                      <div>
                        <button aria-label="Candian Exporters" class="button-exp-fill flex w-full justify-center" type="submit" id="submit-btn">
                            Log in
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>

</x-guest-layout>
