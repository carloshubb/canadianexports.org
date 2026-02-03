@php
    $widget = getWidgetById($homePageSetting->business_widget_id);
@endphp
@isset($widget)
    @if ($widget->layout == 'layout_1')
        @php
            $page_detail = view('front.pages.widgets.layout-1', ['widget' => $widget]);
        @endphp
    @elseif($widget->layout == 'layout_2')
        @php
            $page_detail = view('front.pages.widgets.layout-2', ['widget' => $widget]);
        @endphp
    @elseif($widget->layout == 'layout_3')
        @php
            $page_detail = view('front.pages.widgets.layout-3', ['widget' => $widget]);
        @endphp
    @endif
@endisset

<div class="featured-businesses-banner">
    {!! $page_detail ?? null !!}
</div>
