<?php

use Illuminate\Support\Facades\Route;
use App\Mail\RegistrationInvoiceToCustomerMail;
use App\Mail\EventCreationInvoiceMail;
use App\Mail\CustomerWelcomeMail;
use App\Mail\InquiryMail;

/*
|--------------------------------------------------------------------------
| Email Template Preview Routes
|--------------------------------------------------------------------------
|
| These routes allow you to preview email templates in your browser.
| Only accessible in local/development environment.
|
*/

if (app()->environment(['local', 'development'])) {
    
    // Preview Regular Email Template
    Route::get('/preview-email/regular', function () {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ];
        
        return new CustomerWelcomeMail($data);
    })->name('preview.email.regular');
    
    // Preview Invoice Template
    Route::get('/preview-email/invoice', function () {
        $data = [
            'customer' => [
                'name' => 'John Doe',
                'type' => 'customer',
            ],
            'order' => [
                'invoice_no' => 'INV-2024-001',
            ],
            'package_name' => 'Premium Package',
            'package_price' => 299.99,
            'package_validity' => '12 months',
            'payment_frequency' => 'annual',
            'package_expiry_date' => date('F d, Y', strtotime('+12 months')),
            'created_at' => date('F d, Y'),
        ];
        
        return new RegistrationInvoiceToCustomerMail($data);
    })->name('preview.email.invoice');
    
    // Preview Event Invoice Template
    Route::get('/preview-email/event-invoice', function () {
        $data = [
            'customer' => [
                'name' => 'Jane Smith',
            ],
            'company_name' => [
                ['title' => 'Tech Expo 2024'],
            ],
            'package_type' => 'Event Premium',
            'package_price' => 499.99,
            'created_at' => date('F d, Y'),
            'end_date' => date('F d, Y', strtotime('+6 months')),
        ];
        
        return new EventCreationInvoiceMail($data, 'customer');
    })->name('preview.email.event-invoice');
    
    // Preview Receipt Template (using example)
    Route::get('/preview-email/receipt', function () {
        $data = [
            'name' => 'John Doe',
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'payment_date' => date('F d, Y'),
            'payment_method' => 'Credit Card',
            'description' => 'Premium Membership Subscription',
            'amount' => 299.99,
        ];
        
        return view('mails.examples.receipt-example', compact('data'));
    })->name('preview.email.receipt');
    
    // Preview Inquiry Template
    Route::get('/preview-email/inquiry', function () {
        $data = [
            'name' => 'John Doe',
            'business_category' => 'Technology',
            'deadline_date' => date('F d, Y', strtotime('+30 days')),
            'estimated_value' => '$50,000',
            'inquiry_details' => [
                [
                    'name' => 'Contact Person 1',
                    'country' => 'Canada',
                ],
                [
                    'name' => 'Contact Person 2',
                    'country' => 'USA',
                ],
            ],
            'pdf_download_links' => [
                'pdf_1' => '#',
                'pdf_2' => '#',
            ],
        ];
        
        return view('mails.inquiry', compact('data'));
    })->name('preview.email.inquiry');
    
    // Preview all templates in a list
    Route::get('/preview-email', function () {
        $templates = [
            [
                'name' => 'Regular Email Template',
                'url' => route('preview.email.regular'),
                'description' => 'General purpose email template (welcome, notifications, etc.)',
            ],
            [
                'name' => 'Invoice Template',
                'url' => route('preview.email.invoice'),
                'description' => 'Invoice email template for registrations',
            ],
            [
                'name' => 'Event Invoice Template',
                'url' => route('preview.email.event-invoice'),
                'description' => 'Invoice email template for events',
            ],
            [
                'name' => 'Receipt Template',
                'url' => route('preview.email.receipt'),
                'description' => 'Payment receipt template',
            ],
            [
                'name' => 'Inquiry Template',
                'url' => route('preview.email.inquiry'),
                'description' => 'Inquiry email template',
            ],
        ];
        
        return view('mails.preview-index', compact('templates'));
    })->name('preview.email.index');
}
