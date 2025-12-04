<ul class="list-none space-y-1 font-semibold">
    @php
        if (isset($childs) && is_array($childs)) {
            usort($childs, function ($a, $b) {
                return strcasecmp($a['name'] ?? '', $b['name'] ?? '');
            });
        }
    @endphp
    @foreach ($childs as $child)
        @if (count($child['menus']) > 0)
            <li class="has-submenu parent-menu-item dropdown-menu-exp-responsive">
                <a aria-label="Candian Exporters" href="#">{{ $child['name'] }}</a>
                {{-- <span class="menu-arrow"></span> --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 pr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>

                @php
                    if (isset($child['menus']) && is_array($child['menus'])) {
                        usort($child['menus'], function ($a, $b) {
                            return strcasecmp($a['name'] ?? '', $b['name'] ?? '');
                        });
                    }
                @endphp
                @include('front.includes.mobile-navbar-child', ['childs' => $child['menus']])
            </li>
        @else
            @php
                $url = langBasedURL($lang, $child['link']);
            @endphp
            <li class="cursor-pointer p-1 rounded"><a aria-label="Candian Exporters" href="{{ $url }}" class="sub-menu-item text-gray-800">{{ $child['name'] }}</a></li>
        @endif
    @endforeach
</ul>
