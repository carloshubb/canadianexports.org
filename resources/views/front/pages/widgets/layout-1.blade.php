<div class="my-5 md:my-7">
    @isset($widget, $widget->widgetDetail[0])
    <div class="h-48 lg:h-60  w-full bg-primary flex items-center relative rounded-lg">
        <div class="h-48 lg:h-60 w-[58%] bg-red-600 absolute left-0 rounded-l-lg object-fill {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'order-1' : 'order-2' }}" style="clip-path: polygon(0 0, 75% 0%, 100% 100%, 0% 100%);">
            <img class="rounded-l-lg object-fill w-full h-full" src="{{ isset($widget->media2) ? asset($widget->media2->path) : asset('/media/banners/blue_banner_02.jpg') }}" alt="">
        </div>
        <div class="h-48 lg:h-60 w-[57%] bg-green-600 absolute right-0 rounded-r-lg" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 24% 100%);">
            <img class="absolute top-0 rounded-r-lg object-fill w-full h-full" src="{{ isset($widget->media) ? asset($widget->media->path) : '' }}" alt="">
            <div class="relative z-10 flex items-center justify-center h-full w-full">
                <div class="w-[60%] px-4 md:px-8 {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'order-2' : 'order-1' }}">
                    <div class="truncate-text">
                        {!! $widget->widgetDetail[0]->text_detail !!}
                    </div>
                    <button class="mt-4">
                        <a href="{!! $widget->widgetDetail[0]->button_link !!}" target="{{$widget->widgetDetail[0]->action == 'external' ? '_blank' : ''}}" class="button-exp-fill text-red-500 border-white bg-white hover:bg-white px-[10px] py-[5px] text-[10pt] md:px-5 md:py-2 md:text-base fix-url" onclick="fixUrls()">
                                {!! $widget->widgetDetail[0]->button_text !!}
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endisset

    <!-- @isset($widget, $widget->widgetDetail[0])
        <div class="md:h-48 lg:h-60 mt-4 bg-fill bg-no-repeat rounded-md md:rounded-lg bg-right"
            style="background-image: url('{{ isset($widget->media2) ? asset($widget->media2->path) : asset('/media/banners/blue_banner_02.jpg') }}');">
            <div class="flex items-center h-full">
                <div class="h-full w-1/2 float-left {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'order-1' : 'order-2' }}"
                    style="clip-path: polygon(0px 0px, 87% 0px, 100% 100%, 0% 100%);">
                    <img class="h-full w-full rounded-l-md md:rounded-l-lg object-cover"
                        src="{{ isset($widget->media) ? asset($widget->media->path) : '' }}" alt="" />
                </div>
                <div class="w-1/2 px-4 md:px-8 {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'order-2' : 'order-1' }}">
                    <div class="truncate-text">
                        {!! $widget->widgetDetail[0]->text_detail !!}
                    </div>
                    <button class="mt-4">
                        <a href="{!! $widget->widgetDetail[0]->button_link !!}" target="{{$widget->widgetDetail[0]->action == 'external' ? '_blank' : ''}}" class="button-exp-fill text-red-500 border-white bg-white hover:bg-white px-[10px] py-[5px] text-[10pt] md:px-5 md:py-2 md:text-base fix-url" onclick="fixUrls()">
                            {!! $widget->widgetDetail[0]->button_text !!}
                        </a>
                    </button>
                </div>
            </div>
        </div>
    @endisset -->
</div>

