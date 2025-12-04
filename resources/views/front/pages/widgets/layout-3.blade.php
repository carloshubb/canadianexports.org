{{-- <div class="my-7">
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
</div> --}}


<div class="my-5 md:my-7">
    <div class="md:h-48 lg:h-60 rounded-lg flex overflow-hidden my-10">
        @isset($widget, $widget->widgetDetail[0])
            <div class="md:h-48 lg:h-60 relative w-1/2">
            <img src="{{ isset($widget->media2) ? asset($widget->media2->path) : asset('/media/banners/blue_banner_01.jpg') }}" alt=""  class="h-full w-full object-fill" alt="">
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
            <div class="relative w-1/2 h-32 md:h-48 lg:h-60">
                <img  src="{{ isset($widget->media) ? asset($widget->media->path) : '' }}" alt=""  class="h-full w-full object-fill" alt="">
                <div class="absolute top-0 flex h-full {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'left-0' : 'right-0' }}">
                    <div class="flex space-x-3 h-full">
                        <span class="w-1 h-full bg-red-600 bg-opacity-70"></span>
                        <span class="w-1.5 h-full bg-red-600 bg-opacity-70"></span>
                        <span class="w-2 h-full bg-red-600 bg-opacity-70"></span>
                        <span class="w-2.5 h-full bg-red-600 bg-opacity-70"></span>
                    </div>
                    <span class="w-3 h-full bg-red-600 bg-opacity-70 {{ isset(getDefaultLanguage(1)->direction) && getDefaultLanguage(1)->direction == 'ltr' ? 'ml-20' : 'mr-20' }}"></span>
                </div>
            </div>
        @endisset
    </div>
</div>
