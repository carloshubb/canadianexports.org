@component('mail::message')
Hello,
@php
$packagePrice = isset($data['package']['discount_price']) && $data['package']['discount_price'] > 0 ? $data['package']['discount_price'] : $data['package']['price'];
$packageName = (isset($data['package'][0]['package_detail']['amount_pre_text']) ? $data['package'][0]['package_detail']['amount_pre_text'] : ''). '$'. $packagePrice .(isset($data['package'][0]['package_detail']['amount_post_text']) ? $data['package'][0]['package_detail']['amount_post_text'] : '');
@endphp
<p style="text-align: justify;">This is a reminder that {{$data['customer']['name']}}'s {{$packageName}} subscription is set to expire on {{date('F d, Y', strtotime($data['customer']['package_expiry_date']))}}.</p>


{{-- {{ config('app.name') }} --}}
@endcomponent
