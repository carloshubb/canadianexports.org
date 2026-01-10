@extends('mails.layouts.regular')

@section('content')
    <h2>Hello {{ $data['name'] ?? 'User' }},</h2>
    
    <p>Thank you for registering your exporter profile on the Canadian Exports platform.</p>
    
    <p>As a new member, we want you to know that you are welcome to contact us with any difficulties you may experience in the exporting process. We are also excited to share some of the benefits you can expect to enjoy, just because you registered:</p>
    
    <ul>
        <li><strong>Leads, leads, and more leads:</strong> As a member of the leading service provider linking Canadian exporters with international importers, your sales department will be very busy dealing with all the leads we generate</li>
        <li><strong>Special rates and discounts:</strong> You will be getting the best deals around by signing up with us. Our unique relationships with a myriad of export-related service providers ensure you can benefit from special rates and discounts available exclusively to Canadian Exports members</li>
        <li><strong>Financing programs:</strong> Financing that covers part or all of your export-related expenses, from service providers that specialize in your particular region, type of business, and business size, can be easily identified through lists that we will provide at your request</li>
        <li><strong>Live customer support:</strong> Supporting your business on its growth trajectory, our expert export-promotion consultants are available from Monday to Friday, between 09:30 and 17:00 EST. Feel free to contact us when you need assistance</li>
        <li><strong>Performance reports:</strong> Measuring progress on your exporter profile, we deliver a detailed report about the activity on your profile page. You will have full insight into the number of visitors and their locations, the bounce rate, conversion rate, and other data vital for your business to thrive</li>
        <li><strong>Competition analysis:</strong> In addition to a better understanding of your exporter profile's performance, our detailed competitor report gives insight into how similar members in your business category are faring on the same parameters</li>
        <li><strong>Members-only advantages:</strong> More exclusive benefits to Canadian Exports members are made available regularly. Look out for them on our website</li>
    </ul>
    
    @isset($data['reset_password'])
    <p>Click on the following link to reset your password:</p>
    <a href="{{ route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']]) }}" class="email-button">Reset password</a>
    <p><strong>Note:</strong> If you are unable to click on the link, please copy and paste it into your web browser's address bar.</p>
    @endisset
    
    <p>Our team is keen to deal with any questions, queries, or issues you could be having with exporting. Please call us at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST. We look forward to supporting you in your export venture.</p>
    
    <p>Thank you and have a great day!</p>
    
    <p><strong>Canadian Exports Team</strong></p>
@endsection
