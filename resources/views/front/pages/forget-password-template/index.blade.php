@isset($forgetPageSettingDetail)
    <div class="h-full bg-gray-50 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
            <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
                <div class="mt-2 w-11/12 mx-auto sm:max-w-md">
                    <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">
                        <!-- Session Status -->
                        @if (session('status'))
                            <success-message type="success" message="{{ session('status') }}"></success-message>
                        @endif
                        <form class="space-y-6" method="POST" action="{{ route('web.password.reset') }}">
                            <input type="hidden" name="page_id" value="{{ $page->id }}" />
                            @csrf
                            <p class="mt-2 can-exp-p">{{ $forgetPageSettingDetail->body_text }}</p>
                            <div>
                                {{-- <label for="email" class="block leading-6">Email
                                address</label> --}}
                                <div class="mt-2">
                                    <input type="text" class="can-exp-input" id="email" name="email"
                                        placeholder="{{ $forgetPageSettingDetail->email_label }}"
                                        value="{{ old('email') }}"  autofocus />

                                </div>
                                @error('email')
                                    @include('front.pages.error', ['errorMessage' => "$message"])
                                @enderror
                            </div>

                            <div class="flex items-center justify-center mt-4">
                                <button aria-label="Candian Exporters" type="submit"
                                    class="button-exp-fill">{{ $forgetPageSettingDetail->button_text }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endisset
