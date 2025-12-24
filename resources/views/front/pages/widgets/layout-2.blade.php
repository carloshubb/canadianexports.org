<div class="my-5 md:my-7">
    @isset($widget)
    @isset($widget->widgetDetail[0])
    <div class="h-48 lg:h-60  w-full bg-primary flex items-center relative rounded-lg">
        <div class="h-48 lg:h-60 w-[58%] bg-red-600 absolute left-0 rounded-l-lg object-fill {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'order-1' : 'order-2' }}" style="clip-path: polygon(0 0, 75% 0%, 100% 100%, 0% 100%);">
            <a href="{!! $widget->widgetDetail[0]->button_link !!}" target="{{$widget->widgetDetail[0]->action == 'external' ? '_blank' : ''}}" class="button-exp-fill text-red-500 border-white bg-white hover:bg-white px-[10px] py-[5px] text-[10pt] md:px-5 md:py-2 md:text-base fix-url" onclick="fixUrls()">
               

                <img class="rounded-l-lg object-fill w-full h-full" src="{{ isset($widget->image_path) ? asset($widget->image_path) : asset('/media/banners/blue_banner_02.jpg') }}" alt="">
            </a>
        </div>
        <div class="relative h-48 lg:h-60 w-full bg-green-600 rounded-r-lg">
            <a href="{{ $widget->widgetDetail[0]->button_link }}"
                target="{{ $widget->widgetDetail[0]->action == 'external' ? '_blank' : '' }}">
                <img
                    class="absolute top-0 rounded-r-lg object-fill w-full h-full"
                    src="{{ isset($widget->media) ? asset($widget->media->path) : '' }}"
                    alt="">

                
            </a>
        </div>
    </div>
    @endisset
    @endisset
</div>