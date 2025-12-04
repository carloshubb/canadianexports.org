{{-- </div>
<div class="w-full bg-gray-300 mt-4">
    <div class="container py-8">
        @isset($widget, $widget->widgetDetail[0])
            <div class="flex items-center gap-x-4">
                <div class="w-1/2"><img src="{{ isset($widget->media) ? asset($widget->media->path) : '' }}"
                        class="object-fit h-60 rounded shadow-md border" alt="Canadian Exports" /></div>
                <div class="w-1/2">{!! $widget->widgetDetail[0]->text_detail !!}</div>

            </div>
        @endisset
    </div>
</div>
<div class="container"> --}}

<div class="mt-14">
    @isset($widget, $widget->widgetDetail[0])
    <div class="md:h-48 lg:h-60 mt-4 bg-cover bg-no-repeat rounded-md md:rounded-lg bg-right"
        style="background-image: url('{{ asset('assets/widget-bg.png') }}');">
        <div class="flex items-center">
            <div class="h-24 md:h-48 lg:h-60 w-1/2 bg-gray-200 float-left order-1"
                style="clip-path: polygon(0px 0px, 87% 0px, 100% 100%, 0% 100%);">
                <img class="h-full md:h-48 lg:h-60 w-full rounded-l-md md:rounded-l-lg"
                    src="{{ isset($widget->media) ? asset($widget->media->path) : '' }}" alt="" />
            </div>
            <div class="w-1/2 order-2 px-4 md:px-8">
                <div class="">
                    {!! $widget->widgetDetail[0]->text_detail !!}
                </div>
                <button>
                    <a href="{!! $widget->widgetDetail[0]->button_link !!}" target="{{$widget->widgetDetail[0]->action == 'external' ? '_blank' : ''}}" class="button-exp-fill text-white">
                        {!! $widget->widgetDetail[0]->button_text !!}
                    </a>
                </button>
            </div>
        </div>
    </div>
    @endisset
</div>
