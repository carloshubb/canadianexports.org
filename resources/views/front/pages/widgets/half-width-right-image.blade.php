{{-- </div>
<div class="w-full bg-gray-300 mt-4">
    <div class="container py-8">
        @isset($widget, $widget->widgetDetail[0])
            <div class="flex items-center gap-x-4">
                <div class="w-1/2">{!! $widget->widgetDetail[0]->text_detail !!}</div>
                <div class="w-1/2"><img src="{{ isset($widget->media) ? asset($widget->media->path) : '' }}"
                        class="object-fit h-60 rounded shadow-md border" alt="Canadian Exports" /></div>

            </div>
        @endisset
    </div>
</div>
<div class="container"> --}}

<div class="mt-14">
    <div class="flex rounded-md md:rounded-lg overflow-hidden">
        @isset($widget, $widget->widgetDetail[0])
            <div class="bg-cover bg-no-repeat md:h-48 lg:h-60 w-1/2 flex items-center px-4 md:px-8 space-y-4 rounded-l-lg"
                style="background-image: url('{{ asset('assets/widget-bg.png') }}');">
                <div>
                    {!! $widget->widgetDetail[0]->text_detail !!}
                    <button>
                        <a href="{!! $widget->widgetDetail[0]->button_link !!}" target="{{$widget->widgetDetail[0]->action == 'external' ? '_blank' : ''}}" class="button-exp-fill text-white">
                            {!! $widget->widgetDetail[0]->button_text !!}
                        </a>
                    </button>
                </div>
            </div>
            <div class="w-1/2">
                <img class="object-cover w-full h-28 md:h-48 lg:h-60 rounded-r-lg"
                    src="{{ isset($widget->media) ? asset($widget->media->path) : '' }}" alt="" />
            </div>
        @endisset
    </div>
</div>
