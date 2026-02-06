@component('mail::message')
# Content submitted by a Sponsor

A sponsor has submitted content for review on the Canadian Exports website.

**Type:** {{ $data['type'] ?? 'Content' }}

@if(isset($data['title']))
**Title:** {{ $data['title'] }}
@endif

@if(isset($data['submitted_by']))
**Submitted by:** {{ $data['submitted_by'] }}
@endif

@if(isset($data['view_url']) && $data['view_url'])
@component('mail::button', ['url' => $data['view_url'], 'color' => 'primary'])
View and Approve Content
@endcomponent
@endif

@endcomponent
