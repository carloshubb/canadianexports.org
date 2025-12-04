@component('mail::message')
<p style="text-align: justify;">Further to our research for the available financing programs for a business of your size, in your region and industry, and for your needs and intentions, we found the attached list of programs. We hope it will help your business succeed and prosper </p>

<p style="text-align: justify;">Thank you and have a good day</p>
# Canadian Exports Team
<h1>Financing Programs List</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Business Name</th>
            <th>Email</th>
            <th>Company Ownership</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($financingPrograms as $program)
            @foreach ($program->financingProgramDetail as $detail)
                <tr>
                    <td>{{ $detail->name_title ?? '' }}</td>
                    <td>{{ $detail->business_name ?? '' }}</td>
                    <td>{{ $detail->email ?? '' }}</td>
                    <td>{{ $detail->company_ownership ?? '' }}</td>
                </tr>
            @endforeach
            @endforeach
        </tbody>
</table>

<table style="margin-bottom: 24px; margin-top: 16px; width: 100%" cellpadding="0" cellspacing="0" role="none">
    <tr>
        <td align="center" style="display: flex;">
            <div style="display: flex; margin: 0 auto;">
                <a aria-label="Proxima Study" target="_blank" href="{{ env('APP_URL') . '/en/contact-us' }}" style="border-right: 1px solid #000; text-decoration: none; font-weight: 600; color: #000; white-space: nowrap; padding-right: 16px; padding-left: 16px;">
                  Help & Contact
                </a>
                <a aria-label="Proxima Study" target="_blank" href="{{ env('APP_URL') . '/en/terms-and-conditions' }}" style="border-right: 1px solid #000; text-decoration: none; font-weight: 600; color: #000; white-space: nowrap; padding-right: 16px; padding-left: 16px;">
                    Terms of use
                </a>
                <a aria-label="Proxima Study" target="_blank" href="{{ env('APP_URL') . '/en/coffee-on-the-wall' }}" style="text-decoration: none; font-weight: 600; color: #000; white-space: nowrap; padding-right: 16px; padding-left: 16px;">
                    Coffee on the Wall
                </a>
            </div>
        </td>
    </tr>
</table>
<div style="border: 1px dashed #000;width: 100%; margin-bottom: 10px;"></div>
<p style="text-align: justify;color: #000;margin-bottom: 0;">Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a></p>
@endcomponent
