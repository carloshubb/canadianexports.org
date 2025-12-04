@php
    $footerSetting = getFooterSetting($lang);
    $footerSettingDetail = isset($footerSetting->footerSettingDetail[0]) ? $footerSetting->footerSettingDetail[0] : null;
@endphp
@isset($footerSettingDetail)
    <footer class="footer-exp bg-secondary lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 px-2">
        <div class="container">
            <div>
                <div class="w-full">
                    <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-8">

                        <div class="">
                            <div class="text-primary footer-exp-heading">{!! $footerSettingDetail->widget1 !!}</div>
                            @isset($footerSetting->widget1Menu->menuDetail, $footerSetting->widget1Menu->menuDetail[0])
                                <ul class="space-y-1 list-none p-0">
                                    @php
                                        $menuItems = json_decode($footerSetting->widget1Menu->menuDetail[0]->menu_items, 1);
                                    @endphp
                                    @foreach ($menuItems as $menuItem)
                                        @php
                                            $url = langBasedURL($lang, $menuItem['link']);
                                        @endphp
                                        <li class="text-white mt-4"><a aria-label="Candian Exporters" href="{{ $url }}">{{ $menuItem['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endisset
                        </div>

                        <div class="">
                                 <div class="text-primary footer-exp-heading">{!! $footerSettingDetail->widget2 !!}</div>
                            @isset($footerSetting->widget2Menu->menuDetail, $footerSetting->widget2Menu->menuDetail[0])
                                <ul class="space-y-1 list-none p-0">
                                    @php
                                        $menuItems = json_decode($footerSetting->widget2Menu->menuDetail[0]->menu_items, 1);
                                    @endphp
                                    @foreach ($menuItems as $menuItem)
                                        @php
                                            $url = langBasedURL($lang, $menuItem['link']);
                                        @endphp
                                        <li class="text-white mt-4"><a aria-label="Candian Exporters" href="{{ $url }}">{{ $menuItem['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endisset
                        </div>

                        <div class="">
                            <div class="text-primary footer-exp-heading">{!! $footerSettingDetail->widget3 !!}</div>
                            @isset($footerSetting->widget3Menu->menuDetail, $footerSetting->widget3Menu->menuDetail[0])
                                <ul class="space-y-1 list-none p-0">
                                    @php
                                        $menuItems = json_decode($footerSetting->widget3Menu->menuDetail[0]->menu_items, 1);
                                    @endphp
                                    @foreach ($menuItems as $menuItem)
                                        @php
                                            $url = langBasedURL($lang, $menuItem['link']);
                                        @endphp
                                        <li class="text-white mt-4"><a aria-label="Candian Exporters" href="{{ $url }}">{{ $menuItem['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endisset
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <hr class="mt-10 mb-2">
        <div class="">
            @php
                $socialLinkStyle =
                    'display:inline-block;width:40px;height:40px;border-radius:9999px;background-color:#f9fafb;border:2px solid #d1d5db;text-decoration:none;padding:10px;box-sizing:border-box;margin:0 8px;';
                $socialImageStyle = 'display:block;width:20px;height:20px;margin:0;';
            @endphp
            <div class="flex items-center gap-4 justify-center mb-3 mt-4" style="text-align:center;">
                <a aria-label="Candian Exporters" target="_blank" href="{{ $footerSetting->fb_link }}"
                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-10 w-10 fix-url" onclick="fixUrls()"
                    style="{{ $socialLinkStyle }}">
                    <img class="h-5" src="{{ asset('/assets/icons/facebook canexp.png') }}" alt="facebook icon" width="20" height="20"
                        style="{{ $socialImageStyle }}" />
                </a>
                <a aria-label="Candian Exporters" target="_blank" href="{{ $footerSetting->twitter_link }}"
                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-10 w-10 fix-url" onclick="fixUrls()"
                    style="{{ $socialLinkStyle }}">
                    <img class="h-4" src="{{ asset('/assets/icons/twitter canexp.png') }}" alt="twitter icon" width="20" height="20"
                        style="{{ $socialImageStyle }}" />
                </a>
                <a aria-label="Candian Exporters" target="_blank" href="{{ $footerSetting->google_link }}"
                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-10 w-10 fix-url" onclick="fixUrls()"
                    style="{{ $socialLinkStyle }}">
                    <img class="h-5" src="{{ asset('/assets/icons/google canexp.png') }}" alt="google icon" width="20" height="20"
                        style="{{ $socialImageStyle }}" />
                </a>
                <a aria-label="Candian Exporters" target="_blank" href="{{ $footerSetting->youtube_link }}"
                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-10 w-10 fix-url" onclick="fixUrls()"
                    style="{{ $socialLinkStyle }}">
                    <img class="h-4" src="{{ asset('/assets/icons/youtube canexp.png') }}" alt="youtube icon" width="20" height="20"
                        style="{{ $socialImageStyle }}" />
                </a>
                <a aria-label="Candian Exporters" target="_blank" href="{{ $footerSetting->linkedin_link }}"
                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-10 w-10 fix-url" onclick="fixUrls()"
                    style="{{ $socialLinkStyle }}">
                    <img class="h-4" src="{{ asset('/assets/icons/linkedin canexp.png') }}" alt="linkedin icon" width="20" height="20"
                        style="{{ $socialImageStyle }}" />
                </a>
            </div>
            <div class="pb-8 md:pb-0">
                <div class="text-white text-base md:text-base lg:text-lg text-center">
                    {!! $footerSettingDetail->copyright_text !!}
                </div>
            </div>
        </div>
    </footer>
@endisset
