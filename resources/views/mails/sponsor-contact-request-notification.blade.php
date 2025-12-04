<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sponsor Contact Request</title>
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
            background-color: #ffc107;
            color: #333;
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
            border-left: 4px solid #ffc107;
        }
        .label {
            font-weight: bold;
            color: #856404;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
        .highlight {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📞 Sponsor Contact Request</h1>
        </div>
        
        <div class="content">
            <div class="highlight">
                <strong>⚠️ Action Required:</strong> A potential sponsor wants to talk to you before making a decision.
            </div>
            
            <p>A potential sponsor has submitted a "Talk to Us First" request. Please contact them at your earliest convenience.</p>
            
            <div class="detail-row">
                <span class="label">Company Name:</span>
                <div>{{ $sponsor->business_name }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Contact Person:</span>
                <div>{{ $sponsor->talk_to_us_name ?? $sponsor->contact_name }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Email:</span>
                <div>{{ $sponsor->email }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Phone Number:</span>
                <div>{{ $sponsor->talk_to_us_phone ?? $sponsor->contact_number }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Preferred Call Time:</span>
                <div>{{ ucfirst($sponsor->preferred_call_time ?? 'Not specified') }}</div>
            </div>
            
            @if($sponsor->preferred_call_date)
            <div class="detail-row">
                <span class="label">Preferred Call Date:</span>
                <div>{{ $sponsor->preferred_call_date->format('F j, Y') }}</div>
            </div>
            @endif
            
            @if($sponsor->message)
            <div class="detail-row">
                <span class="label">Message:</span>
                <div>{{ $sponsor->message }}</div>
            </div>
            @endif
            
            <div class="detail-row">
                <span class="label">Submitted On:</span>
                <div>{{ $sponsor->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
            
            <div style="margin-top: 30px; padding: 20px; background-color: #fff3cd; border-radius: 5px;">
                <p style="margin: 0;">
                    <strong>📋 Note:</strong> This is a contact request, not a payment. The sponsor will complete payment after your conversation.
                </p>
            </div>
            
            @if(isset($data['admin_link']))
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ $data['admin_link'] }}" style="display: inline-block; padding: 12px 30px; background-color: #ffc107; color: #333; text-decoration: none; border-radius: 5px; font-weight: bold;">
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

