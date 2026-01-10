@extends('mails.layouts.invoice')

@section('content')
    <h2>Hello {{ $data['customer']['name'] ?? $data['name'] ?? 'Customer' }},</h2>
    
    <p>Thank you for your registration. Please find your invoice details below.</p>
    
    <div class="invoice-box">
        <div class="invoice-header">
            <div class="invoice-info">
                <h3>{{ config('app.name') }}</h3>
                <p>Invoice Date: {{ $data['created_at'] ?? date('F d, Y') }}</p>
                <p>Due Date: {{ $data['end_date'] ?? date('F d, Y', strtotime('+30 days')) }}</p>
            </div>
            <div class="invoice-number">
                <div class="invoice-label">Invoice Number</div>
                <div class="invoice-value">{{ $data['order']['invoice_no'] ?? 'INV-' . date('Ymd') }}</div>
            </div>
        </div>
        
        <div class="invoice-items">
            <div class="invoice-item">
                <span class="invoice-item-label">Membership Package:</span>
                <span class="invoice-item-value">{{ $data['package_type'] ?? 'N/A' }}</span>
            </div>
            @if(isset($data['eventDetail']) || isset($data['company_name']))
            <div class="invoice-item">
                <span class="invoice-item-label">Event/Business Name:</span>
                <span class="invoice-item-value">{{ $data['company_name'][0]['title'] ?? $data['eventDetail'][0]['title'] ?? 'N/A' }}</span>
            </div>
            @endif
            <div class="invoice-item">
                <span class="invoice-item-label">Registered On:</span>
                <span class="invoice-item-value">{{ $data['created_at'] ?? date('F d, Y') }}</span>
            </div>
            <div class="invoice-item">
                <span class="invoice-item-label">Expires On:</span>
                <span class="invoice-item-value">{{ $data['end_date'] ?? 'N/A' }}</span>
            </div>
        </div>
        
        <div class="invoice-totals">
            <div class="invoice-total-row">
                <span class="invoice-total-label">Subtotal:</span>
                <span class="invoice-total-value">${{ number_format($data['package_price'] ?? 0, 2) }}</span>
            </div>
            <div class="invoice-total-row">
                <span class="invoice-total-label">Tax:</span>
                <span class="invoice-total-value">$0.00</span>
            </div>
            <div class="invoice-total-row grand-total">
                <span class="invoice-total-label">Total Amount:</span>
                <span class="invoice-total-value">${{ number_format($data['package_price'] ?? 0, 2) }}</span>
            </div>
        </div>
    </div>
    
    <div class="invoice-note">
        <p><strong>Note:</strong> If you did not register with us, or believe that this email has reached you in error, please contact us as soon as possible.</p>
    </div>
    
    <p>Thank you for your registration. We look forward to serving you!</p>
    
    <p><strong>Canadian Exports Team</strong></p>
@endsection
