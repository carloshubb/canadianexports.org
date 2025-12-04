{{-- @component('mail::message')
# Hi,

<p>We received a request to reactivate your account on Canadian Exporters. If you didn't make this request, you can ignore this email.</p>
<p>To reactivate your account, click the following link:</p>
@php
$encyrtedEmail = str_replace('/', '===', $data['user_id']);
@endphp
<x-mail::button :url="route('front.customer-reactive-email', ['email' => $data['email'], 'id' => $encyrtedEmail, 'status' => 'active'])" color="success">
Click here to reactivate account
</x-mail::button>

<p>If you are unable to click the link, please copy and paste it into your web browser's address bar.<a href="{{route('front.customer-reactive-email', ['email' => $data['email'], 'id' => $encyrtedEmail, 'status' => 'active'])}}">{{route('front.customer-reactive-email', ['email' => $data['email'], 'id' => $encyrtedEmail, 'status' => 'active'])}}</a></p>

<p>Thank you for choosing Canadian Exporters. If you have any questions or need assistance, please don't hesitate to contact our customer support team at <a href="mailto:info@canexp.com">info@canexp.com</a> or <a href="tel:+18773133014">1-877-313-3014</a>.</p>


{{ config('app.name') }}
@endcomponent --}}

@component('mail::message')
# Hi {{$data["name"]}},

<p>This is a friendly email to confirm that your account has been reactivated. We want to welcome you back and to inform you that you may resume using our website and enjoy its benefits. You may also edit your exporter profile and its login credentials should you wish to</p>

<p>Note: If you did not register with us, or believe that this email has reached you in error, please contact us as soon as possible</p>

<p>Thank you and have a good day</p>

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
