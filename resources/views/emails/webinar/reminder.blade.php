<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webinar Reminder</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #059669; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; }
        .details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .details-row { display: flex; padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
        .details-label { font-weight: bold; width: 150px; }
        .button { display: inline-block; background: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin-top: 20px; }
        .countdown { background: #fef3c7; border: 2px solid #f59e0b; padding: 15px; border-radius: 8px; text-align: center; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>⏰ Webinar Reminder</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $registration->name }},</p>
        
        <div class="countdown">
            @if($reminderType === '1_hour')
                <strong>🔔 Your webinar starts in 1 HOUR!</strong>
            @else
                <strong>📅 Your webinar is TOMORROW!</strong>
            @endif
        </div>
        
        <p>This is a friendly reminder about the upcoming webinar you registered for:</p>
        
        <div class="details">
            <div class="details-row">
                <span class="details-label">Webinar:</span>
                <span>{{ $webinar->title }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Presenter:</span>
                <span>{{ $webinar->presenter_name ?? 'TBA' }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Date & Time:</span>
                <span>{{ \Carbon\Carbon::parse($webinar->scheduled_at)->format('l, F j, Y \a\t g:i A') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Duration:</span>
                <span>{{ $webinar->duration_minutes }} minutes</span>
            </div>
        </div>
        
        @if($webinar->meeting_link)
        <p>Click the button below to join when the webinar starts:</p>
        <a href="{{ $webinar->meeting_link }}" class="button">Join Webinar</a>
        @endif
        
        <p style="margin-top: 30px;">We look forward to seeing you there!</p>
        
        <p>Best regards,<br>The Canadian Exports Team</p>
    </div>
    
    <div class="footer">
        <p>You received this email because you registered for a webinar on our website.</p>
    </div>
</body>
</html>

