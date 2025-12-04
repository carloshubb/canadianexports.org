@component('mail::message')
# Contact for the current rates
<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Name      | {{$data['name']}}      |
| Business name      | {{$data['business_name']}}      |
| Phone      | {{$data['phone']}}      |
| Email      | {{$data['email']}}      |
| Message      | {{$data['message']}}      |
</x-mail::table>


Thanks,<br>
{{-- {{ config('app.name') }} --}}
@endcomponent
