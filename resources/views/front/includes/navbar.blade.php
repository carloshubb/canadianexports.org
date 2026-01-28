@php
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
@endphp
<nav id="topnav" class="defaultscroll is-sticky z-10 bg-gray-100 shadow-lg">
    <div class="container flex items-center justify-between">
        <!-- Logo container-->
        @php
            $url = route('front.index');
            $url = langBasedURL($lang, $url);
            $generalSetting = getI2bModalSetting($lang, ['general']);
        @endphp
        <a aria-label="Candian Exporters" class="logo pl-0" href="{{ $url }}" id="logo_outer">
            <span class="items-center" id="logo_wrapper">
                <div class="mt-2 flex items-center gap-1" id="logo">
                    <img src="{{ asset('/assets/images/logocircle.png') }}" class="max-w-[55px]" alt="Candian Exporters"
                        id="logocircle" />
                    <img src="{{ asset('/assets/images/logotext.png') }}" class="max-w-[165px]" alt="Candian Exporters"
                        id="logotext" />
                </div>
            </span>
            <img src="{{ asset('assets/images/logo.png') }}" class="hidden h-16" alt="Candian Exporters">
        </a>

        <!-- End Logo container-->

        @php
            $menu = getMainMenu($lang);
            $menuItems = isset($menu->menuDetail[0]) ? json_decode($menu->menuDetail[0]->menu_items, 1) : null;
            // Alphabetize menu items (and nested children) by name
            if ($menuItems && is_array($menuItems)) {
                $sortMenuRecursively = function (&$items) use (&$sortMenuRecursively) {
                    // sort current level by name (case-insensitive)
                    usort($items, function ($a, $b) {
                        return strcasecmp($a['name'] ?? '', $b['name'] ?? '');
                    });
                    // sort children if present
                    foreach ($items as &$it) {
                        if (isset($it['menus']) && is_array($it['menus']) && count($it['menus']) > 0) {
                            $sortMenuRecursively($it['menus']);
                        }
                    }
                };
                $sortMenuRecursively($menuItems);
            }
        @endphp

        <div id="navigation" class="transition-all duration-300 ease-in-out">
            <!-- Navigation Menu-->
            <ul class="navigation-menu font-FuturaMdCnBT text-base md:text-base lg:text-lg" id="nav_items">
                @isset($menuItems)
                    @foreach ($menuItems as $menuItem)
                        @if (count($menuItem['menus']) > 0)
                            {{-- display on desktop --}}
                            <li class="has-submenu parent-menu-item dropdown-menu-exp flex items-center">

                                <a aria-label="Candian Exporters">{{ $menuItem['name'] }}</a><span
                                    class="menu-arrow"></span>
                                @include('front.includes.navbar-child', ['childs' => $menuItem['menus']])
                            </li>
                            {{-- display on mobile --}}
                            <li class="has-submenu parent-menu-item dropdown-menu-exp-responsive">
                                <a aria-label="Candian Exporters" class="" onclick="toggleCollapsible()"
                                    href="#">
                                    <span class="flex items-center gap-x-1">
                                        {{ $menuItem['name'] }}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="currentColor" class="h-3 w-3" id="arrowIcon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </span>


                                </a>
                                <div id="collapsibleContent" class="mx-auto hidden w-11/12 rounded bg-gray-50 p-2">
                                    @include('front.includes.mobile-navbar-child', [
                                        'childs' => $menuItem['menus'],
                                    ])
                                </div>
                            </li>
                        @else
                            <li>

                                @php
                                    $url = langBasedURL($lang, $menuItem['link']);
                                @endphp
                                <a aria-label="Candian Exporters" href="{{ $url }}"
                                    class="sub-menu-item font-FuturaMdCnBT">{{ $menuItem['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                @endisset
                @guest('customers')
                    <li>
                        <ul class="mt-4 flex list-none items-center justify-center gap-2 md:hidden">
                            <li>
                                @php
                                    $url = isset($general_setting['user_signup_page'])
                                        ? route('front.index', $general_setting['user_signup_page'])
                                        : '#';
                                    $url = langBasedURL($lang, $url);
                                @endphp
                                <a aria-label="Candian Exporters" href="{{ $url }}"
                                    class="button-exp-no-fill border-primary text-primary">{{ isset($generalSetting['signup_button_text']) ? $generalSetting['signup_button_text'] : '' }}</a>
                            </li>
                            <li>
                                @php
                                    $url = isset($general_setting['user_signin_page'])
                                        ? route('front.index', $general_setting['user_signin_page'])
                                        : '#';
                                    $url = langBasedURL($lang, $url);
                                @endphp
                                <a aria-label="Candian Exporters" href="{{ $url }}"
                                    class="button-exp-fill border-2 font-FuturaMdCnBT hover:text-white">{{ isset($generalSetting['signin_button_text']) ? $generalSetting['signin_button_text'] : '' }}</a>
                            </li>
                        </ul>
                    </li>
                @endguest
                @if ($isMobile)
                    @guest
                        <li class="">
                            <ul class="flex list-none items-center justify-center gap-2 py-3 md:hidden">
                                <li>
                                    {{-- <a aria-label="Candian Exporters" href="{{ url('/login') }}"
                                        class="button-exp border-primary text-primary">Admin log
                                        in</a> --}}
                                </li>
                            </ul>
                        </li>
                    @endguest
                @endif
            </ul>
        </div>

        <!--Login button Start-->
        <div class="hidden items-center gap-2 md:flex lg:gap-0">
            <ul class="buy-button m-0 mb-0 inline-flex list-none gap-2 p-0 font-Futura">
                @auth('customers')
                    <li class="mb-0 hidden md:inline-flex">
                        @php
                            $url = route('coffee_on_wall');
                            $url = langBasedURL($lang, $url);
                            
                        @endphp
                        <a aria-label="Candian Exporters" href="{{ $url }}" class="button-exp-no-fill">Coffee on
                            the Wall</a>
                    </li>
                    <li class="mb-0 inline">
                        <div class="inline-flex align-middle">
                            <button aria-label="Canadian Exporters" type="button"
                                class="menu hover:text-primaryRed flex items-center space-x-2 p-1 font-Futura text-sm font-medium text-gray-800 transition duration-300 lg:p-2 lg:text-base"
                                onclick="openDropdown(event,'dropdown-id2')">
                                @php
                                    $name = auth()->guard('customers')->user()->name ?? null;
                                    $nameParts = explode('-', $name); // Split name by the hyphen
                                    $firstName = $nameParts[0]; // Get the first part of the name (first name)
                                @endphp
                                {{-- Show 'Hi' followed by the first name --}}
                                Hi {{ $firstName ?? '' }}


                                @php
                                    $user = auth()->guard('customers')->user()->loadMissing('profileImage');
                                @endphp
                                @if (isset($user->profileImage) && file_exists($user->profileImage->medium_image))
                                    <div class="dropdown-toggle image-fit zoom-in ml-2 h-8 w-8 scale-110 overflow-hidden rounded-full shadow"
                                        role="button" aria-expanded="false" data-tw-toggle="dropdown">
                                        <img alt="user" src="{{ asset($user->profileImage->medium_image) }}" class="h-8 w-8 object-cover aspect-square rounded-full" />
                                    </div>
                                    {{-- @else
                                <div class="dropdown-toggle image-fit zoom-in ml-2 h-8 w-8 scale-110 overflow-hidden rounded-full shadow flex items-center justify-center"
                                    role="button" aria-expanded="false" data-tw-toggle="dropdown">
                                    <img alt="user"
                                        src="https://ui-avatars.com/api/?name={{ $firstName }}&amp;color=7F9CF5&amp;background=EBF4FF" />
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 text-gray-300">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                </div> --}}
                                @endif
                            </button>

                            @php
                                $customer = auth()->guard('customers')->user();
                                $lang = getDefaultLanguage(true);
                            @endphp

                            <div class="z-50 float-left mt-1 hidden list-none divide-y rounded bg-white py-2 text-left shadow-lg animate__animated animate__fadeIn"
                                style="min-width:12rem" id="dropdown-id2">
                            @if ($customer && $customer->type == 'sponsor')
                                {{-- Sponsor-specific menu --}}
                                @php
                                    $sponsorUrl = langBasedURL($lang, route('user.sponsor-settings.index'));
                                    // For sponsors, send Account Settings to edit the first sponsorship if available
                                    $firstSponsorId = \App\Models\Sponsor::where('customer_id', $customer->id)->orderBy('id')->value('id');
                                    $accountRoute = $firstSponsorId ? route('user.sponsor-settings.edit', ['id' => $firstSponsorId]) : route('user.sponsor-settings.index');
                                    $accountUrl = langBasedURL($lang, $accountRoute);
                                @endphp
                                <a aria-label="Candian Exporters" href="{{ $sponsorUrl }}"
                                    class="menu block w-full whitespace-nowrap bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-slate-700 md:text-base lg:text-lg">
                                    <i class="fa fa-handshake-o"></i> Manage Sponsorships
                                </a>
                                <a aria-label="Candian Exporters" href="{{ $accountUrl }}"
                                    class="menu block w-full whitespace-nowrap bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-slate-700 md:text-base lg:text-lg">
                                    <i class="fa fa-user-circle"></i> Account Settings
                                </a>
                                @elseif ($customer && $customer->type == 'customer')
                                    {{-- Regular customer menu --}}
                                    @php
                                        $url = langBasedURL($lang, route('user.profile-settings.index'));
                                    @endphp
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="menu block w-full whitespace-nowrap bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-slate-700 md:text-base lg:text-lg">{{ isset($generalSetting['account_setting_text']) ? $generalSetting['account_setting_text'] : '' }}</a>
                                    @php
                                        $url = langBasedURL($lang, route('user.buissness-settings.index'));
                                    @endphp
                                @endif
                                @if ($customer->type == 'event' || $customer->type == 'customer')
                                    @php
                                        $url = isset($general_setting['user_event_listing_page'])
                                            ? url($general_setting['user_event_listing_page'])
                                            : '#';
                                        $url = langBasedURL($lang, $url);
                                    @endphp
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="menu block w-full whitespace-nowrap bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-slate-700 md:text-base lg:text-lg">{{ isset($generalSetting['event_listing_text']) ? $generalSetting['event_listing_text'] : '' }}</a>
                                @endif
                                @if ($customer->type == 'event' || $customer->type == 'customer')
                                    @php
                                        // For regular users, link to public sponsor listing page
                                        $url = isset($general_setting['user_sponser_listing_page'])
                                            ? url($general_setting['user_sponser_listing_page'])
                                            : '#';
                                        $url = langBasedURL($lang, $url);
                                    @endphp
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="menu block w-full whitespace-nowrap bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-slate-700 md:text-base lg:text-lg">
                                        {{ isset($generalSetting['sponser_listing_text']) ? $generalSetting['sponser_listing_text'] : 'Sponsor Listing' }}
                                    </a>
                                @endif
                                @if ($customer->type == 'event' || $customer->type == 'customer')
                                    @php
                                        $url = isset($general_setting['close_account_page'])
                                            ? url($general_setting['close_account_page'])
                                            : '#';
                                        $url = langBasedURL($lang, $url);
                                    @endphp
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="menu block w-full whitespace-nowrap bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-slate-700 md:text-base lg:text-lg">
                                        {{ isset($generalSetting['delete_profile_text']) ? $generalSetting['delete_profile_text'] : '' }}
                                    </a>
                                @endif
                                <a aria-label="Candian Exporters" href="#"
                                    class="menu block w-full whitespace-nowrap bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-red-700 md:text-base lg:text-lg"
                                    onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">{{ isset($generalSetting['logout_button_text']) ? $generalSetting['logout_button_text'] : '' }}</a>
                                <form id="user-logout-form" action="{{ route('web.user.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </li>
                @endauth
                @guest('customers')
                    <li class="mb-0 hidden md:inline-flex">
                        @php
                            $url = route('coffee_on_wall');
                            $url = langBasedURL($lang, $url);
                        @endphp
                        <a aria-label="Candian Exporters" href="{{ $url }}" class="button-exp-no-fill">Coffee
                            on the Wall</a>
                    </li>
                    <li class="mb-0 hidden md:inline-flex">
                        @php
                            $url = isset($general_setting['user_signin_page'])
                                ? route('front.index', $general_setting['user_signin_page'])
                                : '#';
                            $url = langBasedURL($lang, $url);
                        @endphp
                        <a aria-label="Candian Exporters" href="{{ $url }}"
                            class="button-exp-fill whitespace-nowrap hover:text-white border border-primary">{{ isset($generalSetting['signin_button_text']) ? $generalSetting['signin_button_text'] : '' }}</a>
                    </li>
                    <li class="mb-0 hidden pl-1 md:inline-flex">
                        @php
                            $url = isset($general_setting['user_signup_page'])
                                ? route('front.index', $general_setting['user_signup_page'])
                                : '#';
                            $url = langBasedURL($lang, $url);
                        @endphp
                        <button type="button" onclick="toggleRegistrationModal('modal-id')"
                            class="button-exp-no-fill">{{ isset($generalSetting['signup_button_text']) ? $generalSetting['signup_button_text'] : '' }}</button>
                    </li>
                @endguest
            </ul>
            <div class="menu-extras md:order-2">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a aria-label="Candian Exporters" class="navbar-toggle isToggle" onclick="toggleMenu()">
                        <div class="lines m-0">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
        </div>

        <!--Login button End-->

        <!--Login button Start-->
        <div class="flex items-center gap-2 md:hidden lg:gap-0">
            <ul class="buy-button m-0 mb-0 inline-flex list-none gap-2 p-0 font-Futura">
                @auth('customers')
                    <li class="mb-0 inline">
                        <div class="inline-flex align-middle">
                            <button aria-label="Candian Exporters" id="drawer-button" type="button"
                                class="menu hover:text-primaryRed flex items-center space-x-2 p-1 font-Futura text-sm font-medium text-gray-800 transition duration-300 lg:p-2 lg:text-base">
                                <span class="hidden md:block">{{ auth()->guard('customers')->user()->name }}</span>
                                @php
                                    $user = auth()->guard('customers')->user()->loadMissing('profileImage');
                                @endphp
                                @if (isset($user->profileImage) && file_exists($user->profileImage->medium_image))
                                    <div class="image-fit zoom-in h-10 w-10 scale-110 overflow-hidden rounded-full shadow"
                                        role="button" aria-expanded="false" data-tw-toggle="dropdown">
                                        <img alt="user" src="{{ asset($user->profileImage->medium_image) }}" />
                                    </div>
                                @else
                                    <div class="image-fit zoom-in h-10 w-10 scale-110 overflow-hidden rounded-full shadow"
                                        role="button" aria-expanded="false" data-tw-toggle="dropdown"><img
                                            alt="user"
                                            src="https://ui-avatars.com/api/?name={{ auth()->guard('customers')->user()->name }}&amp;color=7F9CF5&amp;background=EBF4FF">
                                    </div>
                                @endif

                            </button>
                            @php
                                $customer = auth()->guard('customers')->user();
                            @endphp


                            <div class="drawer" id="drawer-menu">
                                <div class="flex justify-end p-2">
                                    <svg id="drawer-close-button" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="h-7 w-7 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>

                                </div>

                                @if ($customer->type == 'sponsor')
                                    {{-- Sponsor-specific mobile menu - only Edit Sponsor Profile --}}
                                    @php
                                        $url = langBasedURL($lang, route('user.sponsor-settings.index'));
                                    @endphp
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="menu block w-full whitespace-nowrap border-b bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-white md:text-base lg:text-lg">
                                        <i class="fa fa-edit"></i> Edit Sponsor Profile
                                    </a>
                                @elseif ($customer->type == 'customer')
                                    {{-- Regular customer mobile menu --}}
                                    @php
                                        $url = langBasedURL($lang, route('user.profile-settings.index'));
                                    @endphp
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="menu block w-full whitespace-nowrap border-b bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-white md:text-base lg:text-lg">{{ isset($generalSetting['account_setting_text']) ? $generalSetting['account_setting_text'] : '' }}</a>
                                    @php
                                        $url = langBasedURL($lang, route('user.buissness-settings.index'));
                                    @endphp
                                @endif
                                @if ($customer->type == 'event' || $customer->type == 'customer')
                                    @php
                                        $url = isset($general_setting['user_event_listing_page'])
                                            ? url($general_setting['user_event_listing_page'])
                                            : '#';
                                        $url = langBasedURL($lang, $url);
                                    @endphp
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="menu block w-full whitespace-nowrap border-b bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-white md:text-base lg:text-lg">{{ isset($generalSetting['event_listing_text']) ? $generalSetting['event_listing_text'] : '' }}</a>
                                @endif
                                @if ($customer->type == 'event' || $customer->type == 'customer' || $customer->type == 'sponsor')
                                    @php
                                        $url = isset($general_setting['user_sponser_listing_page'])
                                            ? url($general_setting['user_sponser_listing_page'])
                                            : '#';
                                        $url = langBasedURL($lang, $url);
                                    @endphp
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="menu block w-full whitespace-nowrap border-b bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-white md:text-base lg:text-lg">{{ isset($generalSetting['sponser_listing_text']) ? $generalSetting['sponser_listing_text'] : 'Sponsor Listing' }}</a>
                                @endif
                                @if ($customer->type == 'event' || $customer->type == 'customer')
                                    @php
                                        $url = isset($general_setting['close_account_page'])
                                            ? url($general_setting['close_account_page'])
                                            : '#';
                                        $url = langBasedURL($lang, $url);
                                    @endphp
                                    <a aria-label="Candian Exporters" href="{{ $url }}"
                                        class="menu block w-full whitespace-nowrap border-b bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-white md:text-base lg:text-lg">
                                        {{ isset($generalSetting['delete_profile_text']) ? $generalSetting['delete_profile_text'] : '' }}
                                    </a>
                                @endif
                                {{-- Logout button for all user types --}}
                                <a aria-label="Candian Exporters" href="#"
                                    class="menu block w-full whitespace-nowrap border-b bg-transparent px-4 py-2 font-FuturaMdCnBT text-base text-red-700 md:text-base lg:text-lg"
                                    onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">{{ isset($generalSetting['logout_button_text']) ? $generalSetting['logout_button_text'] : '' }}</a>
                                <form id="user-logout-form" action="{{ route('web.user.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </li>
                @endauth
                @guest('customers')
                    <li class="mb-0 hidden md:inline-flex">
                        @php
                            $url = isset($general_setting['user_signin_page'])
                                ? route('front.index', $general_setting['user_signin_page'])
                                : '#';
                            $url = langBasedURL($lang, $url);
                        @endphp
                        <a aria-label="Candian Exporters" href="{{ $url }}"
                            class="button-exp-fill whitespace-nowrap hover:text-white">{{ isset($generalSetting['signin_button_text']) ? $generalSetting['signin_button_text'] : '' }}</a>
                    </li>
                    <li class="mb-0 hidden pl-1 md:inline-flex">
                        @php
                            $url = isset($general_setting['user_signup_page'])
                                ? route('front.index', $general_setting['user_signup_page'])
                                : '#';
                            $url = langBasedURL($lang, $url);
                        @endphp
                        <a aria-label="Candian Exporters" href="{{ $url }}"
                            class="button-exp-no-fill">{{ isset($generalSetting['signup_button_text']) ? $generalSetting['signup_button_text'] : '' }}</a>
                    </li>
                @endguest
            </ul>
            @if ($isMobile)
                <div class="menu-extras md:order-2">
                    <div class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a aria-label="Candian Exporters" class="navbar-toggle isToggle" id="toggle-btn"
                            onclick="toggleMenu()">
                            <div class="lines m-0">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </div>
                </div>
            @endif
        </div>

        <!--Login button End-->
    </div>
</nav>
