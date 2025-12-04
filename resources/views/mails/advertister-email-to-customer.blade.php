{{-- @component('mail::message')
<p style="text-align: justify;">*** This is an automatically generated email, please do not reply ***</p>

Hello,

<p style="text-align: justify;">Your message has been successfully delivered to the exporter </p>
<p style="text-align: justify;">Thank you for your interest</p>

# Canadian Exports Team
@endcomponent --}}


@component('mail::message')

<p style="text-align: justify;">
    This is a friendly email to confirm that your message to <strong>{{ $customerProfile->company_name }}</strong> has been delivered
</p>
{{-- ***************************************************
<p style="text-align: justify;">{{ $data['message'] }}</p>

*************************************************** --}}


<p style="text-align: justify;">
Note: If you believe this email has reached you in error, please contact us as soon as possible
</p>

<p style="text-align: justify;">
Thank you and have a good day
</p>

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

{{-- @component('mail::message')
Hello,

<p style="text-align: justify;">
    You have received a new message from your exporter profile on Canadian Exports:
</p>

***************************************************

**Sender’s Name and Title:** {{ $data['name'] }}

**Their Company Name:** {{ $data['company_name'] }}

**Their Email:** {{ $data['email'] }}

**Message:** {{ $data['message'] }}

***************************************************

<p style="text-align: justify;">
Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at 1-877-333-3014, Monday to Friday, between 9:30am and 5pm EST
</p>

<p style="text-align: justify;">
Note: If you believe this email has reached you in error, please contact us as soon as possible
</p>

<p style="text-align: justify;">
Thank you and have a good day
</p>

# Canadian Exports Team
@endcomponent --}}
