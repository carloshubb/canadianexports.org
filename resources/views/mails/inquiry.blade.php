{{-- @component('mail::message')
Hello {{$data["name"]}}

<p style="text-align: justify;">We hope you are having a wonderful day. Here is the “Inquiry to buy” you requested on the Canadian Exports website </p>
<p style="text-align: justify;">Thank you for using our services, and we hope to be able to serve you again in the future </p>
<p style="text-align: justify;">If you have any questions or need further assistance, please contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a> </p>
<p style="text-align: justify;">This email was sent from an outgoing-only address that cannot accept incoming emails. If you haven't found information you are looking for, or if you still have questions, please visit our website to access general information, frequently asked questions, contact us information, and more</p> --}}
{{-- # from {{$data["company_name"]}} email : {{$data['company_email']}}
{{ $data["inquiry_detail"] }} --}}

{{-- # Canadian Exports Team
@endcomponent --}}
{{-- @component('mail::message')
# Hello {{$data["name"]}},

<p style="text-align: justify;">Please find attached the details on the Inquiries to buy that you asked for</p>

<p style="text-align: justify;">We wish you success in your business. If you need further assistance, feel free to contact us any time. We are here to help</p>

<p style="text-align: justify;">Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST</p>

<p style="text-align: justify;">Note: If you believe this email has reached you in error, please disregard it. Your information will remain secure</p>

Thank you and have a good day

# Canadian Exports Team
@endcomponent --}}

@component('mail::message')
# Hello {{$data["name"]}},

<p style="text-align: justify;">
    Please find attached the details on the Inquiries to buy that you asked for
</p>

## Inquiry Details:
- **Business Category:** {{$data["business_category"]}}
- **Deadline Date:** {{$data["deadline_date"]}}
- **Estimated Value:** {{$data["estimated_value"]}}

@if(!empty($data['inquiry_details']))
### Inquiry Contacts:
@foreach(collect($data['inquiry_details'])->filter(fn($detail) => !empty($detail['name']) && $detail['name'] !== 'N/A')->all() as $detail)
- **Name:** {{$detail['name']}}
- **Country:** {{$detail['country']}}
@endforeach
@endif

<p style="text-align: justify;">
    We wish you success in your business. If you need further assistance, feel free to contact us anytime
</p>

<p style="text-align: justify;">
    Note: If you believe this email has reached you in error, please disregard it. Your information will remain secure
</p>

Thank you and have a good day

**Canadian Exports Team**

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
    Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at 
    <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> 
    or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST
</p>

@endcomponent
