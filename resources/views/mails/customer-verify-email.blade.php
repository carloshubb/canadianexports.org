{{-- @component('mail::message')
Hello {{$data['name'] ?? ''}},

<p style="text-align: justify;">Thank you for choosing Canadian Exports! To ensure the security of your account and to provide you with the best possible service, we need to verify your email address</p>
<p style="text-align: justify;">Please click the link below to verify your email address and complete your registration:</p>
@php
$encyrtedEmail = str_replace('/', '===', $data['user_id']);
@endphp
<x-mail::button :url="route('front.customer-verify-email', ['email' => $data['email'], 'id' => $encyrtedEmail, 'status' => 'active'])" color="success">
    Verify email
</x-mail::button>

<p style="text-align: justify;">If your browser does not permit you to click the link above, please copy and paste this URL into your web browser's address bar:<br /><a href="{{route('front.customer-verify-email', ['email' => $data['email'], 'id' => $encyrtedEmail, 'status' => 'active'])}}">{{route('front.customer-verify-email', ['email' => $data['email'], 'id' => $encyrtedEmail, 'status' => 'active'])}}</a></p>
<p style="text-align: justify;">Once you've verified your email and completed your registration, you will have full access to your account and can start enjoying all the benefits of being a Canadian Exports member</p>
<p style="text-align: justify;">If you did not create an account with us or did not request this verification, please disregard this email. Your information will remain secure</p>
<p style="text-align: justify;">Thank you for choosing Canadian Exports. If you have any questions or need assistance, please don't hesitate to contact our customer support team at <a href="mailto:info@canexp.com">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773133014">1-877-333-3014</a> </p>


# Canadian Exports Team
@endcomponent --}}


@component('mail::message')


# Hello {{$data['name'] ?? ''}},

Thank you for joining Canadian Exports!

Keeping your account secure is important to us. As a security measure, please click this link to verify your email address

@php
$encryptedEmail = str_replace('/', '===', $data['user_id']);
@endphp

<x-mail::button :url="route('front.customer-verify-email', ['email' => $data['email'], 'id' => $encryptedEmail, 'status' => 'active'])" color="primary">
    Verify email
</x-mail::button>

If your browser does not permit you to click the link above, please copy and paste this URL into your web browser's address bar
<!-- <a href="{{route('front.customer-verify-email', ['email' => $data['email'], 'id' => $encryptedEmail, 'status' => 'active'])}}">
    {{route('front.customer-verify-email', ['email' => $data['email'], 'id' => $encryptedEmail, 'status' => 'active'])}}
</a> -->
<a
    href="{{ route('front.customer-verify-email', ['email' => $data['email'], 'id' => $encryptedEmail, 'status' => 'active']) }}"
    target="_blank"
    rel="noopener noreferrer">
    {{ route('front.customer-verify-email', ['email' => $data['email'], 'id' => $encryptedEmail, 'status' => 'active']) }}
</a>

Once you've verified your email and completed your registration, you will have full access to your account and can start enjoying all the benefits of being a Canadian Exports member

**Note**: If you did not create an account with us or did not request this verification, please disregard this email. Your information will remain secure

Thank you and have a great day

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
<p style="text-align: justify;color: #000;margin-bottom: 0;">
    Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST
</p>

@endcomponent