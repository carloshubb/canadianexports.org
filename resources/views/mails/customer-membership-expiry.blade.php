@component('mail::message')
# Dear {{$data['customer']['name']}},
@php
$packagePrice = isset($data['package']['discount_price']) && $data['package']['discount_price'] > 0 ? $data['package']['discount_price'] : $data['package']['price'];
$packageName = (isset($data['package'][0]['package_detail']['amount_pre_text']) ? $data['package'][0]['package_detail']['amount_pre_text'] : ''). '$'. $packagePrice .(isset($data['package'][0]['package_detail']['amount_post_text']) ? $data['package'][0]['package_detail']['amount_post_text'] : '');
@endphp
<p>We hope this email finds you well. We wanted to remind you that your {{$packageName}} subscription is set to expire on {{date('F d, Y', strtotime($data['customer']['package_expiry_date']))}}. We appreciate your business and want to ensure you continue to enjoy uninterrupted access to our services.</p>
<p>To renew your subscription, please follow these simple steps:</p>
<ol>
    <li>Log in to your account on our <a href="{{$data['login_url']}}">Canadian Exporters</a>.</li>
    <li>Go to the "Account setting" section.</li>
    <li>Click on the "Upgrade" button.</li>
    <li>Follow the on-screen instructions to select your preferred payment method and complete the renewal process.</li>
</ol>
<p>
    Renewing your subscription ahead of time not only ensures uninterrupted service but also allows you to continue enjoying all the benefits that come with it.
</p>
<p>If you have any questions or need assistance with the renewal process, please don't hesitate to contact our customer support team at <a href="mailto:info@canexp.com">info@canexp.com</a> or <a href="tel:+18773133014">1-877-313-3014</a>. We're here to help!</p>
<p>Thank you for choosing Canadian Exporters. We value your continued support and look forward to serving you for another subscription period.</p>


{{-- {{ config('app.name') }} --}}
@endcomponent
