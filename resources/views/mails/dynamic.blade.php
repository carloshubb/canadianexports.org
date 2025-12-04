@php
    echo \Illuminate\Support\Facades\Blade::render(
        $body_html ?? '',
        array_merge(['data' => $data ?? []], $data ?? [], ['unsubscribeLink' => $unsubscribeLink ?? null])
    );
@endphp

@include('mails.partials.unsubscribe-footer', ['unsubscribeLink' => $unsubscribeLink ?? null])




