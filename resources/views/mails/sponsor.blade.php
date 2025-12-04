@component('mail::message')
# Become a sponsor mail
## From {{$data["email"]}}
<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Contact number      | {{$data['contact_number']}}      |
| Message      | {{$data['message']}} |
| URL      | {{$data['url']}} |
</x-mail::table>
{{$data["image"]}}

Thanks,<br>
{{-- {{ config('app.name') }} --}}
@endcomponent
