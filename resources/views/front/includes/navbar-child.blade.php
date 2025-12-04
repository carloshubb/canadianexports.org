<ul class="submenu mt-1">
    @php
        // Alphabetize children at this level
        if (isset($childs) && is_array($childs)) {
            usort($childs, function ($a, $b) {
                return strcasecmp($a['name'] ?? '', $b['name'] ?? '');
            });
        }
    @endphp
    @foreach ($childs as $child)
        @if (count($child['menus']) > 0)
            <li class="has-submenu parent-menu-item flex items-center justify-between">
                <a aria-label="Candian Exporters" href="#">{{ $child['name'] }}</a>
                {{-- <span class="menu-arrow"></span> --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 pr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>

                @php
                    // Ensure nested children are alphabetized before rendering deeper
                    if (isset($child['menus']) && is_array($child['menus'])) {
                        usort($child['menus'], function ($a, $b) {
                            return strcasecmp($a['name'] ?? '', $b['name'] ?? '');
                        });
                    }
                @endphp
                @include('front.includes.navbar-child', ['childs' => $child['menus']])
            </li>
        @else
            @php
                $url = langBasedURL($lang, $child['link']);
            @endphp
            <li><a aria-label="Candian Exporters" href="{{ $url }}" class="sub-menu-item">{{ $child['name'] }}</a></li>
        @endif
    @endforeach
</ul>
