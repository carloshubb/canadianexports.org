<div class="mt-8">
    @php
        $page = getFrontPage();
        $lang = getDefaultLanguage(true);
        $homePageSetting = getHomePageSetting($lang, $page);
        $homePageSettingDetail = isset($homePageSetting->homePageSettingDetail[0]) ? $homePageSetting->homePageSettingDetail[0] : null;
        $event_detail_setting = getI2bModalSetting($lang, ['event_detail_setting']);
    @endphp
    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-5">
        @foreach ($searchEvents as $event)
            @if (isset($event->media) && file_exists($event->media->medium_image))
                @php
                    $event->media_path = asset($event->media->medium_image);
                @endphp
            @endif
            @php

                $event->start_date = isset($event->start_date) ? date('F d, Y', strtotime($event->start_date)) : '';
                $event->end_date = isset($event->end_date) ? date('F d, Y', strtotime($event->end_date)) : '';
                $url = route('user.event.show', ['abbreviation' => $lang->abbreviation, 'id' => $event->id]);
            @endphp

            <event-listing event="{{ $event }}" home_page_setting="{{ $homePageSettingDetail }}"
                url="{{ $url }}" event_detail_setting="{{ $event_detail_setting }}" page="advance_search"
                lang="{{ $lang }}">
            </event-listing>
        @endforeach
    </div>

    {{-- @if (count($searchEvents) == 0)
        <h1 class="can-exp-h2 text-center text-primary">
            @php
                $setting = getStaticTranslationByKey($lang, 'general', ['no_result_found_text']);
            @endphp
            {{ isset($setting['no_result_found_text']) ? $setting['no_result_found_text'] : '' }}
        </h1>
    @endif --}}

</div>
<div class="mt-10">
    {{ $searchEvents->appends($_GET)->links() }}
</div>
