@php
    $pattern = '/\[short_code=widget-(\d+)\]/';
@endphp
@if (preg_match_all($pattern, $page_detail, $matches))
    @php
        $widget_numbers = $matches[1];
    @endphp
    @foreach ($widget_numbers as $widget_number)
        @php
            $widget = getWidgetDetail('[short_code=widget-' . $widget_number . ']', $lang);
        @endphp
        @isset($widget)
        @if ($widget->layout == 'layout_1')
            @php
                $page_detail = str_replace('[short_code=widget-' . $widget_number . ']', view('front.pages.widgets.layout-1', ['widget' => $widget]), $page_detail);
            @endphp
        @elseif($widget->layout == 'layout_2')
            @php
                $page_detail = str_replace('[short_code=widget-' . $widget_number . ']', view('front.pages.widgets.layout-2', ['widget' => $widget]), $page_detail);
            @endphp
        @elseif($widget->layout == 'layout_3')
            @php
                $page_detail = str_replace('[short_code=widget-' . $widget_number . ']', view('front.pages.widgets.layout-3', ['widget' => $widget]), $page_detail);
            @endphp
        @endif
        @endisset
    @endforeach
@endif
<div class="container">
    {!! $page_detail !!}
</div>
