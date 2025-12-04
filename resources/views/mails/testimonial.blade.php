@component('mail::message')
The following Testimonial was submitted on Canadian Exports website:

<x-mail::table>
|        |          |
| ------------- |:-------------:|
| <span style="white-space: nowrap;">Name and title</span>      | {{$data['name']}}      |
| <span style="white-space: nowrap;">Email</span>       | {{$data['email']}}      |
| <span style="white-space: nowrap;">Company name</span>       | {{$data['company_name']}}      |
| <span style="white-space: nowrap;">Business category</span>       | {{$data['business_category']}}      |
| <span style="white-space: nowrap;">Testimonial</span>       | {{$data['message']}}      |
| <span style="white-space: nowrap;">Date Submitted</span>  | {{ now()->format('Y-m-d H:i:s') }} |
</x-mail::table>

{{-- {{ config('app.name') }} --}}
@endcomponent
