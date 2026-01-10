@extends('mails.layouts.receipt')

@section('content')
    <h2>Hello {{ $data['name'] ?? 'Customer' }},</h2>
    
    <p>Thank you for your payment! We have successfully received your payment and processed your transaction.</p>
    
    <div class="receipt-box">
        <div class="receipt-item">
            <span class="receipt-label">Transaction ID:</span>
            <span class="receipt-value">{{ $data['transaction_id'] ?? 'N/A' }}</span>
        </div>
        <div class="receipt-item">
            <span class="receipt-label">Payment Date:</span>
            <span class="receipt-value">{{ $data['payment_date'] ?? date('F d, Y') }}</span>
        </div>
        <div class="receipt-item">
            <span class="receipt-label">Payment Method:</span>
            <span class="receipt-value">{{ $data['payment_method'] ?? 'Credit Card' }}</span>
        </div>
        <div class="receipt-item">
            <span class="receipt-label">Description:</span>
            <span class="receipt-value">{{ $data['description'] ?? 'Service Payment' }}</span>
        </div>
        <div class="receipt-item receipt-total">
            <span class="receipt-label">Total Amount:</span>
            <span class="receipt-value">${{ number_format($data['amount'] ?? 0, 2) }}</span>
        </div>
    </div>
    
    <p>Your payment has been processed successfully. You will receive a confirmation email shortly with your receipt details.</p>
    
    <p>If you have any questions about this transaction, please don't hesitate to contact our support team.</p>
    
    <p>Thank you for your business!</p>
    
    <p><strong>Canadian Exports Team</strong></p>
@endsection
