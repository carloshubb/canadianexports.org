{{-- <x-mail::message>
@if($email_to == 'admin')
# New event has been created by {{$data['customer']['name'] ?? ""}}. Here are the event details:
@elseif($email_to == 'customer')
# Thank you for creating the event. Here are the event details:
@endif
<x-mail::table>
|       |          |
| ------------- |:-------------:|
| <strong>Event title</strong>      | {{$data['eventDetail'][0]['title'] ?? ""}}      |
| <strong>Country</strong>      | {{$data['eventDetail'][0]['country'] ?? ""}}      |
| <strong>City</strong>      | {{$data['eventDetail'][0]['city'] ?? ""}}      |
| <strong>Street name</strong>      | {{$data['eventDetail'][0]['street_name'] ?? ""}}      |
| <strong>Venue</strong>      | {{$data['eventDetail'][0]['venue'] ?? ""}}      |
</x-mail::table>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}
<x-mail::message>
@if($email_to == 'admin')

Hello {{$data['customer']['name'] ?? ""}},

Thank you for registering your event **"{{$data['eventDetail'][0]['title'] ?? ""}}"** on the Canadian Exports platform. Here is your invoice:

@elseif($email_to == 'customer')
# Your Event Registration Details

Hello {{$data['customer']['name'] ?? ""}},

Thank you for registering your event **"{{$data['company_name'][0]['title'] ?? ""}}"** on the Canadian Exports platform. Here is your invoice:
@endif

<x-mail::table>
|       |          |
| ------------- |:-------------:|
| <strong>Event name</strong>      | {{$data['company_name'][0]['title'] ?? ""}}      |
| <strong>Membership package</strong>      | {{$data['package_type'] ?? "N/A"}}      |
| <strong>Price</strong>      | ${{$data['package_price'] ?? "0.00"}}      |
| <strong>Registered on</strong>      | {{$data['created_at'] ?? ""}}      |
| <strong>Expires on</strong>      | {{$data['end_date'] ?? ""}}      |
</x-mail::table>


<p style="text-align: justify;">Note: If you did not register with us, or believe that this email has reached you in error, please contact us as soon as possible</p>

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
</x-mail::message>
