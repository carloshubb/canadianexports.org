<header>
    <nav class="bg-gray-50 text-gray-800 shadow-md h-14 md:h-auto border-b border-gray-700 relative z-20">
        <div class="mx-auto px-4 py-2 lg:px-12 desktop:px-80">
            <div class="flex justify-between items-center">
                <div class="flex space-x-4">
                    <div>
                        <!-- Website Logo -->
                        <a aria-label="Candian Exporters" href="{{ route('front.index') }}" class="flex items-center">
                            <img src="{{ asset('assets/image/logo-dark.png') }}" alt="Logo" class="w-32 lg:w-48">
                        </a>
                    </div>
                </div>
                <!-- Secondary Navbar items -->
                <div class="hidden md:flex items-center md:space-x-0 lg:space-x-3 ">
                    <!-- Primary Navbar items -->
                    <div class="flex md:space-x-1 md:text-sm lg:text-base lg:space-x-3">
                        <div class="flex flex-wrap">
                            <div class="w-full px-4">
                                <div class="relative inline-flex align-middle w-full">
                                    <button aria-label="Candian Exporters" type="button"
                                        class="menu font-FuturaBdCnBT text-sm lg:text-base text-gray-800  hover:text-primaryRed font-medium transition duration-300 p-1 lg:p-2"
                                        onclick="openDropdown(event,'dropdown-id')">
                                        About us
                                    </button>
                                    <div class="hidden bg-white divide-y z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
                                        style="min-width:12rem" id="dropdown-id">
                                        <a aria-label="Candian Exporters" href="#"
                                            class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                            About us
                                        </a>
                                        <a aria-label="Candian Exporters" href="#"
                                            class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                            How the business categories came about
                                        </a>
                                        <a aria-label="Candian Exporters" href="#"
                                            class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                            Inquiries to buy
                                        </a>
                                        <a aria-label="Candian Exporters" href="#"
                                            class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                            How do we delete our profile
                                        </a>
                                        <a aria-label="Candian Exporters" href="#"
                                            class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                            Scam alerts
                                        </a>
                                        <a aria-label="Candian Exporters" href="#"
                                            class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                            Success stories
                                        </a>
                                        <a aria-label="Candian Exporters" href="#"
                                            class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                            Contact us
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a aria-label="Candian Exporters" href="#"
                            class="menu font-FuturaBdCnBT text-sm lg:text-base text-gray-800  hover:text-primaryRed font-medium transition duration-300 p-1 lg:p-2">
                            Career</a>
                        <a aria-label="Candian Exporters" href="#"
                            class="menu font-FuturaBdCnBT text-sm lg:text-base text-gray-800  hover:text-primaryRed font-medium transition duration-300 p-1 lg:p-2">
                            Production
                        </a>
                        <a aria-label="Candian Exporters" href="#"
                            class="menu font-FuturaBdCnBT text-sm lg:text-base text-gray-800  hover:text-primaryRed font-medium transition duration-300 p-1 lg:p-2">
                            Annoucement
                        </a>
                        <a aria-label="Candian Exporters" href="#"
                            class="menu font-FuturaBdCnBT text-sm lg:text-base text-gray-800  hover:text-primaryRed font-medium transition duration-300 p-1 lg:p-2">
                            Contact
                        </a>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2">
                    @auth('customers')
                        <div class="flex flex-wrap">
                            <div class="w-full px-4">
                                <div class="relative inline-flex align-middle w-full">
                                    <button aria-label="Candian Exporters" type="button"
                                        class="menu font-FuturaBdCnBT text-sm lg:text-base text-gray-800  hover:text-primaryRed font-medium transition duration-300 p-1 lg:p-2"
                                        onclick="openDropdown(event,'dropdown-id2')">
                                        Welcome {{ auth()->guard('customers')->user()->name }} <i class="fa fa-user"></i>
                                    </button>
                                    <div class="hidden bg-white divide-y z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
                                        style="min-width:12rem" id="dropdown-id2">
                                        @if(auth()->guard('customers')->user()->type === 'sponsor')
                                            {{-- Sponsor-specific menu --}}
                                            <a aria-label="Candian Exporters" href="{{ route('user.sponsor-settings.index') }}"
                                                class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                                <i class="fa fa-edit"></i> Edit Sponsor Profile
                                            </a>
                                            @php
                                                $firstSponsorId = \App\Models\Sponsor::where('customer_id', auth()->guard('customers')->id())->orderBy('id')->value('id');
                                                $accountUrl = $firstSponsorId ? route('user.sponsor-settings.edit', ['id' => $firstSponsorId]) : route('user.sponsor-settings.index');
                                            @endphp
                                            <a aria-label="Candian Exporters" href="{{ $accountUrl }}"
                                                class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                                Account Settings
                                            </a>
                                        @else
                                            {{-- Regular user menu --}}
                                            <a aria-label="Candian Exporters" href="{{ route('user.profile-settings.index') }}"
                                                class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                                Account Settings
                                            </a>
                                            <a aria-label="Candian Exporters" href="{{ route('user.buissness-settings.index') }}"
                                                class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                                Business profile setting
                                            </a>
                                            <a aria-label="Candian Exporters" href="#"
                                                class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                                Media Setting
                                            </a>
                                            <a aria-label="Candian Exporters" href="{{ route('user.social-media-settings.index') }}"
                                                class="menu font-FuturaBdCnBT text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                                                Social Media Setting
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a aria-label="Candian Exporters" class="font-FuturaBdCnBT text-primaryRed border border-primaryRed hover:bg-primaryRed hover:text-white lg:px-4 lg:py-1.5 rounded outline-none focus:outline-none ease-linear transition-all duration-150 px-2"
                            href="#"
                            onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">
                            Logout
                        </a>
                        <form id="user-logout-form" action="{{ route('web.user.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    @endauth
                    @guest('customers')
                        @php
                            $url = isset($general_setting['user_signin_page']) ? route('front.index', $general_setting['user_signin_page']) : '#';
                            $url = langBasedURL($lang, $url);
                        @endphp
                        <a aria-label="Candian Exporters" class="font-FuturaBdCnBT text-primaryRed border border-primaryRed hover:bg-primaryRed hover:text-white lg:px-4 lg:py-1.5 rounded outline-none focus:outline-none ease-linear transition-all duration-150 px-2"
                            href="{{ $url }}">
                            Log In
                        </a>
                        <a aria-label="Candian Exporters" class="font-FuturaBdCnBT text-primaryRed border border-primaryRed hover:bg-primaryRed hover:text-white lg:px-4 lg:py-1.5 rounded outline-none focus:outline-none ease-linear transition-all duration-150 px-2"
                            href="@isset($general_setting['user_signup_page']) {{ url($general_setting['user_signup_page']) }} @endisset">
                            Register
                        </a>
                    @endguest

                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button aria-label="Candian Exporters" class="outline-none mobile-menu-button">
                        <svg class=" w-6 h-6 text-gray-500 hover:text-primaryRed " x-show="!showMenu" fill="none"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- mobile menu -->
        <div class="hidden mobile-menu bg-gray-50 h-screen text-gray-800 relative z-20">
            <ul class="">
                <li class="active"><a aria-label="Candian Exporters" href="{{ route('front.index') }}"
                        class="block text-sm p-4 text-white bg-primaryRed font-semibold">Home</a></li>
                <li><a aria-label="Candian Exporters" href="#"
                        class="block text-sm p-4 hover:bg-primaryRed transition duration-300 p-1 lg:p-2">About Us</a>
                </li>
                <li><a aria-label="Candian Exporters" href="#"
                        class="block text-sm p-4 hover:bg-primaryRed transition duration-300 p-1 lg:p-2">Career</a>
                </li>
                <li><a aria-label="Candian Exporters" href="#"
                        class="block text-sm p-4 hover:bg-primaryRed transition duration-300 p-1 lg:p-2">Production</a>
                </li>
                <li><a aria-label="Candian Exporters" href="#"
                        class="block text-sm p-4 hover:bg-primaryRed transition duration-300 p-1 lg:p-2">Annoucement</a>
                </li>
                <li><a aria-label="Candian Exporters" href="#"
                        class="block text-sm p-4 hover:bg-primaryRed transition duration-300 p-1 lg:p-2">Contact</a>
                </li>
            </ul>
            <div class="space-y-2 p-4">
                <button aria-label="Candian Exporters"
                    class="text-primaryRed w-full md:w-auto border border-primaryRed hover:bg-primaryRed hover:text-white  px-4 py-1.5 rounded outline-none focus:outline-none ease-linear transition-all duration-150"
                    type="button">
                    Log In
                </button>
                <a aria-label="Candian Exporters" class="text-primaryRed w-full md:w-auto border border-primaryRed hover:bg-primaryRed hover:text-white  px-4 py-1.5 rounded outline-none focus:outline-none ease-linear transition-all duration-150"
                    href="@isset($general_setting['user_signup_page']) {{ url($general_setting['user_signup_page']) }} @endisset">
                    Register
                </a>
            </div>
        </div>
    </nav>
</header>

