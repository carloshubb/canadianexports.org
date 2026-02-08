<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/web.css">
</head>

<body class="bg-gray-900">
    @php
        $defaultLang = getDefaultLanguage(1);
        $homePageUrl = route('front.index');
        $homePageUrl = langBasedURL($defaultLang, $homePageUrl);
        $general_setting = getSignleGeneralSettingByKey(['contact_us_page']);
        $contactUsUrl = isset($general_setting['contact_us_page']) ? route('front.index', $general_setting['contact_us_page']) : '#';
        $contactUsUrl = langBasedURL($defaultLang, $contactUsUrl);
    @endphp
    
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-2xl w-full text-center">
            <!-- GIF Container -->
            <div class="mb-8">
                <img 
                    src="{{ asset('assets/404/final2.gif') }}" 
                    alt="404 Not Found" 
                    class="mx-auto max-w-full h-auto rounded-lg shadow-2xl"
                    style="max-height: 400px;"
                >
            </div>
            
            <!-- Text Content -->
            <div class="mb-8 font-FuturaMdCnBT">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Ho-ho-hold on! This page doesn't exist.
                </h1>
                <p class="text-gray-300 text-lg md:text-2xl">
                    The page you’re looking for may have been moved, removed,
                    <br class="hidden md:block">
                    renamed — or maybe it never existed in the first place.
                </p>
            </div>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a 
                    aria-label="{{ __('Canadian Exporters') }}"
                    href="{{$homePageUrl}}"
                    class="button-exp-fill px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300 w-full sm:w-auto">
                    Back to Homepage
                </a>
                <a 
                    aria-label="{{ __('Canadian Exporters') }}"
                    href="{{$contactUsUrl}}"
                    class="button-exp-fill px-8 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300 w-full sm:w-auto">
                    Contact us
                </a>
            </div>
        </div>
    </div>
</body>

</html>