@component('mail::message')
# Comments / Suggestions mail
## From {{$data["email"]}}
<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Name      | {{$data['name']}}      |
| Email      | {{$data['email']}}      |
| Message      | {{$data['message']}} |
</x-mail::table>

Thanks,<br>
{{-- {{ config('app.name') }} --}}
@endcomponent



 {{-- @component('mail::message')
# Thank you for your comments / suggestions

<p>This is a friendly email to confirm that we have received your comments / suggestions. We want to thank you for taking the time to help us improve, and to assure you that we will read your comments and suggestions, and do our best to implement them.</p>

<p>If you have requested a response, we will respond to you within two business days.</p>

<p>Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST.</p>

<p>Note: If you did not register with us, or believe that this email has reached you in error, please contact us as soon as possible.</p>

# Thank you again and have a good day,
# Canadian Exports Team
@endcomponent --}}
