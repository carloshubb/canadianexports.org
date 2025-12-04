{{-- @component('mail::message')
Hello {{$data['name']}},

<p style="text-align: justify;">Thank you for registering with Canadian Exports</p>
<p style="text-align: justify;">It's great to have you with us! Now that you are part of the family, you are welcome to contact us at any stage of the exporting process. There are many benefits to registering with us: </p>
<ul>
    <li><strong>Leads, Leads, and more Leads:</strong> as the leading service provider for Canadian exporters and international importers, we will generate enough leads for you to keep your sales department more than busy</li>
    <li><strong>Special rates and discounts:</strong> when you sign up with us, we will do our best to bring you the best deals. Our special relationship with multiple export-related service providers ensures you can benefit from special rates and discounts available only to our members</li>
    <li><strong>Financing programs:</strong> upon your request, we will generate a comprehensive list of loans, grants, tax credits, guarantees and advisors. We select them from your region, in your industry (business category), and for a business of your size. These programs cover part or all of your export-related expenses</li>
    <li><strong>Live customer support:</strong> Monday to Friday, between 09:00 and 17:00 EST. Feel free to contact our export consultants, who are here to help make your business grow</li>
    <li><strong>Periodical report</strong> on how your business profile with us is doing; a personalized report about the activity on your profile page, that includes the number of visitors, their locations, bounce rate, conversion rate, and other vital information for your business</li>
    <li><strong>Competition analysis:</strong> we also provide you with a detailed report of how other members in your business category are doing in relation to the same parameters</li>
    <li>You will enjoy many more exclusive benefits as a member of Canadian Exports. Check out our website for regular updates</li>
</ul>
@isset($data['reset_password'])
<p style="text-align: justify;">Click on the following link to reset your password:</p>
<x-mail::button :url="route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])" color="success">
Reset password
</x-mail::button>
<p style="text-align: justify;"><strong>Note:</strong> If you are unable to click on the link, please copy and paste it into your web browser's address bar. <a href="{{route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])}}">{{route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])}}</a></p>
@endisset
<p style="text-align: justify;">If you have any questions or need further assistance, please contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a></p>
<p style="text-align: justify;">This email was sent from an outgoing-only address that cannot accept incoming emails. If you haven't found information you are looking for, or if you still have questions, please visit our website to access general information, frequently asked questions, contact us information, and more</p>

# Canadian Exports Team
@endcomponent --}}


@component('mail::message')
Hello {{$data['name']}},

<p style="text-align: justify;">Thank you for registering your exporter profile on the Canadian Exports platform</p>
<p style="text-align: justify;">As a new member, we want you to know that you are welcome to contact us with any difficulties you may experience in the exporting process. We are also excited to share some of the benefits you can expect to enjoy, just because you registered:</p>

<ul>
    <li><strong>Leads, leads, and more leads:</strong> As a member of the leading service provider linking Canadian exporters with international importers, your sales department will be very busy dealing with all the leads we generate</li>
    <li><strong>Special rates and discounts:</strong> You will be getting the best deals around by signing up with us. Our unique relationships with a myriad of export-related service providers ensure you can benefit from special rates and discounts available exclusively to Canadian Exports members</li>
    <li><strong>Financing programs:</strong> Financing that covers part or all of your export-related expenses, from service providers that specialize in your particular region, type of business, and business size, can be easily identified through lists that we will provide at your request</li>
    <li><strong>Live customer support:</strong> Supporting your business on its growth trajectory, our expert export-promotion consultants are available from Monday to Friday, between 09:30 and 17:00 EST. Feel free to contact us when you need assistance</li>
    <li><strong>Performance reports:</strong> Measuring progress on your exporter profile, we deliver a detailed report about the activity on your profile page. You will have full insight into the number of visitors and their locations, the bounce rate, conversion rate, and other data vital for your business to thrive</li>
    <li><strong>Competition analysis:</strong> In addition to a better understanding of your exporter profile’s performance, our detailed competitor report gives insight into how similar members in your business category are faring on the same parameters</li>
    <li><strong>Members-only advantages:</strong> More exclusive benefits to Canadian Exports members are made available regularly. Look out for them on our website</li>
</ul>

@isset($data['reset_password'])
<p style="text-align: justify;">Click on the following link to reset your password:</p>
<x-mail::button :url="route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])" color="primary">
Reset password
</x-mail::button>
<p style="text-align: justify;"><strong>Note:</strong> If you are unable to click on the link, please copy and paste it into your web browser's address bar. <a href="{{route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])}}">{{route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])}}</a></p>
@endisset

<p style="text-align: justify;">Our team is keen to deal with any questions, queries, or issues you could be having with exporting. Please call us at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST. We look forward to supporting you in your export venture</p>


<p style="text-align: justify;">Thank you and have a great day </p>
# Canadian Exports Team

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
