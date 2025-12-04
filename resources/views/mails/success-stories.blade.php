@component('mail::message')
The following Success story was submitted on Canadian Exports website:

<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Name and title     | {{$data['name']}}      |
| Email      | {{$data['email']}}      |
| Company name      | {{$data['company_name']}}      |
| Business category      | {{$data['business_category']}}      |
| Story      | {{$data['message']}}      |
| Date Submitted | {{ now()->format('Y-m-d H:i:s') }} |
</x-mail::table>

{{-- {{ config('app.name') }} --}}
@endcomponent
