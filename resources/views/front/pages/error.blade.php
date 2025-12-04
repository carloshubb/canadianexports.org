<div class="relative tooltip -bottom-4 group-hover:flex">
    <div role="tooltip"
        class="{{isset($postion) ? $postion : 'relative'}} tooltiptext -top-2 z-0 leading-none transition duration-150 ease-in-out shadow-lg py-2 pr-5 pl-3 bg-primary text-gray-600 rounded w-fit">
        {{-- <svg class="{{isset($postion) ? $postion : 'relative'}} top-0 -mt-2" width="16px" height="8px" viewBox="0 0 16 8" version="1.1"
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="Tooltips-" transform="translate(-93.000000, -355.000000)" fill="#2563eb">
                    <g id="Group-3-Copy-3" transform="translate(76.000000, 331.000000)">
                        <polygon id="Triangle"
                            transform="translate(25.000000, 28.000000) rotate(-360.000000) translate(-25.000000, -28.000000) "
                            points="25 24 33 32 17 32"></polygon>
                    </g>
                </g>
            </g>
        </svg> --}}
        <span class="text-white leading-none py-2 text-base md:text-base lg:text-lg text-left">{!! $errorMessage !!}</span>
    </div>
</div>
