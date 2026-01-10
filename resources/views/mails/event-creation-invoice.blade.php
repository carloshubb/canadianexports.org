@extends('mails.layouts.invoice')

@section('content')
    @if($email_to == 'admin')
        <h2>Hello {{ $data['customer']['name'] ?? "" }},</h2>
        <p>Thank you for registering your event <strong>"{{ $data['eventDetail'][0]['title'] ?? "" }}"</strong> on the Canadian Exports platform. Here is your invoice:</p>
    @elseif($email_to == 'customer')
        <h2>Your Event Registration Details</h2>
        <p>Hello {{ $data['customer']['name'] ?? "" }},</p>
        <p>Thank you for registering your event <strong>"{{ $data['company_name'][0]['title'] ?? "" }}"</strong> on the Canadian Exports platform. Here is your invoice:</p>
    @endif

    <div class="invoice-box">
        <div class="invoice-header">
            <div class="invoice-info">
                <h3>{{ config('app.name') }}</h3>
                <p>Invoice Date: {{ $data['created_at'] ?? date('F d, Y') }}</p>
                @if(isset($data['end_date']))
                <p>Expires On: {{ $data['end_date'] }}</p>
                @endif
            </div>
            <div class="invoice-number">
                <div class="invoice-label">Invoice Number</div>
                <div class="invoice-value">{{ $data['order']['invoice_no'] ?? 'INV-' . date('Ymd') }}</div>
            </div>
        </div>
        
        <div class="invoice-items">
            @if(isset($data['company_name'][0]['title']))
            <div class="invoice-item">
                <span class="invoice-item-label">Event Name:</span>
                <span class="invoice-item-value">{{ $data['company_name'][0]['title'] }}</span>
            </div>
            @endif
            <div class="invoice-item">
                <span class="invoice-item-label">Membership Package:</span>
                <span class="invoice-item-value">{{ $data['package_type'] ?? "N/A" }}</span>
            </div>
            <div class="invoice-item">
                <span class="invoice-item-label">Registered On:</span>
                <span class="invoice-item-value">{{ $data['created_at'] ?? "" }}</span>
            </div>
            @if(isset($data['end_date']))
            <div class="invoice-item">
                <span class="invoice-item-label">Expires On:</span>
                <span class="invoice-item-value">{{ $data['end_date'] }}</span>
            </div>
            @endif
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

    <p>Thank you and have a great day!</p>
    
    <p><strong>Canadian Exports Team</strong></p>
@endsection
