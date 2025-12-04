{{-- @component('mail::message')
Hello {{$data['customer']['name']}},

<p style="text-align: justify;">Your transaction on Canadian Exports was successful. Thank you!</p>

@if(isset($data['payment_frequency']))
@if($data['payment_frequency'] == 'monthly')
@php
$payment_frequency = 'Monthly';
$price = $data['package_price'];
@endphp
@elseif($data['payment_frequency'] == 'quarterly')
@php
$payment_frequency = 'Quarterly';
$price = $data['package_price']*3;
@endphp
@elseif($data['payment_frequency'] == 'semi_annually')
@php
$payment_frequency = 'Semi annually';
$price = $data['package_price']*6;
@endphp
@elseif($data['payment_frequency'] == 'annually')
@php
$payment_frequency = 'Annually';
$price = $data['package_price']*12;
@endphp
@endif
@else
@php
$price = $data['package_price'];
@endphp
@endif
<ul>
    @if(isset($data['invoice_no']))
    <li><strong>Invoice #:</strong> {{$data['invoice_no']}}</li>
    @endif
    <li><strong>Package:</strong> {{$data['package_name']}}</li>
    @if(isset($payment_frequency))
    <li><strong>Duration:</strong> {{ $payment_frequency }}</li>
    @endif
    <li><strong>Package price:</strong> ${{ number_format((isset($price) ? $price : 0), 2) }}</li>
    @if(isset($data['package_expiry_date']))
    <li><strong>Package validity:</strong> {{date('F d, Y', strtotime($data['package_expiry_date']))}}</li>
    @endif
</ul>

<p style="text-align: justify;">If you have any questions or need further assistance, please contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="to:+18773333014">1-877-333-3014</a> </p>
<p style="text-align: justify;">This email was sent from an outgoing-only address that cannot accept incoming emails. If you haven't found information you are looking for, or if you still have questions, please visit our website to access general information, frequently asked questions, contact us information, and more</p>

# Canadian Exports Team
@endcomponent --}}


@component('mail::message')
Hello {{$data['customer']['name']}},

@if ($data['customer']['type'] == 'event')
<p style="text-align: justify;">Thank you for registering your event {{ $data['event_name'] }} on the Canadian Exports platform. Here is your invoice:</p>
@else
<p style="text-align: justify;">Thank you for registering your exporter profile with Canadian Exports. Here is your invoice:</p>
@endif

@if(isset($data['payment_frequency']))
@if($data['payment_frequency'] == 'monthly')
@php
$payment_frequency = 'Monthly';
$price = $data['package_price'];
@endphp
@elseif($data['payment_frequency'] == 'quarterly')
@php
$payment_frequency = 'Quarterly';
$price = $data['package_price']*3;
@endphp
@elseif($data['payment_frequency'] == 'semi_annually')
@php
$payment_frequency = 'Semi annually';
$price = $data['package_price']*6;
@endphp
@elseif($data['payment_frequency'] == 'annually')
@php
$payment_frequency = 'Annually';
$price = $data['package_price']*12;
@endphp
@endif
@else
@php
$price = $data['package_price'];
@endphp
@endif
<ul>
    @if(isset($data['invoice_no']))
    <li><strong>Invoice #:</strong> {{$data['invoice_no']}}</li>
    @endif
    @if($data['customer']['type'] == 'event')
    <li><strong>Event name:</strong> {{$data['event_name']}}</li>
    @endif
    <li><strong>Package:</strong> {{$data['package_name']}}</li>
    @if(isset($payment_frequency))
    <li><strong>Duration:</strong> {{ $payment_frequency }}</li>
    @endif
    <li><strong>Package price:</strong> ${{ number_format((isset($data['package_price']) ? $data['package_price'] : 0), 2) }}</li>
    <li><strong>Registered On:</strong> {{ date('F d, Y') }}</li>
    <li>
        <strong>Expires On:</strong>
        @if($data['customer']['type'] == 'event')
            {{ \Carbon\Carbon::now()->addMonth()->format('F d, Y') }}
        @elseif(isset($data['package_expiry_date']))
            {{ \Carbon\Carbon::parse($data['package_expiry_date'])->format('F d, Y') }}
        @endif
    </li>
</ul>

<p style="text-align: justify;">Note: If you did not register with us, or believe that this email has reached you in error, please contact us as soon as possible </p>
<p>Thank you and have a great day</p>

# Canadian Exports Team

<table style="margin-bottom: 24px; margin-top: 16px; width: 100%" cellpadding="0" cellspacing="0" role="none">
    <tr>
        <td align="center" style="display: flex;">
            <div style="display: flex; margin: 0 auto;">
                <a aria-label="Proxima Study" target="_blank" href="{{ env('APP_URL') . '/en/contact-us' }}" style="border-right: 1px solid #000; text-decoration: none; font-weight: 600; color: #000; white-space: nowrap; padding-right: 16px; padding-left: 16px;">
                  Help & Contact
                </a>
                <a aria-label="Proxima Study" target="_blank" href="{{ env('APP_URL') . '/en/terms-and-conditions' }}" style="border-right: 1px solid #000; text-decoration: none; font-weight: 600; color: #000; white-space: nowrap; padding-right: 16px; padding-left: 16px;">
                    Terms of use
                </a>
                <a aria-label="Proxima Study" target="_blank" href="{{ env('APP_URL') . '/en/coffee-on-the-wall' }}" style="text-decoration: none; font-weight: 600; color: #000; white-space: nowrap; padding-right: 16px; padding-left: 16px;">
                    Coffee on the Wall
                </a>
            </div>
        </td>
    </tr>
</table>
<div style="border: 1px dashed #000;width: 100%; margin-bottom: 10px;"></div>
<p style="text-align: justify;color: #000;margin-bottom: 0;">Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST</p>
@endcomponent
