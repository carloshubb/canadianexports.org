@php
    // Ensure data array exists and has required keys
    $templateData = $data ?? [];
    if (!isset($templateData['name']) || empty($templateData['name'])) {
        $templateData['name'] = 'User';
    }
    // Create the data structure for template: both $data array and individual variables
    $viewData = array_merge(['data' => $templateData], $templateData);
@endphp

@if (\Illuminate\Support\Str::contains($body_html ?? '', 'mail::message'))
@php
    echo \Illuminate\Support\Facades\Blade::render(
        $body_html ?? '',
        array_merge($viewData, [
            'advertiserName' => $advertiserName ?? null,
            'messageContent' => $messageContent ?? null,
            'unsubscribeLink' => $unsubscribeLink ?? null,
            'customerProfile' => $customerProfile ?? null,
            'sponsor' => $sponsor ?? null,
        ])
    );
@endphp

@else
@component('mail::message')
@php
    echo \Illuminate\Support\Facades\Blade::render(
        $body_html ?? '',
        array_merge($viewData, [
            'unsubscribeLink' => $unsubscribeLink ?? null,
            'sponsor' => $sponsor ?? null
        ])
    );
@endphp

@include('mails.partials.unsubscribe-footer', ['unsubscribeLink' => $unsubscribeLink ?? null])
@endcomponent
@endif


