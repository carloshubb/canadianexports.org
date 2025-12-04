@component('mail::message')
The following inquiry for Rates and information was submitted on Canadian Exports website:

<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Name and title     | {{$data['name']}}      |
| Email      | {{$data['email']}}      |
| Inquiry      | {{$data['message']}}      |
| Date submitted | {{ now()->format('Y-m-d H:i:s') }} |
</x-mail::table>

{{-- {{ config('app.name') }} --}}
@endcomponent
