@component('mail::message')
The following scam alert was submitted on Canadian Exports website:

<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Name and title      | {{$data['name']?? "N/A"}}      |
| Email      | {{$data['email']?? "N/A"}}      |
| Message      | {{$data['message']}}      |
| Date Submitted | {{ now()->format('Y-m-d H:i:s') }} |
</x-mail::table>

{{-- {{ config('app.name') }} --}}
@endcomponent
