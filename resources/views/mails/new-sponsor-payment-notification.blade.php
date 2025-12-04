<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Sponsor Payment Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background-color: white;
            padding: 30px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .detail-row {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        .label {
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
        .amount {
            font-size: 24px;
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 New Sponsor Payment Received!</h1>
        </div>
        
        <div class="content">
            <p>A new sponsor has completed their payment and is now <strong>LIVE</strong> on the website.</p>
            
            <div class="detail-row">
                <span class="label">Company Name:</span>
                <div>{{ $sponsor->business_name }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Contact Name:</span>
                <div>{{ $sponsor->contact_name }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Email:</span>
                <div>{{ $sponsor->email }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Phone:</span>
                <div>{{ $sponsor->contact_number }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Sponsorship Amount:</span>
                <div class="amount">${{ number_format($sponsor->sponsorship_amount, 2) }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Payment Method:</span>
                <div>{{ ucfirst($sponsor->payment_method) }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Transaction ID:</span>
                <div>{{ $sponsor->transaction_id }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Date & Time:</span>
                <div>{{ $sponsor->paid_at ? $sponsor->paid_at->format('F j, Y \a\t g:i A') : 'N/A' }}</div>
            </div>
            
            @if($sponsor->relationLoaded('beneficiaries') && $sponsor->beneficiaries->isNotEmpty())
            <div class="detail-row">
                <span class="label">Beneficiaries:</span>
                <div>
                    @foreach($sponsor->beneficiaries as $beneficiary)
                        <div>{{ $beneficiary->name }}</div>
                    @endforeach
                </div>
            </div>
            @elseif($sponsor->beneficiary)
            <div class="detail-row">
                <span class="label">Beneficiary:</span>
                <div>{{ $sponsor->beneficiary->name }}</div>
            </div>
            @endif
            
            <div style="margin-top: 30px; padding: 20px; background-color: #e7f3ff; border-radius: 5px;">
                <p style="margin: 0;">
                    <strong>✅ Status:</strong> The sponsor has been automatically approved and is now visible on the website.
                </p>
            </div>
            
            @if(isset($data['admin_link']))
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ $data['admin_link'] }}" style="display: inline-block; padding: 12px 30px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
                    View in Admin Panel
                </a>
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p>This is an automated notification from Canadian Exporters</p>
        </div>
    </div>
</body>
</html>

