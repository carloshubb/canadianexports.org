@component('mail::message')
# Info letter mail
## From {{$data["email"]}}
<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Name      | {{$data['name']}}      |
| Company name      | {{$data['company_name']}} |
| Country      | {{$data['country']}} |
</x-mail::table>



Thanks,<br>
{{-- {{ config('app.name') }} --}}
@endcomponent

{{-- @component('mail::message')
# Welcome to Canadian Exports

Hello {{$data["name"]}},

We are glad to welcome you to Canadian Exports. It will be our pleasure to send you every new copy of the Canadian Exports Magazine; Canada’s export-promotion tool. If you need further help sourcing Canadian products and services, do not hesitate to contact us.

Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at **support@canadianexports.org** or call us toll-free at **1-877-333-3014**, Monday to Friday, between 9:30am and 5pm EST.

**Note:** If you believe this email has reached you in error, please disregard it. Your information will remain secure.

Thank you and have a good day,

**Canadian Exports Team**

@endcomponent --}}
