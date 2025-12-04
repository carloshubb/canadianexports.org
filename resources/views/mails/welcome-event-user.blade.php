@component('mail::message')
Thank you for registering your event {{ $data['event_name'] }} on the Canadian Exports platform. It is now live and users from all around the world can view it

### Event details:
<ul>
    <li><strong>Event name:</strong> {{$data['event_name']}}</li>
    <li><strong>Package:</strong> {{$data['package_name']}}</li>
    <li><strong>Package price:</strong> ${{ number_format((isset($data['package_price']) ? $data['package_price'] : 0), 2) }}</li>
    <li><strong>Registered On:</strong> {{ date('F d, Y') }}</li>
    <li><strong>Expires On:</strong> {{ date('F d, Y', strtotime('+1 months')) }}</li>
</ul>

You may log in and edit your event details any time you want.

Note: If you did not register with us, or believe that this email has reached you in error, please contact us as soon as possible

<p style="text-align: justify;">Thank you and have a good day </p>

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
<p style="text-align: justify;color: #000;margin-bottom: 0;">Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a></p>
@endcomponent
