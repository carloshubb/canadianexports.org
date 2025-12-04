<div class="my-5 md:my-7">
    <div class="flex rounded-md overflow-hidden">
        @isset($widget, $widget->widgetDetail[0])
        {{-- {{dd($widget);}} --}}
            <div class="md:h-48 lg:h-60 relative w-1/2 {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'rounded-l-lg' : 'rounded-r-lg' }}">
                <img src="{{ isset($widget->media2) ? asset($widget->media2->path) : asset('/media/banners/blue_banner_03.jpg') }}" alt=""  class="h-full w-full object-fill" alt="">
                <div class="absolute top-0 px-4 md:px-8 lg:px-16 py-1 text-white md:h-48 lg:h-60 rounded-lg flex items-center">
                <div>
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
            <div class="w-1/2 h-32 md:h-48 lg:h-60">
                <img class="object-fill w-full h-full {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'rounded-r-lg' : 'rounded-l-lg' }}"
                    src="{{ isset($widget->media) ? asset($widget->media->path) : '' }}" alt="" />
            </div>
        @endisset
    </div>
</div>
