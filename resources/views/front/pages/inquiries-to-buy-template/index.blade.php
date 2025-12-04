@isset($homePageSettingDetail)
    @php
        $advSearchSetting = getI2bModalSetting($lang, ['advance_search']);
    @endphp
    <div class="h-full bg-gray-50 ">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 ">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section class="">
                    @isset($page->pageDetail[0])
                        <div class="">
                            @php
                                $page_detail = $page->pageDetail[0]->page_detail;
                            @endphp
                            @include('front.pages.widgets.render-widget-with-detail', [
                                'page_detail' => $page_detail,
                            ])
                        </div>
                    @endisset
                    <div class="container">
                        @php
                            $url = route('user.search.i2BSearch');
                            $url = langBasedURL(null, $url);
                        @endphp
                        <form method="get" action="{{ $url }}">
                            <input type="hidden" name="page_id" value="{{ $page->id }}" />
                            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4 items-end">
                                <div class="relative w-full mb-3">
                                    <label class="mb-2 text-primary text-base md:text-base lg:text-lg font-medium"
                                        for="">{{ isset($i2BSettingDetail['search_label']) ? $i2BSettingDetail['search_label'] : '' }}</label>
                                    <input type="text" class="can-exp-input py-1.5"
                                        placeholder="{{ isset($i2BSettingDetail['search_placeholder']) ? $i2BSettingDetail['search_placeholder'] : '' }}"
                                        id="search" name="search"
                                        value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                                    @error('search')
                                        @include('front.pages.error', [
                                            'errorMessage' => "$message",
                                        ])
                                    @enderror
                                </div>

                                @php
                                    $businessCategories = getAllBusinessCategories();
                                @endphp

                                <div class="relative w-full mb-3">
                                    <label class="mb-2 text-primary text-base md:text-base lg:text-lg font-medium"
                                        for="">{{ isset($i2BSettingDetail['business_categories_label']) ? $i2BSettingDetail['business_categories_label'] : '' }}</label>
                                    <select
                                        class="js-example-basic-multiple appearance-none w-full can-exp-input pr-8 category-options"
                                        id="business-categories-select" name="business-categories[]" multiple="multiple">

                                        @php
                                            $selectedBusinessCategories = null;
                                        @endphp
                                        @if (isset($_GET['business-categories']) && in_array('all', $_GET['business-categories']))
                                            @php
                                                $selectedBusinessCategories = 'selected';
                                            @endphp
                                        @endif
                                        <option value="all"
                                            {{ $selectedBusinessCategories || !isset($_GET['business-categories']) ? 'selected' : '' }}>
                                            {{ isset($i2BSettingDetail['business_categories_all_text']) ? $i2BSettingDetail['business_categories_all_text'] : '' }}
                                        </option>
                                        @foreach ($businessCategories as $businessCategory)
                                            @php
                                                $selectedBusinessCategories = '';
                                            @endphp
                                            @if (isset($_GET['business-categories']) && in_array($businessCategory->id, $_GET['business-categories']))
                                                @php
                                                    $selectedBusinessCategories = 'selected';
                                                @endphp
                                            @endif
                                            <option value="{{ $businessCategory->id }}" {{ $selectedBusinessCategories }}>
                                                @php
                                                    $businessCategoryName = strtolower($businessCategory->category_name);
                                                    $businessCategoryName = ucwords($businessCategoryName);
                                                @endphp

                                                {{ $businessCategoryName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('business-categories')
                                        @include('front.pages.error', [
                                            'errorMessage' => "$message",
                                        ])
                                    @enderror
                                </div>

                                @php
                                    $countries = getAllCountriesFromI2b($lang);
                                @endphp

                                <div class="relative w-full mb-3">
                                    <label class="mb-2 text-primary text-base md:text-base lg:text-lg font-medium"
                                        for="">{{ isset($i2BSettingDetail['country_label']) ? $i2BSettingDetail['country_label'] : '' }}</label>
                                    <select
                                        class="js-example-basic-multiple appearance-none w-full can-exp-input pr-8 category-options"
                                        id="countries-select" name="countries[]" multiple="multiple">

                                        @php
                                            $selectedCountries = null;
                                        @endphp
                                        @if (isset($_GET['countries']) && in_array('all', $_GET['countries']))
                                            @php
                                                $selectedCountries = 'selected';
                                            @endphp
                                        @endif
                                        <option value="all"
                                            {{ $selectedCountries || !isset($_GET['countries']) ? 'selected' : '' }}>
                                            {{ isset($i2BSettingDetail['country_all_text']) ? $i2BSettingDetail['country_all_text'] : '' }}
                                        </option>
                                        @foreach ($countries as $country)
                                            @php
                                                $selectedCountries = '';
                                            @endphp
                                            @if (isset($_GET['countries']) && in_array($country, $_GET['countries']))
                                                @php
                                                    $selectedCountries = 'selected';
                                                @endphp
                                            @endif
                                            <option value="{{ $country }}" {{ $selectedCountries }}>
                                                @php
                                                    $countryName = strtolower($country);
                                                    $countryName = ucwords($countryName);
                                                @endphp

                                                {{ $countryName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('countries')
                                        @include('front.pages.error', [
                                            'errorMessage' => "$message",
                                        ])
                                    @enderror
                                </div>

                                <div class="relative w-full mb-3">
                                    <label class="mb-2 text-primary text-base md:text-base lg:text-lg font-medium"
                                        for="">{{ isset($advSearchSetting['i2b_sorting_order_label']) ? $advSearchSetting['i2b_sorting_order_label'] : '' }}</label>
                                    <select class="block appearance-none can-exp-input pr-8 py-1.5" name="sorting" id="sorting">

                                        @php
                                            $sortingSelected = isset($_GET['sorting']) ? $_GET['sorting'] : 'a-z';
                                        @endphp
                                        <option value="a-z" {{ $sortingSelected == 'a-z' ? 'selected' : '' }}>
                                            {{ isset($advSearchSetting['alphabetical_order_a_z']) ? $advSearchSetting['alphabetical_order_a_z'] : '' }}
                                        </option>
                                        <option value="z-a" {{ $sortingSelected == 'z-a' ? 'selected' : '' }}>
                                            {{ isset($advSearchSetting['alphabetical_order_z_a']) ? $advSearchSetting['alphabetical_order_z_a'] : '' }}
                                        </option>
                                        <option value="include-expired"
                                            {{ $sortingSelected == 'include-expired' ? 'selected' : '' }}>
                                            {{ isset($advSearchSetting['include_expired']) ? $advSearchSetting['include_expired'] : '' }}
                                        </option>
                                    </select>
                                    @error('countries')
                                        @include('front.pages.error', [
                                            'errorMessage' => "$message",
                                        ])
                                    @enderror
                                </div>

                            </div>
                            <div class="relative w-full mb-3 flex justify-center">
                                <button aria-label="Candian Exporters" type="submit"
                                    class="button-exp-fill">{{ isset($i2BSettingDetail['search_button_text']) ? $i2BSettingDetail['search_button_text'] : '' }}</button>
                            </div>
                        </form>

                        @php
                            $i2b_setting = getI2BSetting($lang, $page);
                            $inquiries = getAllInquiries(30, $lang);
                            $loginPageSlug = $general_setting['user_signin_page'];
                            $page = getPageBySlug($loginPageSlug, $lang);
                            $loginPageSetting = getLoginPageSetting($lang, $page);
                            $loginPageSettingDetail = isset($loginPageSetting->loginPageSettingDetail[0]) ? $loginPageSetting->loginPageSettingDetail[0] : null;
                            $register_url = isset($general_setting['user_signup_page']) ? route('front.index', $general_setting['user_signup_page']) : '#';
                            $register_url = langBasedURL($lang, $register_url);
                            $modal_setting = getI2bModalSetting($lang, ['i2b_modal', 'upgrade_modal', 'general']);
                            $inquiry_id = null;
                        @endphp
                        @foreach ($inquiries as $inquiry)
                            @isset($inquiry->deadline_date)
                                @php
                                    $inquiry->deadline_date = date('F d, Y', strtotime($inquiry->deadline_date));
                                @endphp
                            @endisset
                        @endforeach
                        @if (Session::has('inquiry_id'))
                            @php
                                $inquiry_id = Session::get('inquiry_id');
                            @endphp
                            @if (Session::has('inquiry_id'))
                                @php
                                    $inquiry_id = Session::get('inquiry_id');
                                @endphp
                            @else
                                @php
                                    $inquiry_id = null;
                                @endphp
                            @endif
                        @endif

                        @php
                            $user = auth()
                                ->guard('customers')
                                ->user();
                            $user = isset($user) ? $user->loadMissing('registrationPackage') : null;
                        @endphp

                        <i2b-listing home_page_setting_detail="{{ $homePageSettingDetail }}"
                            inquiries="{{ json_encode($inquiries->all()) }}" display_all_i2b="0"
                            login_page_setting_detail="{{ $loginPageSettingDetail }}" inquiry_id="{{ $inquiry_id }}"
                            register_url="{{ $register_url }}" modal_setting="{{ $modal_setting }}"
                            user="{{ $user }}" lang="{{ $lang }}" i2b_setting="{{ $i2b_setting }}">
                        </i2b-listing>

                        @if (isset($_GET['search']))
                            <div class="justify-center mb-8 mt-8">
                                @if (count($inquiries) == 0)
                                    <h1 class="can-exp-h2 text-center text-primary">
                                        @php
                                            $setting = getStaticTranslationByKey($lang, 'general', ['no_result_found_text']);
                                        @endphp
                                        {{ isset($setting['no_result_found_text']) ? $setting['no_result_found_text'] : '' }}
                                    </h1>
                                @endif
                            </div>
                        @endif

                        <div class="mt-10">
                            {{ $inquiries->links() }}
                        </div>

                    </div>

                </section>
            </div>
        </div>
    </div>

@endisset
