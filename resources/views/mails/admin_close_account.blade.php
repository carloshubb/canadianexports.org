@component('mail::message')
<p style="text-align: justify;">A user has closed their account on the Canadian Exports website. Here are their details:</p>
<ul>
    <li><strong>The company name:</strong> {{ $emailData['company_name'] }}</li>
    <li><strong>Contact person name:</strong> {{ $emailData['name'] }}</li>
    <li><strong>Email:</strong> {{ $emailData['email'] }}</li>
    <li><strong>Message:</strong> {{ $emailData['message'] }}</li>
    <li><strong>Account Closed Date:</strong> {{ $emailData['account_closed_date'] }}</li>
</ul>

# Canadian Exports Team
@endcomponent
