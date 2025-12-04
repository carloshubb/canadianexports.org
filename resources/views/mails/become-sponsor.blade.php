@component('mail::message')

{{-- ## From: {{$data["email"]}} --}}
<p style="text-align: justify;">A user is interested in becoming a Sponsor on Canadian Exports website. Here are their details:</p>

<x-mail::table>
|              |                            |
| ---------------------- | --------------------------------------- |
| Company name       | {{$data['company_name']}}               |
| Name               | {{$data['name']}}                       |
| Email              | {{$data['email']}}                      |
| Website            | {{$data['url']}}                        |
| Phone              | {{$data['contact_number']}}             |
| Best time to call  | {{$data['time_to_call']}}               |
| Set an appointment?| {{$data['appointment']}}                |
@if(isset($data['appointment']) && $data['appointment'] === 'yes')
| Appointment date   | {{date('F d, Y', strtotime($data['appointment_date']))}} |
@endif
| Summary            | {{$data['summary']}}                    |
| Detail description | {{$data['detail_description']}}         |
| Message            | {{$data['message']}}                    |
| Date Submitted     | {{ date('F d, Y') }}                    |
</x-mail::table>

Thanks,<br>
{{-- {{ config('app.name') }} --}}
@endcomponent


{{-- @component('mail::message')
# Thank you for your interest in becoming a Sponsor

Hello {{$data['name']}},

This is a friendly email to thank you for showing interest in becoming a sponsor, and in supporting Canadian small businesses, young start-ups, and family-owned enterprises. Your generosity helps maintain most of our offers, resources, and services to the Canadian small businesses, free-of-charge, ensuring that Canadian businesses receive the support they need to thrive in a competitive global market.

We will contact you on the date and time you selected. Until then, may success and good health stay on your side.

Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST.

Thank you again and have a great day ahead,
Canadian Exports Team
@endcomponent --}}
