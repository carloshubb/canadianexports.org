# Email Templates Preview Guide

This guide explains how to preview and test the beautiful email templates that have been created.

## 📧 Available Templates

Three beautiful email template layouts have been created:

1. **Regular Email Template** - For general emails (welcome, notifications, etc.)
2. **Receipt Template** - For payment confirmations
3. **Invoice Template** - For invoices

## 🚀 How to Preview Templates

### Option 1: Using Preview Routes (Recommended)

The preview routes are automatically available in **local/development** environment.

1. **Access the preview index page:**
   ```
   http://your-domain.test/preview-email
   ```
   
   This will show a beautiful dashboard with links to all available templates.

2. **Direct template previews:**
   - Regular Email: `http://your-domain.test/preview-email/regular`
   - Invoice: `http://your-domain.test/preview-email/invoice`
   - Event Invoice: `http://your-domain.test/preview-email/event-invoice`
   - Receipt: `http://your-domain.test/preview-email/receipt`
   - Inquiry: `http://your-domain.test/preview-email/inquiry`

### Option 2: Send Test Emails

You can also send actual test emails using Laravel's mail system:

```php
use App\Mail\CustomerWelcomeMail;
use Illuminate\Support\Facades\Mail;

// Send a test welcome email
Mail::to('your-email@example.com')->send(new CustomerWelcomeMail([
    'name' => 'Test User',
    'email' => 'test@example.com',
]));
```

### Option 3: Use Laravel Mail Testing

In your `.env` file, configure mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@canadianexports.org
MAIL_FROM_NAME="${APP_NAME}"
```

Then use Mailtrap or similar service to catch and preview emails.

## 📁 Template Locations

- **Layouts:** `resources/views/mails/layouts/`
  - `regular.blade.php` - Regular email layout
  - `receipt.blade.php` - Receipt layout
  - `invoice.blade.php` - Invoice layout

- **Templates:** `resources/views/mails/`
  - `customer-welcome.blade.php` - Uses regular layout
  - `registration-invoice-to-customer.blade.php` - Uses invoice layout
  - `event-creation-invoice.blade.php` - Uses invoice layout
  - `inquiry.blade.php` - Uses regular layout

- **Examples:** `resources/views/mails/examples/`
  - Example templates showing how to use each layout

## 🎨 Template Features

All templates include:
- ✅ Beautiful gradient headers
- ✅ Responsive design (mobile-friendly)
- ✅ Professional styling
- ✅ Footer links (Help & Contact, Terms of use, Coffee on the Wall)
- ✅ Support contact information
- ✅ Consistent branding

## 🔧 Using Templates in Your Code

To use these templates in new mail classes:

```php
// For regular emails
return $this->view('mails.your-template')
    ->subject('Your Subject')
    ->with('data', $data);

// Make sure your template extends the layout:
// @extends('mails.layouts.regular')
```

## ⚠️ Important Notes

1. **Preview routes are only available in local/development environment** for security reasons.
2. **Production environment** will not have these routes accessible.
3. All templates maintain backward compatibility with existing content.
4. Templates use `view()` method instead of `markdown()` for better HTML control.

## 🐛 Troubleshooting

If preview routes don't work:
1. Make sure you're in `local` or `development` environment
2. Clear route cache: `php artisan route:clear`
3. Check that `routes/email-preview.php` is being loaded in `routes/web.php`

## 📝 Testing Checklist

- [ ] Preview all templates in browser
- [ ] Test responsive design (mobile view)
- [ ] Verify all links work correctly
- [ ] Check email rendering in different email clients
- [ ] Test with actual email sending (Mailtrap/Gmail)
- [ ] Verify footer information is correct
- [ ] Check that all dynamic content displays properly
