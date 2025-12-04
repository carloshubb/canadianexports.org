@component('mail::message')
# Contact mail
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

