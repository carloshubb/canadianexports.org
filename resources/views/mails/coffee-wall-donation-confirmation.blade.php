@component('mail::message')

# Hi {{ $donorName }},

Thank you for your generous Coffee on the Wall donation. Your kindness helps support Canadian small businesses and makes a real difference in our community.

**Donation amount:** ${{ $amount }}

**Date:** {{ $donationDate }}

Your Coffee is now on the wall. When it is enjoyed by a small business, we may notify you if you selected that option.

Thank you for spreading warmth and generosity.

Warmly,<br>
**The Coffee on the Wall Team**

<table style="margin-bottom: 24px; margin-top: 16px; width: 100%" cellpadding="0" cellspacing="0" role="none">
    <tr>
        <td align="center" style="display: flex;">
            <div style="display: flex; margin: 0 auto;">
                <a aria-label="Help & Contact" target="_blank" href="{{ env('APP_URL') }}/en/contact-us" style="border-right: 1px solid #000; text-decoration: none; font-weight: 600; color: #000; white-space: nowrap; padding-right: 16px; padding-left: 16px;">
                    Help & Contact
                </a>
                <a aria-label="Terms of use" target="_blank" href="{{ env('APP_URL') }}/en/terms-and-conditions" style="border-right: 1px solid #000; text-decoration: none; font-weight: 600; color: #000; white-space: nowrap; padding-right: 16px; padding-left: 16px;">
                    Terms of use
                </a>
                <a aria-label="Coffee on the Wall" target="_blank" href="{{ env('APP_URL') }}/en/coffee-on-the-wall" style="text-decoration: none; font-weight: 600; color: #000; white-space: nowrap; padding-right: 16px; padding-left: 16px;">
                    Coffee on the Wall
                </a>
            </div>
        </td>
    </tr>
</table>
<div style="border: 1px dashed #000; width: 100%; margin-bottom: 10px;"></div>
<p style="text-align: justify; color: #000; margin-bottom: 0;">
Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST.
</p>

@endcomponent
