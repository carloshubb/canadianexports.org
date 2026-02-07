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
                <!--* Indicates required fields -->
                <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-md">
                    <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">
                        <div class="">
                            <p class="text-red-500 whitespace-nowrap">
                                <span class="text-red-500">*</span>
                                {{ $loginPageSettingDetail->required_fields_text }}</p>
                        </div>
                        <form class="space-y-6" method="POST" action="{{ route('web.user.login') }}" autocomplete="on">
                            @csrf
                            <input type="hidden" value="{{ $page->id }}" name="page_id" />
                            {{-- Session Status --}}
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div>
                                <label for="email"
                                    class="block text-base md:text-base lg:text-lg font-Nunito leading-6 text-gray-900">{!! $loginPageSettingDetail->email_label !!} <span class="text-red-500">*</span></label>
                                <div class="mt-2">
                                    <input type="email" class="can-exp-input" id="email" name="email" placeholder=""
                                        value="{{ old('email') }}" autocomplete="username" autofocus />
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
                                    <input id="remember-me" name="remember" type="checkbox" value="1"
                                        class="h-4 w-4 mt-0.5 rounded border-gray-300 text-primary focus:ring-primary">
                                    <label for="remember-me"
                                        class="ml-2 block text-sm md:text-sm lg:text-base text-gray-900">{!! $loginPageSettingDetail->remeber_me_label !!}</label>
                                </div>
                                @php
                                    $url = route('web.password.request');
                                    $url = langBasedURL($lang, $url);
                                @endphp

                                <div class="text-sm">
                                    <a aria-label="{{ __('Canadian Exporters') }}" href="{{ $url }}"
                                        class="text-sm md:text-sm lg:text-base text-primary hover:text-indigo-500">{!! $loginPageSettingDetail->forgot_password_text !!}</a>
                                </div>
                            </div>

                            <div class="text-center">
                                <button aria-label="{{ __('Canadian Exporters') }}" type="submit" class="button-exp-fill">{!! $loginPageSettingDetail->signin_btn_text !!}</button>
                            </div>
                            <div class="flex justify-center">
                                {!! $loginPageSettingDetail->signup_btn_text !!}
                            </div>
                        </form>
                    </div>
                    <div class="rounded-md p-3 mt-6 shadow bg-white">
                        <div class="flex items-center gap-2">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="#2563eb" class="bi bi-shield-shaded w-5 h-5" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 14.933a.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067v13.866zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z">
                                </path>
                            </svg> --}}
                            <svg height="18" width="18" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                viewBox="0 0 392.517 392.517" xml:space="preserve">
                            <path style="fill:#56ACE0;" d="M353.834,84.962c-0.065-6.012-4.784-11.184-11.507-11.184c0.388,0,0.776,0,0,0
                                c-69.495,1.487-116.752-30.707-138.861-49.002c-4.202-3.491-10.343-3.491-14.545,0c-22.626,18.747-71.37,50.618-138.473,49.002l0,0
                                c-7.176,0.517-11.313,4.202-11.83,11.184c0.065,72.275,15.321,244.622,154.699,284.897c1.875,0.517,3.943,0.517,5.818,0
                                C338.578,329.584,353.77,157.172,353.834,84.962z"/>
                            <path style="fill:#194F82;" d="M341.422,51.41c-59.992,1.487-103.37-27.022-123.733-43.895c-12.154-10.02-30.966-10.02-43.055,0
                                C154.4,24.388,111.022,52.962,51.03,51.41h-0.84c-19.717,0.323-33.293,15.127-33.875,33.552
                                c0,77.382,16.873,261.883,170.796,306.295c6.723,1.681,12.8,1.681,18.166,0c153.988-44.412,170.861-228.978,170.925-306.295
                                C376.202,66.99,361.915,51.087,341.422,51.41z M193.382,369.859C53.875,329.584,38.683,157.172,38.618,84.962
                                c0.517-7.046,4.655-10.602,11.83-11.184l0,0c67.103,1.552,115.846-30.19,138.473-49.002c4.202-3.491,10.343-3.491,14.545,0
                                c22.174,18.295,69.495,50.489,138.861,49.002c0.776,0,0.388,0,0,0c6.723,0,11.442,5.172,11.507,11.184
                                c-0.065,72.275-15.321,244.622-154.699,284.897C197.261,370.376,195.127,370.376,193.382,369.859z"/>
                            <path style="fill:#FFC10D;" d="M185.042,186.327V80.372c-29.737,18.683-61.737,30.707-95.224,35.556
                                c-5.883,0.84-10.02,6.206-9.503,12.154c1.939,20.493,5.107,40.016,9.568,58.182h95.095v0.065H185.042z"/>
                            <g>
                                <path style="fill:#FFFFFF;" d="M185.042,319.952V208.566H96.154C113.996,264.291,143.863,301.592,185.042,319.952z"/>
                                <path style="fill:#FFFFFF;" d="M302.958,115.992c-33.616-4.848-65.681-16.873-95.612-35.62v105.891h95.677
                                    c4.396-18.23,7.564-37.689,9.374-58.182C312.913,122.198,308.84,116.832,302.958,115.992z"/>
                            </g>
                            <path style="fill:#FFC10D;" d="M207.345,208.566v111.451c41.632-18.36,71.693-55.79,89.471-111.451L207.345,208.566L207.345,208.566
                                z"/>
                            <g>
                                <path style="fill:#194F82;" d="M342.327,73.713L342.327,73.713C341.164,73.713,341.81,73.713,342.327,73.713z"/>
                                <path style="fill:#194F82;" d="M306.125,93.883c-32.194-4.719-62.966-16.614-91.475-35.362c-10.99-7.24-25.859-7.24-36.848,0
                                    c-28.444,18.747-59.087,30.707-91.152,35.297c-17.648,2.651-30.125,18.554-28.444,36.331
                                    c6.012,64.129,30.384,177.131,125.931,213.527c7.628,2.844,15.774,2.715,24.242,0c96.517-36.655,120.566-149.592,126.255-213.657
                                    C336.25,112.372,323.709,96.469,306.125,93.883z M185.042,319.952c-47.192-21.01-74.02-64.388-88.954-111.127h88.954V319.952z
                                    M185.042,186.457h-95.16c-4.784-19.846-7.822-39.822-9.503-58.44c-0.517-5.947,3.62-11.313,9.503-12.154
                                    c33.487-4.913,65.422-17.002,95.224-35.685v106.279H185.042z M207.345,320.016V208.824h89.535
                                    C282.012,255.564,255.119,299.006,207.345,320.016z M303.087,186.457h-95.741V80.307c29.802,18.747,61.996,30.836,95.612,35.685
                                    c5.883,0.84,10.02,6.206,9.503,12.024C310.715,146.699,307.871,166.61,303.087,186.457z"/>
                            </g>
                            </svg>
                            <p class="can-exp-p" style="color: #187cbe; font-family: 'Futura BdCn BT'; font-size: 14pt;"> {!! $loginPageSettingDetail->protect_account_heading !!}</p>
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
