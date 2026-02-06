<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sponsor Downgrade Request</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; }
        .header { background-color: #0d6efd; color: #fff; padding: 20px; text-align: center; }
        .content { background-color: white; padding: 30px; margin-top: 20px; border-radius: 5px; }
        .detail-row { margin-bottom: 15px; padding: 10px; background-color: #f8f9fa; border-left: 4px solid #0d6efd; }
        .label { font-weight: bold; color: #0d6efd; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
        .highlight { background-color: #e7f1ff; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #0d6efd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sponsor downgrade requested</h1>
        </div>
        <div class="content">
            <div class="highlight">
                <strong>Action required:</strong> A sponsor has requested to downgrade their plan. The change will take effect at the end of their current billing period unless you process an immediate downgrade.
            </div>
            <p><strong>Sponsor details</strong></p>
            <div class="detail-row">
                <span class="label">Company:</span> {{ $sponsor->business_name }}
            </div>
            <div class="detail-row">
                <span class="label">Contact:</span> {{ $sponsor->contact_name }}
            </div>
            <div class="detail-row">
                <span class="label">Email:</span> {{ $sponsor->email }}
            </div>
            <div class="detail-row">
                <span class="label">Phone:</span> {{ $sponsor->contact_number }}
            </div>
            <p class="mt-4"><strong>Current plan</strong></p>
            <div class="detail-row">
                <span class="label">Amount:</span> ${{ number_format($request->current_amount, 2) }} / {{ $request->current_frequency }}
            </div>
            <div class="detail-row">
                <span class="label">Current period ends:</span> {{ $request->current_period_end ? $request->current_period_end->format('F j, Y') : 'N/A' }}
            </div>
            <p class="mt-4"><strong>Requested plan</strong></p>
            <div class="detail-row">
                <span class="label">New amount:</span> ${{ number_format($request->requested_amount, 2) }} / {{ $request->requested_frequency }}
            </div>
            <div class="detail-row">
                <span class="label">Requested on:</span> {{ $request->requested_at->format('F j, Y \a\t g:i A') }}
            </div>
        </div>
        <div class="footer">
            <p>This is an automated notification from Canadian Exports.</p>
        </div>
    </div>
</body>
</html>
