@component('mail::message')
The following FAQ was submitted on Canadian Exports website:

<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Name and title      | {{$data['name']}}      |
| Email      | {{$data['email']}}      |
| Question      | {{$data['message']}}      |
| Date Submitted | {{ now()->format('Y-m-d H:i:s') }} |
</x-mail::table>

{{-- {{ config('app.name') }} --}}
@endcomponent
