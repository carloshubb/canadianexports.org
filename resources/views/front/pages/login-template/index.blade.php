@isset($loginPageSettingDetail)
    <div class="h-full bg-gray-50">
        <div class="py-16">
            <div class="flex min-h-full flex-col justify-center py-4 md:py-12 px-6 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-md">
                    <h3 class="can-exp-h2 text-primary"> {!! $loginPageSettingDetail->main_heading !!}</h3>
                </div>


                @if (session('status'))
                    <success-message type="{{ session('status') }}" message="{{ session('message') }}"></success-message>
                @endif

                <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-md">
                    <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">
                        <div class="">
                            <p class="text-red-500 whitespace-nowrap">
                                <span class="text-red-500">*</span>
                                {{ $loginPageSettingDetail->required_fields_text }}</p>
                        </div>
                        <form class="space-y-6" method="POST" action="{{ route('web.user.login') }}">
                            @csrf
                            <input type="hidden" value="{{ $page->id }}" name="page_id" />
                            {{-- Session Status --}}
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div>
                                <label for="email"
                                    class="block text-base md:text-base lg:text-lg font-Nunito leading-6 text-gray-900">{!! $loginPageSettingDetail->email_label !!} <span class="text-red-500">*</span></label>
                                <div class="mt-2">
                                    <input type="text" class="can-exp-input" id="email" name="email" placeholder=""
                                        value="{{ old('email') }}" autofocus />
                                    <p class="mt-1 text-sm text-gray-500" id="email-description">{!! $loginPageSettingDetail->email_help !!}</p>
                                </div>
                                @error('email')
                                    @include('front.pages.error', ['errorMessage' => "$message"])
                                @enderror
                            </div>

                            <div>
                                <label for="password"
                                    class="block text-base md:text-base lg:text-lg font-Nunito leading-6 text-gray-900">{!! $loginPageSettingDetail->password_label !!} <span class="text-red-500">*</span></label>
                                <login-password-input lang="{{ $lang }}"></login-password-input>
                                @error('password')
                                    @include('front.pages.error', ['errorMessage' => "$message"])
                                @enderror
                            </div>
                                @error('credentials')
                                    <div class="relative tooltip -bottom-4 group-hover:flex">
                                        <div role="tooltip" class="relative tooltiptext -top-2 z-0 leading-none transition duration-150 ease-in-out shadow-lg py-2 pr-5 pl-3 bg-primary text-gray-600 rounded w-fit">
                                            <span class="text-white leading-none py-2 text-base md:text-base lg:text-lg text-left">
                                                    {{$message}}
                                            </span>
                                        </div>
                                    </div>
                                @enderror
                            <div
                                class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between gap-4">
                                <div class="flex items-start">
                                    <input id="remember-me" name="remember-me" type="checkbox"
                                        class="h-4 w-4 mt-0.5 rounded border-gray-300 text-primary focus:ring-primary">
                                    <label for="remember-me"
                                        class="ml-2 block text-sm md:text-sm lg:text-base text-gray-900">{!! $loginPageSettingDetail->remeber_me_label !!}</label>
                                </div>
                                @php
                                    $url = route('web.password.request');
                                    $url = langBasedURL($lang, $url);
                                @endphp

                                <div class="text-sm">
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="text-sm md:text-sm lg:text-base text-primary hover:text-indigo-500">{!! $loginPageSettingDetail->forgot_password_text !!}</a>
                                </div>
                            </div>

                            <div class="text-center">
                                <button aria-label="Candian Exporters" type="submit" class="button-exp-fill">{!! $loginPageSettingDetail->signin_btn_text !!}</button>
                            </div>
                            <div class="flex justify-center">
                                {!! $loginPageSettingDetail->signup_btn_text !!}
                            </div>
                        </form>
                    </div>
                    <div class="rounded-md p-3 mt-6 shadow bg-white">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="#2563eb" class="bi bi-shield-shaded w-5 h-5" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 14.933a.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067v13.866zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z">
                                </path>
                            </svg>
                            <p class="can-exp-p"> {!! $loginPageSettingDetail->protect_account_heading !!}</p>
                        </div>
                        <div class="mt-2 can-exp-p">
                            <p> {!! $loginPageSettingDetail->protect_account_description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endisset
