{{-- @component('mail::message')
Hello,

<p style="text-align: justify;">We have received a request to reset your password for your Canadian Exports account. To proceed with the password reset process, please click on the following link:</p>
<x-mail::button :url="route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])" color="success">
Reset your password
</x-mail::button>
<p style="text-align: justify;">If your browser does not permit you to click the link above, please copy and paste this URL into your web browser's address bar:<br /> <a href="{{route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])}}">{{route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])}}</a></p>
<p style="text-align: justify;">You will be redirected to a page where you can enter a new password</p>
<p style="text-align: justify;">For security purposes, we recommend choosing a strong password that contains a combination of letters, numbers, and special characters</p>
<p style="text-align: justify;">If you did not initiate this password reset request, please ignore this email. Your account will remain secure</p>
<p style="text-align: justify;">If you have any questions or need further assistance, please contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a></p>
<p style="text-align: justify;">This email was sent from an outgoing-only address that cannot accept incoming emails. If you haven't found information you are looking for, or if you still have questions, please visit our website to access general information, frequently asked questions, contact us information, and more</p>


# Canadian Exports Team
@endcomponent --}}

@component('mail::message')
# Hello {{ $data['name'] ?? 'User' }},

<p style="text-align: justify;">We have received a request to reset your password for your Canadian Exports account. To proceed with this process, please click on the following link:</p>

<x-mail::button :url="route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])" color="primary">
Reset your password
</x-mail::button>

<p style="text-align: justify;">If your browser does not permit you to click on the link above, please copy and paste this URL into your web browser's address bar:</p>
<p><a href="{{route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])}}">{{route('password.reset', ['abbreviation' => $data['lang']['abbreviation'], 'token' => $data['token'], 'validity' => (isset($data['is_admin']) ? $data['is_admin'] : ''), 'email' => $data['email']])}}</a></p>

<p style="text-align: justify;">You will be redirected to a page where you can select a new password</p>

<p style="text-align: justify;">Passwords on Canadian Exports must contain a minimum of eight characters, with at least one uppercase and one lowercase. For higher security, we recommend using a combination of letters, numbers, and special characters</p>

<p style="text-align: justify;">Note: If you did not initiate a password reset process, please disregard this email. Your information will remain secure</p>

<p style="text-align: justify;">Thank you and have a good day</p>

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
<p style="text-align: justify;color: #000;margin-bottom: 0;">Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST</p>
@endcomponent

