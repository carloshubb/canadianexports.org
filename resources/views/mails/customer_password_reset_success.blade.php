@component('mail::message')

# Hello {{ $data['name'] }},
<p>This is an automated message to confirm that your password on Canadian Exports has been reset successfully</p>

<p>Important: If you did not initiate a password reset process, please contact us right away; we will take immediate measures to protect your account</p>

Thank you again and have a good day

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
<p style="text-align: justify;color: #000;margin-bottom: 0;">Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at 1-877-333-3014, Monday to Friday, between 9:30 am and 5 pm EST</p>
@endcomponent
