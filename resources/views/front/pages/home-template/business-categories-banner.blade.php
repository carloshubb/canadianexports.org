@php
    $widget = getWidgetById($homePageSetting->business_category_widget_id);
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

<div class="container my-4">
    {!! $page_detail ?? null !!}
</div>
