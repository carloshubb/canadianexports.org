<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/web.css">
    <style>
        .error {
            width: 12rem;
            height: 13rem;
            transform: matrix3d(1.25, -0.5, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 52, 0, 1);
        }

        .error_outer {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* top: 4%; */
        }

        @media only screen and (min-width: 320px) and (max-width:785px) {
            .error {
                width: 7rem;
                height: 8rem;
            }

            /* .error_outer{
    top: 23%;
 } */
        }

        @media only screen and (min-width: 1920px) {

            /* .error_outer{
    top: 25%;
 } */
            .mb_100 {
                margin-bottom: 20rem !important;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 980px) {
            .error {
                width: 9rem;
                height: 10rem;
                transform: matrix3d(1.25, -0.5, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 52, 0, 1);
            }

            /* .error_outer{
    top: 16%;
 } */
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    screens: {
                        'desktop': '1920px',
                    },
                    keyframes: {
                        wiggle: {
                            '0%, 100%': {
                                transform: 'rotate(-4deg)'
                            },
                            '50%': {
                                transform: 'rotate(4deg)'
                            },
                        }
                    },
                    animation: {
                        'wiggle': 'wiggle 3s ease-in-out infinite',
                        'bounce': 'bounce 3s ease-in-out infinite',
                    },

                }
            }
        }
    </script>
</head>

<body>
    @php
        $defaultLang = getDefaultLanguage(1);
        $homePageUrl = route('front.index');
        $homePageUrl = langBasedURL($defaultLang, $homePageUrl);
        $general_setting = getSignleGeneralSettingByKey(['contact_us_page']);
        $contactUsUrl = isset($general_setting['contact_us_page']) ? route('front.index', $general_setting['contact_us_page']) : '#';
        $contactUsUrl = langBasedURL($defaultLang, $contactUsUrl);
    @endphp
    <div
        class="w-full bg-[length:100%_100%] xl:bg-cover 2xl:bg-[length:100%_100%] desktop:bg-cover min-h-[45rem] bg-no-repeat bg-center h-screen bg-[url('{{ asset("assets/404/background.jpg") }}')]">
        <div class="flex items-end justify-center h-full w-full relative max-w-screen-2xl mx-auto">
            <div class="absolute top-[55%] md:top-1/2 left-[5%]">
                <img class="animate-bounce transition delay-150 duration-300 ease-in-out w-14 md:w-20 h-14 md:h-20"
                    src="{{ asset('assets/404/stone.png') }}" alt="Candian Exporters">
            </div>
            <div class="absolute error_outer pt-20 xl:pt-0 w-full md:w-2/3 lg:w-1/2 h-[44rem]">
                <div class="w-[9rem] md:w-[12rem] lg:w-[18rem] h-[16rem] md:h-[18rem] lg:h-[24rem] relative mx-auto">
                    <img class="w-full h-full animate-wiggle absolute top-0" src="{{ asset('assets/404/light2.png') }}"
                        alt="Candian Exporters">
                    <img class="error absolute bottom-6 md:-bottom-[5%] left-[16%] md:left-[20%] z-20"
                        src="{{ asset('assets/404/404-01.png') }}" alt="Candian Exporters">
                </div>
                <div class="text-center my-20 w-full mx-auto px-6 lg:my-12">
                    <h1 class="can-exp-h1 text-white">Oops! Page not found</h1>
                    <p class="text-white text-center">The page you are looking for has been moved, removed,
                        <br class="hidden md:block">
                        renamed, or may simply has never existed
                    </p>
                    <div class="flex items-center justify-center space-x-4">
                        <a aria-label="Candian Exporters"
                        href="{{$homePageUrl}}"
                            class="mt-4 button-exp-fill">
                            Go Home</a>
                        <a aria-label="Candian Exporters"
                        href="{{$contactUsUrl}}"
                            class="mt-4 button-exp-fill">
                            Contact us</a>
                    </div>
                </div>
            </div>
            <div class="absolute right-[10%] top-[11%] md:top-[30%]">
                <div class="w-28 md:w-36 lg:w-64 h-28 md:h-36 lg:h-64 relative">
                    <img class="animate-wiggle absolute  -top-8 lg:top-0" src="{{ asset('assets/404/robot.png') }}"
                        alt="Candian Exporters">
                    <img class="w-20 md:w-28 lg:w-44 absolute -right-8 md:-right-12 lg:-right-20 -top-12 md:-top-16 lg:-top-9 z-20"
                        src="{{ asset('assets/404/rocket.png') }}" alt="Candian Exporters">
                </div>
            </div>
            <div class="absolute top-[20%] md:top-auto bottom-auto md:bottom-[10%] right-[5%]">
                <img class="animate-bounce w-14 md:w-20 h-14 md:h-20" src="{{ asset('assets/404/stone.png') }}"
                    alt="Candian Exporters">
            </div>
        </div>
    </div>
</body>

</html>
