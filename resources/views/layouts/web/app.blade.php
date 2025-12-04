<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{ $meta_tags ?? '' }}

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    {{ $styles ?? '' }}
    <script src="{{ asset('js/web.js') }}" defer></script>
</head>

<body>
    @include('layouts.web.navbar')
    <div id="canexp-app">
        {{ $slot }}
    </div>
    @include('layouts.web.footer')


    {{ $scripts ?? '' }}
    <script src="{{asset('plugins/popper/popper.min.js')}}" charset="utf-8"></script>
    <script>
        function openDropdown(event, dropdownID) {
            let element = event.target;
            while (element.nodeName !== "BUTTON") {
                element = element.parentNode;
            }
            var popper = Popper.createPopper(element, document.getElementById(dropdownID), {
                placement: 'bottom-start'
            });
            document.getElementById(dropdownID).classList.toggle("hidden");
            document.getElementById(dropdownID).classList.toggle("block");
        }
    </script>

</body>

</html>
