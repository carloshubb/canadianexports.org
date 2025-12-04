{{-- @component('mail::message')
# Financing program mail
<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Business Name      | {{$data['business_name']}}      |
| Name & Title       | {{$data['name_title']}}      |
| Email       | {{$data['email']}}      |
| Zipcode      | {{$data['zipcode']}}      |
| Year of incorporation      | {{$data['incorporation']}}      |
| Number of full-time employees      | {{$data['full_time_employees']}}      |
| Revenue last year      | {{$data['revenue_last_year']}}      |
| Company ownership      | {{$data['company_ownership']}}      |
| Needs and intentions      | {{$data['needs_intentions']}}      |
| Your primary industry      | {{$data['primary_industry']}}      |
</x-mail::table>


Thanks,<br>
{{ config('app.name') }}
@endcomponent --}}

@component('mail::message')
The following business needs a list of the financing programs on Canadian Exports website. Their details are
<x-mail::table>
| <span style="white-space: nowrap;">Field</span>                      | Details                      |
| -------------------------- | ---------------------------- |
| <span style="white-space: nowrap;">Business Name</span>              | {{$data['business_name']}}   |
| <span style="white-space: nowrap;">Person’s Name & Title</span>      | {{$data['name_title']}}      |
| <span style="white-space: nowrap;">Email</span>                      | {{$data['email']}}           |
| <span style="white-space: nowrap;">Date Submitted</span>             | {{ now()->toFormattedDateString() }} |
| <span style="white-space: nowrap;">Needs and Intentions</span>       | {{$data['needs_intentions']}}|
| <span style="white-space: nowrap;">Year of incorporation</span>       | {{$data['incorporation']}}      |
| <span style="white-space: nowrap;">Number of full-time employees</span>       | {{$data['full_time_employees']}}      |
| <span style="white-space: nowrap;">Revenue last year</span>       | {{$data['revenue_last_year']}}      |
| <span style="white-space: nowrap;">Company ownership</span>       | {{$data['company_ownership']}}      |
| <span style="white-space: nowrap;">Your primary industry</span>       |@foreach($data['primary_industry'] as $industry){{ $industry['category_name'] }}<br>@endforeach|
</x-mail::table>

Thanks,<br>
{{-- {{ config('app.name') }} --}}
# Canadian Exports Team

@endcomponent

