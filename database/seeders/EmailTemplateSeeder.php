<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    public function run()
    {
        $defaults = [
            [
                'key' => 'contact_us_admin',
                'name' => 'Contact Us (Admin Notification)',
                'subject' => 'New contact form submission',
                'body_html' => '@component(\'mail::message\')
<p>You have a new contact submission.</p>
<p><strong>Name:</strong> {{ $data[\'name\'] ?? $name ?? \'N/A\' }}<br>
<strong>Email:</strong> {{ $data[\'email\'] ?? $email ?? \'N/A\' }}<br>
<strong>Message:</strong> {{ $data[\'message\'] ?? $message ?? \'N/A\' }}</p>
@endcomponent',
            ],
            [
                'key' => 'auto_response_to_customer',
                'name' => 'Auto Response to Customer',
                'subject' => 'Your message has been received',
                'body_html' => '@component(\'mail::message\')
<p>Hi {{ $data[\'name\'] ?? $name ?? \'Customer\' }},</p>
<p>Thanks for contacting us. We have received your message and will get back to you.</p>
<p>Have a great day!</p>
@endcomponent',
            ],
            [
                'key' => 'customer_verify_email',
                'name' => 'Customer Verify Email',
                'subject' => 'Verify your email address. Complete your registration',
                'body_html' => '@component(\'mail::message\')
<p>Hi {{ $data[\'name\'] ?? $name ?? \'Customer\' }},</p>
<p>Please verify your email by clicking the link below:</p>
<p><a href="{{ $data[\'verification_link\'] ?? $verification_link ?? \'#\' }}">Verify Email</a></p>
@endcomponent',
            ],
            // Complex example showing conditionals, PHP blocks, and date formatting
            [
                'key' => 'admin_membership_expiry',
                'name' => 'Admin Membership Expiry Reminder',
                'subject' => 'Membership Expiry Reminder',
                'body_html' => '@component(\'mail::message\')
Hello,
@php
$packagePrice = isset($data[\'package\'][\'discount_price\']) && $data[\'package\'][\'discount_price\'] > 0 
    ? $data[\'package\'][\'discount_price\'] 
    : ($data[\'package\'][\'price\'] ?? 0);
$packageName = (isset($data[\'package\'][0][\'package_detail\'][\'amount_pre_text\']) 
    ? $data[\'package\'][0][\'package_detail\'][\'amount_pre_text\'] : \'\') 
    . \'$\' . $packagePrice 
    . (isset($data[\'package\'][0][\'package_detail\'][\'amount_post_text\']) 
        ? $data[\'package\'][0][\'package_detail\'][\'amount_post_text\'] : \'\');
@endphp
<p style="text-align: justify;">
This is a reminder that {{ $data[\'customer\'][\'name\'] ?? \'Customer\' }}\'s {{ $packageName }} subscription 
is set to expire on {{ date(\'F d, Y\', strtotime($data[\'customer\'][\'package_expiry_date\'] ?? \'now\')) }}.
</p>
@endcomponent',
            ],
            // Become Sponsor Email - Complex example with conditionals and tables
            [
                'key' => 'become_sponsor_admin',
                'name' => 'Become Sponsor (Admin Notification)',
                'subject' => 'A user is interested in becoming a Sponsor on Canadian Exports website',
                'body_html' => '@component(\'mail::message\')

{{-- ## From: {{$data["email"]}} --}}
<p style="text-align: justify;">A user is interested in becoming a Sponsor on Canadian Exports website. Here are their details:</p>

<x-mail::table>
|              |                            |
| ---------------------- | --------------------------------------- |
| Company name       | {{$data[\'company_name\']}}               |
| Name               | {{$data[\'name\']}}                       |
| Email              | {{$data[\'email\']}}                      |
| Website            | {{$data[\'url\']}}                        |
| Phone              | {{$data[\'contact_number\']}}             |
| Best time to call  | {{$data[\'time_to_call\']}}               |
| Set an appointment?| {{$data[\'appointment\']}}                |
@if(isset($data[\'appointment\']) && $data[\'appointment\'] === \'yes\')
| Appointment date   | {{date(\'F d, Y\', strtotime($data[\'appointment_date\']))}} |
@endif
| Summary            | {{$data[\'summary\']}}                    |
| Detail description | {{$data[\'detail_description\']}}         |
| Message            | {{$data[\'message\']}}                    |
| Date Submitted     | {{ date(\'F d, Y\') }}                    |
</x-mail::table>

Thanks,<br>
{{-- {{ config(\'app.name\') }} --}}
@endcomponent',
            ],
        ];

        foreach ($defaults as $tpl) {
            EmailTemplate::updateOrCreate(
                ['key' => $tpl['key']],
                [
                    'name' => $tpl['name'],
                    'subject' => $tpl['subject'],
                    'body_html' => $tpl['body_html'],
                    'is_active' => true,
                ]
            );
        }
    }
}



