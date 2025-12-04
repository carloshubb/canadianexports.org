@component('mail::message')
A new user has registered an event on the Canadian Exports website with the following details:

{{-- ### Event Details: --}}
- **Event name:** {{ $company_name }}
- **Contact person's name:** {{ $contact_person_name }}
- **Email:** {{ $email }}
- **Date of registration:** {{ \Carbon\Carbon::parse($created_at)->format('F d, Y') }}
- **Price:** ${{ number_format($package_price, 2) }}
- **Membership package:** {{ ucfirst($package_type) }}
{{-- - **Expires On:** {{ \Carbon\Carbon::parse($end_date)->format('F d, Y') }} --}}

{{-- You may log in and edit your event details any time you want. --}}

{{-- <p style="text-align: justify;">Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a></p> --}}

{{-- <p style="text-align: justify;">Thank you and have a great day </p> --}}

{{-- # Canadian Exports Team --}}
@endcomponent
