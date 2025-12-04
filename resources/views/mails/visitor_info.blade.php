@component('mail::message')
# Business Profile Stats Summary

## Stats Summary
- **Profile Visits**: {{ $statsSummary['overview'] }}
- **Contact Tab Visits**: {{ $statsSummary['contact'] }}
- **Contact Form Submitted**: {{ $statsSummary['send_message'] }}
- **Media Tab Visits**: {{ $statsSummary['media'] }}
- **CTA Button Clicks**: {{ $statsSummary['cta_click'] }}

## Detailed Stats
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Business Profile</th>
            <th>Action</th>
            <th>Location</th>
            <th>Browser</th>
            <th>Visit Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stats as $stat)
            <tr>
                <td>{{ $stat['customer_profile']['company_name'] }}</td>
                <td>{{ ucfirst($stat['type']) }}</td>
                <td>{{ $stat['visitor']['country'] }}, {{ $stat['visitor']['state'] }}, {{ $stat['visitor']['city'] }}</td>
                <td>{{ $stat['visitor']['browser'] }} {{ $stat['visitor']['browser_version'] }}</td>
                <td>{{ $stat['created_at'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

Thank you and have a great day!

# Canadian Exports Team
@endcomponent
