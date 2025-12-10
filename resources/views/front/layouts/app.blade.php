<!DOCTYPE html>
@php
    $lang = getDefaultLanguage(true);
    $cookie_setting = getI2bModalSetting($lang, ['cookies_modal']);
    $generalSetting = getI2bModalSetting($lang, ['general']);
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    $isMobile =
        preg_match(
            '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',
            $useragent,
        ) ||
        preg_match(
            '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
            substr($useragent, 0, 4),
        );
    $currentRouteName = Route::currentRouteName();
    $currentUrl = request()->url();
    $currentSlug = Str::afterLast($currentUrl, '/');
@endphp
<html lang="{{ isset($lang->abbreviation) ? $lang->abbreviation : 'en' }}" class="light scroll-smooth"
    dir="{{ isset($lang->direction) ? $lang->direction : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="@yield('meta_description', 'Xelent Solutions is a leading software house in Pakistan, providing custom software solutions, web and mobile app development, and IT consulting services. Contact us for your software development needs.')">
    <meta name="keywords" content="@yield('meta_keywords', 'software development, web development, mobile app development, custom software solutions, IT consulting, Pakistan')">
    <link rel="preconnect" href="https://www.google-analytics.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="preconnect" href="https://www.googletagmanager.com">
    {{-- <meta name="facebook-domain-verification" content="5u03y2xc6drukenl6ibc7qisupiox3" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/favicon/apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/favicon/apple-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/favicon/apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/favicon/apple-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/favicon/apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/favicon/apple-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/ssets/favicon/apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/favicon/apple-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-icon-180x180.png" />
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    {{-- <link rel="manifest" href="/site.webmanifest"> --}}

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="670">
    <meta property="og:url" content="https://xelenthost.com/">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('meta_description', 'Xelent Solutions is a leading software house in Pakistan, providing custom software solutions, web and mobile app development, and IT consulting services. Contact us for your software development needs.')">
    {{-- <meta property="og:image" content="@yield('facebook_meta_image', 'https://xelent.pk/assets/images/xelent-staff.jpg')"> --}}
    @php
    $facebookMetaImage = isset($settings['facebook_meta_image']) ?  asset('storage/temp/' . basename($settings['facebook_meta_image'])) : 'https://xelent.pk/assets/images/xelent-staff.jpg';
@endphp
<meta property="og:image" content="{{ $facebookMetaImage }}">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://xelenthost.com/">
    <meta property="twitter:title" content="@yield('title')">
    <meta property="twitter:description" content="@yield('meta_description', 'Xelent Solutions is a leading software house in Pakistan, providing custom software solutions, web and mobile app development, and IT consulting services. Contact us for your software development needs.')">
    <meta property="twitter:image" content="@yield('twitter_meta_image', 'https://xelent.pk/assets/images/xelent-staff.jpg')">

    <meta name="author" content="Xelent Solutions" />
    <meta name="copyright" content="Xelent Solutions" />
    {{-- <meta name="website" content="https://xelent.pk" /> --}}
    <meta name="email" content="info@xelent.pk" />
    <meta name="version" content="1.6.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    {{-- favicon --}}
    {{-- <link rel="shortcut icon" href="assets/images/favicon.ico" /> --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    {{-- Css --}}
    {{-- <link href="{{ asset('assets/libs/animate.css/animate.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/libs/tobii/css/tobii.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/libs/tiny-slider/tiny-slider.css') }}" rel="stylesheet"> --}}
    {{-- Main Css --}}
    {{-- <link href="{{ asset('assets/libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}" /> --}}
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="text-black">
    {{-- Loader Start --}}
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <div id="canexp-app" class="flex min-h-screen flex-col">
        {{-- Loader End --}}
        {{-- Start Navbar --}}
        <div class="flex-initial">
            @include('front.includes.navbar')
        </div>
        <div class="relative flex-auto bg-gray-50">
            {{-- End Navbar --}}
            @yield('content')
            @php
                $languages = getAllLanguages();
                // dd($languages[0]->flagIcon->path);
                $params = \Request::getRequestUri();
                $params = explode('?', $params);
                $params = isset($params[1]) ? $params[1] : null;
            @endphp
            @foreach ($languages as $language)
                @isset($language->flagIcon)
                    @php
                        $language->flagIcon->full_path = asset($language->flagIcon->path);
                    @endphp
                @endisset
            @endforeach
            @if (count($languages) > 1)
                <language-modal :languages="{{ $languages }}" current_url="{{ \Request::url() }}"
                    url_params="{{ $params }}"></language-modal>
            @endif
        </div>
        @php
            $user_event_listing_page = isset($general_setting['user_event_listing_page'])
                ? $general_setting['user_event_listing_page']
                : '#';
                $user_sponser_listing_page = isset($general_setting['user_sponser_listing_page'])
                ? $general_setting['user_sponser_listing_page']
                : '#';
            $close_account_page = isset($general_setting['close_account_page'])
                ? $general_setting['close_account_page']
                : '#';
        @endphp
        @if (
            $isMobile &&
                ($currentRouteName == 'user.profile-settings.index' ||
                    $currentRouteName == 'user.buissness-settings.index' ||
                    $currentRouteName == 'user.media-setting.index' ||
                    $currentRouteName == 'user.social-media-settings.index' ||
                    $currentSlug == $user_event_listing_page || $currentSlug == $user_sponser_listing_page ||
                    $currentSlug == $close_account_page))
        @else
            <div class="flex-end">
                @include('front.layouts.footer', ['lang' => $lang])
            </div>
        @endif
    </div>
    @php
        $cookies_allow = 0;
    @endphp
    @if (isset($_COOKIE['cookies_allow']) && $_COOKIE['cookies_allow'] == 1)
        @php
            $cookies_allow = $_COOKIE['cookies_allow'];
        @endphp
    @endif

    @if (!$cookies_allow)
        <div class="fixed bottom-16 left-0 right-0 z-10 mx-auto flex w-4/5 max-w-screen-lg flex-wrap items-center justify-center gap-4 rounded-lg bg-white p-5 text-center shadow md:bottom-0 md:flex-nowrap md:justify-between md:text-left lg:rounded-lg"
            id="cookies-contest">
            <div class="w-full text-sm md:text-sm lg:text-base">
                {{ isset($cookie_setting['body_text']) ? $cookie_setting['body_text'] : '' }}
                @php
                    $learn_more_btn_link = isset($cookie_setting['learn_more_btn_link'])
                        ? $cookie_setting['learn_more_btn_link']
                        : '';
                    $learn_more_btn_link = langBasedURL($lang, $learn_more_btn_link);
                @endphp
                <a aria-label="Candian Exporters" href="{{ $learn_more_btn_link }}"
                    class="can-exp-a whitespace-nowrap hover:underline font-FuturaMdCnBT">{{ isset($cookie_setting['learn_more_btn_text']) ? $cookie_setting['learn_more_btn_text'] : '' }}</a>
            </div>
            <div class="flex flex-shrink-0 items-center gap-4">
                {{-- <button aria-label="Candian Exporters" class="text-indigo-600 focus:outline-none hover:underline">Learn more</button> --}}
                <button aria-label="Candian Exporters" class="button-exp-fill" onclick="acceptCookies()">
                    {{ isset($cookie_setting['allow_cookies_button_text']) ? $cookie_setting['allow_cookies_button_text'] : '' }}
                </button>
            </div>
            <script>
                function acceptCookies() {
                    // Set cookie for 1 year
                    document.cookie = "cookies_allow=1; path=/; max-age=" + 60 * 60 * 24 * 365;

                    // Hide the banner on the current page
                    const el = document.getElementById('cookies-contest');
                    if (el) el.style.display = 'none';
                }
            </script>
        </div>
    @endif


    @if ($isMobile)
        <div
            class="fixed bottom-0 left-0 right-0 flex items-center justify-between bg-white px-5 py-3 text-center shadow-lg">
            @php
                $homePageUrl = route('front.index');
                $homePageUrl = langBasedURL($lang, $homePageUrl);

                $coffeeOnTheWallUrl = route('coffee_on_wall');
                $coffeeOnTheWallUrl = langBasedURL($lang, $coffeeOnTheWallUrl);

                $signin_url = isset($general_setting['user_signin_page'])
                    ? route('front.index', $general_setting['user_signin_page'])
                    : '#';
                $signin_url = langBasedURL($lang, $signin_url);

                $signup_url = isset($general_setting['user_signup_page'])
                    ? route('front.index', $general_setting['user_signup_page'])
                    : '#';
                $signup_url = langBasedURL($lang, $signup_url);

                $profile_url = langBasedURL($lang, route('user.profile-settings.index'));

                $search_url = route('user.search.advanceSearch');
                $search_url = langBasedURL($lang, $search_url);
            @endphp
            {{--<a href="{{ $homePageUrl }}" class="mx-auto w-full text-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="mx-auto h-5 w-5 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span
                    class="mt-0.5 text-sm">{{ isset($generalSetting['home_button_text']) ? $generalSetting['home_button_text'] : '' }}</span>
            </a>--}}
            <a href="{{ $coffeeOnTheWallUrl }}" class="mx-auto grow-1 text-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="mx-auto h-5 w-5 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span
                    class="mt-0.5 text-sm">Coffee on the Wall</span>
            </a>
            @guest('customers')
                <a href="{{ $signin_url }}" class="mx-auto grow-2 text-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="mx-auto h-5 w-5 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>

                    <span
                        class="mt-0.5 text-sm">{{ isset($generalSetting['signin_button_text']) ? $generalSetting['signin_button_text'] : '' }}</span>
                </a>
            @endguest
            @auth('customers')
                <a href="{{ $profile_url }}" class="mx-auto grow-2 text-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="mx-auto h-5 w-5 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>


                    <span
                        class="mt-0.5 text-sm">{{ isset($generalSetting['profile_button_text']) ? $generalSetting['profile_button_text'] : '' }}</span>
                </a>
            @endauth
            @guest('customers')
                <a href="{{ $signup_url }}" class="mx-auto grow-2 text-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="mx-auto h-5 w-5 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                    </svg>

                    <span
                        class="mt-0.5 text-sm">{{ isset($generalSetting['signup_button_text']) ? $generalSetting['signup_button_text'] : '' }}</span>
                </a>
            @endguest
            @auth('customers')
                <a href="#" class="mx-auto grow-2 text-center text-gray-700"
                    onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="mx-auto h-5 w-5 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>


                    <span
                        class="mt-0.5 text-sm">{{ isset($generalSetting['logout_button_text']) ? $generalSetting['logout_button_text'] : '' }}</span>
                </a>
            @endauth

            {{--<a href="{{ $search_url }}" class="mx-auto w-full text-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="mx-auto h-5 w-5 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>


                <span
                    class="mt-0.5 text-sm">{{ isset($generalSetting['search_button_text']) ? $generalSetting['search_button_text'] : '' }}</span>
            </a>--}}
        </div>
    @endif


    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center p-4" id="modal-id">
        <div class="relative w-full my-6 mx-auto max-w-2xl">
            <!--content-->
            <div class="relative border-[3px] rounded-xl [border-image:linear-gradient(120deg,#07f,#0ff,#f0f,#f80)_1] flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->

                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="card-heading text-primary mb-0">{{ isset($generalSetting['signup_modal_text']) ? $generalSetting['signup_modal_text'] : 'What do you want to register on Canadian Exports?' }}</h3>
                    <div>
                        <button type="button" class="mt-1 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center" data-modal-hide="defaultModal" onclick="toggleRegistrationModal('modal-id')">
                            <svg aria-hidden="true" class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-center space-x-3 pb-2">
                        <div>
                            @php
                            // dd($general_setting['user_signup_page']);
                                $url = isset($general_setting['user_signup_page'])
                                    ? route('front.index', $general_setting['user_signup_page'])
                                    : '#';
                                $url = langBasedURL($lang, $url);
                            @endphp
                            <a aria-label="Candian Exporters" href="{{ $url }}"
                                class="button-exp-fill">{{ isset($generalSetting['signup_modal_exporter_button']) ? $generalSetting['signup_modal_exporter_button'] : 'Register an Exporter Profile' }}</a>
                            </a>
                        </div>
                        <div>
                            @php
                                $page1 = getPageBySlug('home-page', $lang);
                                $homePageSetting1 = getHomePageSetting($lang, $page1);
                                $homePageSettingDetail1 = isset($homePageSetting1->homePageSettingDetail[0])
                                    ? $homePageSetting1->homePageSettingDetail[0]
                                    : null;
                                // Always use event-signup page (all 5 steps)
                                $general_setting = getSignleGeneralSettingByKey(['user_event_signup_page']);
                                $eventSignupRoute = isset($general_setting['user_event_signup_page'])
                                    ? route('front.index', $general_setting['user_event_signup_page'])
                                    : '#';
                                $url = langBasedURL($lang, $eventSignupRoute);
                            @endphp
                            <a aria-label="Candian Exporters" href="{{ $url }}"
                                class="button-exp-no-fill">{{ isset($generalSetting['signup_modal_event_button']) ? $generalSetting['signup_modal_event_button'] : 'Create an Event' }}</a>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>

    {{-- Footer Start --}}
    {{-- @if (Request::is('contact-us'))
          @include('includes.footer-minimal')
        @else
          @include('includes.footer')
        @endif --}}
    {{-- Footer End --}}
    {{-- Back to top  --}}
    <a aria-label="Candian Exporters" href="#" onclick="topFunction()" id="back-to-top"
        class="back-to-top fixed bottom-20 md:bottom-3 right-5 z-10 flex hidden  h-9 w-9 items-center justify-center rounded-full bg-secondary bg-opacity-40 text-center text-lg leading-9 text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
        </svg>

    </a>

    <div class="widget-heading widget-text hidden">
    </div>
    {{-- Back to top --}}

    {{-- JAVASCRIPTS --}}
    {{-- <script src="{{ asset('assets/libs/jarallax/jarallax.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/tobii/js/tobii.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/tiny-slider/min/tiny-slider.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/plugins.init.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/wow.js/wow.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/app.js') }}" defer></script>
    <script src="{{ asset('/js/web.js') }}" defer></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    {{--
        <script src="assets/"></script>
        <script src="assets/"></script>
        <script src="assets/"></script>
        <script src="assets/"></script>
        <script src="assets/"></script>
        <script src="assets/js/xelent.js"></script> --}}
    {{-- JAVASCRIPTS --}}
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2PHESYKTMZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-2PHESYKTMZ');
    </script>
</body>
<script src="{{ asset('plugins/popper/popper.min.js') }}" charset="utf-8"></script>
@yield('scripts')
<script>
    function toggleRegistrationModal(modalID){
        document.getElementById(modalID).classList.toggle("hidden");
        document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
        document.getElementById(modalID).classList.toggle("flex");
        document.getElementById(modalID + "-backdrop").classList.toggle("flex");
    }

    var navbar = document.getElementById("topnav");
    var navHeight = navbar.offsetHeight;
    window.addEventListener("scroll", function() {
        if (window.pageYOffset > 0) {
            document.getElementById("nav_items").style.padding = "12px 0";
            document.getElementById("logo").style.margin = "5px 0px 0px 0px";
            document.getElementById("logocircle").style.width = "45px";
            document.getElementById("logotext").style.width = "140px";
            document.getElementById("logo_wrapper").style.display = "flex";
            document.getElementById("logo_outer").style.height = "3.5rem";
            document.getElementById("topnav").style.height = "3.5rem";
            document.getElementById("navigation").style.margin = "-12px 0px 0px 0px";

        } else {
            document.getElementById("nav_items").style.padding = "24px 0";
            document.getElementById("logo").style.margin = "5px 0px 0px 0px";
            document.getElementById("logocircle").style.width = "50px";
            document.getElementById("logotext").style.width = "160px";
            document.getElementById("logo_wrapper").style.display = "inline-block";
            document.getElementById("logo_outer").style.height = "auto";
            document.getElementById("topnav").style.height = "auto";
            document.getElementById("navigation").style.margin = "0px 0px 0px 0px";
        }
    });
    setTimeout(() => {
        new Swiper(".mySwiper", {
            // Default parameters
            slidesPerView: 1,
            spaceBetween: 30,
            speed: 400,
            navigation: {
                nextEl: '.swiper-button-next-exp',
                prevEl: '.swiper-button-prev-exp',
            },
        });
    }, 3000);

    function openDropdown(event, dropdownID) {
        let element = event.target;
        while (element.nodeName !== "BUTTON") {
            element = element.parentNode;
        }
        var dropdown = document.getElementById(dropdownID);
        var popper = Popper.createPopper(element, dropdown, {
            placement: 'bottom-start'
        });

        dropdown.classList.toggle("hidden");
        dropdown.classList.toggle("block");

        // Add event listener to close dropdown when clicking outside
        function closeDropdownOutsideClick(event) {
            if (!element.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
                dropdown.classList.remove("block");
                document.removeEventListener("click", closeDropdownOutsideClick);
            }
        }

        document.addEventListener("click", closeDropdownOutsideClick);
    }


    function acceptCookies() {
        fetch("{{ route('accept-cookies') }}")
            .then(response => {
                if (response.ok) {
                    // Hide the cookie consent popup
                    document.getElementById('cookies-contest').classList.toggle('hidden');
                }
            })
            .catch(error => {
                console.error('Failed to accept cookies:', error);
            });
    }

    function toggleCollapsible() {
        const content = document.getElementById("collapsibleContent");
        const arrowIcon = document.getElementById("arrowIcon");

        if (content.style.opacity === "1") {
            content.style.opacity = "0";
            setTimeout(function() {
                content.classList.add("hidden");
            }, 300); // Transition duration in milliseconds (adjust as needed)
        } else {
            content.classList.remove("hidden");
            setTimeout(function() {
                content.style.opacity = "1";
            }, 0); // Wait for display to be set before applying opacity (adjust as needed)
        }

        arrowIcon.classList.toggle("rotate-180");
    }


    setTimeout(() => {
        const drawerButton = document.getElementById('drawer-button');
        const drawerMenu = document.getElementById('drawer-menu');
        const drawerCloseButton = document.getElementById('drawer-close-button');

        // Open drawer menu when the drawer button is clicked
        if (drawerButton) {
            drawerButton.addEventListener('click', function(event) {
                drawerMenu.style.transform = 'translateX(0)';
                event.stopPropagation(); // Prevent the click event from reaching the document
            });
        }

        // Close drawer menu when the close button is clicked
        if (drawerCloseButton) {
            drawerCloseButton.addEventListener('click', function() {
                drawerMenu.style.transform = 'translateX(100%)';
            });
        }

        // Close drawer menu when clicking outside of the menu
        if (drawerMenu && drawerButton) {
            document.addEventListener('click', function(event) {
                const isClickInsideDrawer = drawerMenu.contains(event.target);
                const isClickOnDrawerButton = drawerButton.contains(event.target);

                if (!isClickInsideDrawer && !isClickOnDrawerButton) {
                    drawerMenu.style.transform = 'translateX(100%)';
                }
            });
        }

        // Prevent clicks inside the drawer menu from closing the menu
        if (drawerMenu) {
            drawerMenu.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }

    }, 2000);
    setTimeout(() => {
        var swiper = new Swiper('.magazine-slider-container', {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: '.magazine-button-next-exp',
                prevEl: '.magazine-button-prev-exp',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            }
        });

    }, 2000);
    setTimeout(() => {
        var swiper = new Swiper('.sponsor-slider-container', {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            spaceBetween: 10,
            navigation: {
                nextEl: '.sponsor-button-next-exp',
                prevEl: '.sponsor-button-prev-exp',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
            },
            on: {
                init: function() {
                    setEqualHeight('sponsor-swiper-slide');
                },
                resize: function() {
                    setEqualHeight('sponsor-swiper-slide');
                }
            }
        });

    }, 2000);

    function setEqualHeight(className) {
        var slides = document.querySelectorAll(`.${className}`);
        var maxHeight = 0;

        // Reset height
        slides.forEach(function(slide) {
            slide.style.height = 'auto';
        });

        // Calculate max height
        slides.forEach(function(slide) {
            var slideHeight = slide.offsetHeight;
            if (slideHeight > maxHeight) {
                maxHeight = slideHeight;
            }
        });

        // Set max height to all slides
        slides.forEach(function(slide) {
            slide.style.height = maxHeight + 'px';
        });
    }
    setTimeout(() => {
        var swiper = new Swiper('.featured-exporter-slider-container', {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            spaceBetween: 10,
            navigation: {
                nextEl: '.featured-exporter-button-next-exp',
                prevEl: '.featured-exporter-button-prev-exp',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            },
            on: {
                init: function() {
                    setEqualHeight('featured-exporter-swiper-slide');
                },
                resize: function() {
                    setEqualHeight('featured-exporter-swiper-slide');
                }
            }
        });

    }, 2000);
    setTimeout(() => {
        var swiper = new Swiper('.featured-events-slider-container', {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            spaceBetween: 10,
            navigation: {
                nextEl: '.featured-events-button-next-exp',
                prevEl: '.featured-events-button-prev-exp',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            },
            on: {
                init: function() {
                    setEqualHeight('featured-events-swiper-slide');
                },
                resize: function() {
                    setEqualHeight('featured-events-swiper-slide');
                }
            }
        });

    }, 2000);

    setTimeout(() => {
        var swiper = new Swiper('.i2b-slider-container', {
            slidesPerView: 1,

            spaceBetween: 10,
            navigation: {
                nextEl: '.i2b-button-next-exp',
                prevEl: '.i2b-button-prev-exp',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            },
            on: {
                init: function() {
                    setEqualHeight('i2b-swiper-slide');
                },
                resize: function() {
                    setEqualHeight('i2b-swiper-slide');
                }
            }
        });

    }, 2000);

    function fixUrls() {
        var links = document.getElementsByClassName('fix-url');

        for (var i = 0; i < links.length; i++) {
            var url = links[i].getAttribute('href');

            if (url && !url.startsWith('http://') && !url.startsWith('https://')) {
                url = 'https://' + url;
                links[i].setAttribute('href', url);
            }
        }
    }
</script>
{{-- <script src="https://www.google.com/recaptcha/api.js?render=6Lfn-usoAAAAABX3ZhQ_pGrVHjPtgHfqdF-y1afb"></script> --}}
{{-- <script src="https://www.google.com/recaptcha/api.js?render=6Lfn-usoAAAAABX3ZhQ_pGrVHjPtgHfqdF-y1afb"></script> --}}

</html>
