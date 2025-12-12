@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8">
        <ul class="inline-flex flex-wrap items-center -space-x-px">
            
            {{-- First Page Link --}}
            @if (!$paginator->onFirstPage())
                <li>
                    <a href="{{ $paginator->url(1) }}" 
                       class="px-2 sm:px-3 py-1 sm:py-2 text-gray-700 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100 text-sm sm:text-base">
                        First
                    </a>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-2 sm:px-3 py-1 sm:py-2 text-gray-400 bg-gray-100 border border-gray-300 cursor-not-allowed text-sm sm:text-base">
                        &laquo;
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" 
                       class="px-2 sm:px-3 py-1 sm:py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 text-sm sm:text-base">
                        &laquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $start = max($paginator->currentPage() - 2, 1);
                $end = min($paginator->currentPage() + 2, $paginator->lastPage());
            @endphp

            {{-- Leading Ellipsis --}}
            @if($start > 1)
                <li>
                    <span class="px-2 sm:px-3 py-1 sm:py-2 text-gray-500 bg-white border border-gray-300 text-sm sm:text-base">...</span>
                </li>
            @endif

            {{-- Page Links --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $paginator->currentPage())
                    <li>
                        <span class="px-2 sm:px-3 py-1 sm:py-2 text-white bg-blue-600 border border-gray-300 text-sm sm:text-base">{{ $page }}</span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->url($page) }}" 
                           class="px-2 sm:px-3 py-1 sm:py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 text-sm sm:text-base">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endfor

            {{-- Trailing Ellipsis --}}
            @if($end < $paginator->lastPage())
                <li>
                    <span class="px-2 sm:px-3 py-1 sm:py-2 text-gray-500 bg-white border border-gray-300 text-sm sm:text-base">...</span>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" 
                       class="px-2 sm:px-3 py-1 sm:py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 text-sm sm:text-base">
                        &raquo;
                    </a>
                </li>
            @else
                <li>
                    <span class="px-2 sm:px-3 py-1 sm:py-2 text-gray-400 bg-gray-100 border border-gray-300 cursor-not-allowed text-sm sm:text-base">
                        &raquo;
                    </span>
                </li>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->currentPage() < $paginator->lastPage())
                <li>
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" 
                       class="px-2 sm:px-3 py-1 sm:py-2 text-gray-700 bg-white border border-gray-300 rounded-r-md hover:bg-gray-100 text-sm sm:text-base">
                        Last
                    </a>
                </li>
            @endif

        </ul>
    </nav>
@endif
